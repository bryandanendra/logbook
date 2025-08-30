<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Task;
use App\Models\WorkSession;
use App\Models\WeeklyReport;
use Carbon\Carbon;

class AdminController extends Controller
{


    public function dashboard()
    {
        $totalEmployees = User::where('role', 'estimator')->count();
        $activeEmployees = WorkSession::where('status', 'active')->count();
        
        $todayStats = $this->getTodayStats();
        $weeklyStats = $this->getWeeklyStats();
        $departmentStats = $this->getDepartmentStats();
        
        $recentActivities = $this->getRecentActivities();
        
        return view('admin.dashboard', compact(
            'totalEmployees',
            'activeEmployees',
            'todayStats',
            'weeklyStats',
            'departmentStats',
            'recentActivities'
        ));
    }

    public function employees()
    {
        $employees = User::where('role', 'estimator')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.employees.index', compact('employees'));
    }

    public function createEmployee()
    {
        return view('admin.employees.create');
    }

    public function storeEmployee(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'department' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'employee_id' => 'required|string|unique:users',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'estimator',
            'department' => $request->department,
            'position' => $request->position,
            'employee_id' => $request->employee_id,
            'is_active' => true,
        ]);

        return redirect()->route('admin.employees')
            ->with('success', 'Karyawan berhasil ditambahkan!');
    }

    public function editEmployee(User $employee)
    {
        if ($employee->role !== 'estimator') {
            abort(404);
        }

        return view('admin.employees.edit', compact('employee'));
    }

    public function updateEmployee(Request $request, User $employee)
    {
        if ($employee->role !== 'estimator') {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $employee->id,
            'department' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'employee_id' => 'required|string|unique:users,employee_id,' . $employee->id,
            'is_active' => 'boolean',
        ]);

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'department' => $request->department,
            'position' => $request->position,
            'employee_id' => $request->employee_id,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.employees')
            ->with('success', 'Data karyawan berhasil diupdate!');
    }

    public function showEmployee(User $employee)
    {
        if ($employee->role !== 'estimator') {
            abort(404);
        }

        $recentTasks = $employee->tasks()->orderBy('created_at', 'desc')->limit(10)->get();
        $recentSessions = $employee->workSessions()->orderBy('created_at', 'desc')->limit(10)->get();
        $weeklyStats = $this->getEmployeeWeeklyStats($employee->id);

        return view('admin.employees.show', compact('employee', 'recentTasks', 'recentSessions', 'weeklyStats'));
    }

    public function companyReports()
    {
        $startDate = request('start_date', Carbon::now()->startOfMonth());
        $endDate = request('end_date', Carbon::now()->endOfMonth());

        $reports = WeeklyReport::with('user')
            ->whereBetween('week_start', [$startDate, $endDate])
            ->orderBy('week_start', 'desc')
            ->paginate(15);

        $summary = $this->getCompanySummary($startDate, $endDate);

        return view('admin.reports.index', compact('reports', 'summary', 'startDate', 'endDate'));
    }

    public function analytics()
    {
        try {
            $companyStats = $this->getCompanyStats();
            $monthlyTrends = $this->getMonthlyTrends();
            $departmentPerformance = $this->getDepartmentPerformance();
            $taskAnalytics = $this->getTaskAnalytics();
            $taskDistribution = $taskAnalytics['by_status'];
            $productivityChart = $this->getProductivityChart();
            $topPerformers = $this->getTopPerformers();

            return view('admin.analytics', compact(
                'companyStats',
                'monthlyTrends',
                'departmentPerformance',
                'taskDistribution',
                'taskAnalytics',
                'productivityChart',
                'topPerformers'
            ));
        } catch (\Exception $e) {
            \Log::error('Admin Analytics Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat analytics: ' . $e->getMessage());
        }
    }

    private function getTodayStats()
    {
        $today = Carbon::today();
        
        return [
            'total_tasks' => Task::whereDate('created_at', $today)->count(),
            'completed_tasks' => Task::whereDate('created_at', $today)->where('status', 'completed')->count(),
            'active_sessions' => WorkSession::where('status', 'active')->count(),
            'total_hours' => WorkSession::where('status', 'completed')
                ->whereDate('start_time', $today)
                ->get()
                ->sum(function ($session) {
                    return $session->start_time->diffInHours($session->end_time);
                }),
        ];
    }

    private function getWeeklyStats()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        return [
            'total_tasks' => Task::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count(),
            'completed_tasks' => Task::whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->where('status', 'completed')->count(),
            'total_hours' => WorkSession::where('status', 'completed')
                ->whereBetween('start_time', [$startOfWeek, $endOfWeek])
                ->get()
                ->sum(function ($session) {
                    return $session->start_time->diffInHours($session->end_time);
                }),
        ];
    }

    private function getDepartmentStats()
    {
        return User::where('role', 'estimator')
            ->selectRaw('department, COUNT(*) as total_employees')
            ->groupBy('department')
            ->get();
    }

    private function getRecentActivities()
    {
        $tasks = Task::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $sessions = WorkSession::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return $tasks->merge($sessions)->sortByDesc('created_at')->take(10);
    }

    private function getEmployeeWeeklyStats($userId)
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $tasks = Task::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->get();

        return [
            'total_tasks' => $tasks->count(),
            'completed_tasks' => $tasks->where('status', 'completed')->count(),
            'productivity' => $tasks->count() > 0 ? 
                ($tasks->where('status', 'completed')->count() / $tasks->count()) * 100 : 0,
        ];
    }

    private function getCompanySummary($startDate, $endDate)
    {
        $reports = WeeklyReport::whereBetween('week_start', [$startDate, $endDate])->get();

        return [
            'total_reports' => $reports->count(),
            'avg_productivity' => $reports->avg('productivity_score'),
            'total_hours' => $reports->sum('total_hours'),
            'total_tasks_completed' => $reports->sum('tasks_completed'),
        ];
    }

    private function getMonthlyTrends()
    {
        $months = collect();
        
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $startOfMonth = $month->copy()->startOfMonth();
            $endOfMonth = $month->copy()->endOfMonth();
            
            $tasks = Task::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();
            
            $months->push([
                'month' => $month->format('M Y'),
                'total_tasks' => $tasks->count(),
                'completed_tasks' => $tasks->where('status', 'completed')->count(),
            ]);
        }
        
        return $months;
    }

    private function getDepartmentPerformance()
    {
        return User::where('role', 'estimator')
            ->with(['tasks' => function ($query) {
                $query->where('created_at', '>=', Carbon::now()->subMonth());
            }])
            ->get()
            ->groupBy('department')
            ->map(function ($users, $department) {
                $totalTasks = $users->flatMap->tasks->count();
                $completedTasks = $users->flatMap->tasks->where('status', 'completed')->count();
                $avgProductivity = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
                
                return (object) [
                    'department' => $department,
                    'total_employees' => $users->count(),
                    'total_tasks' => $totalTasks,
                    'avg_productivity' => $avgProductivity,
                ];
            })
            ->values();
    }

    private function getTaskAnalytics()
    {
        $tasks = Task::where('created_at', '>=', Carbon::now()->subMonth())->get();
        
        return [
            'by_status' => [
                'pending' => $tasks->where('status', 'pending')->count(),
                'in_progress' => $tasks->where('status', 'in_progress')->count(),
                'completed' => $tasks->where('status', 'completed')->count(),
            ],
            'by_priority' => [
                'low' => $tasks->where('priority', 'low')->count(),
                'medium' => $tasks->where('priority', 'medium')->count(),
                'high' => $tasks->where('priority', 'high')->count(),
            ],
        ];
    }

    private function getProductivityChart()
    {
        $weeks = collect();
        
        for ($i = 3; $i >= 0; $i--) {
            $weekStart = Carbon::now()->subWeeks($i)->startOfWeek();
            $weekEnd = Carbon::now()->subWeeks($i)->endOfWeek();
            
            $reports = WeeklyReport::whereBetween('week_start', [$weekStart, $weekEnd])->get();
            
            $weeks->push([
                'week' => $weekStart->format('d M'),
                'avg_productivity' => $reports->avg('productivity_score'),
                'total_hours' => $reports->sum('total_hours'),
            ]);
        }
        
        return $weeks;
    }

    private function getCompanyStats()
    {
        $totalEmployees = User::where('role', 'estimator')->count();
        $totalTasks = Task::count();
        $completedTasks = Task::where('status', 'completed')->count();
        $activeEmployees = User::where('role', 'estimator')->where('is_active', true)->count();
        
        $totalHours = WorkSession::where('status', 'completed')
            ->get()
            ->sum(function ($session) {
                return round($session->start_time->diffInMinutes($session->end_time) / 60, 2);
            });
        
        $avgProductivity = WeeklyReport::avg('productivity_score') ?? 0;
        
        return [
            'total_employees' => $totalEmployees,
            'total_tasks' => $totalTasks,
            'completed_tasks' => $completedTasks,
            'active_employees' => $activeEmployees,
            'total_hours' => number_format($totalHours, 1),
            'avg_productivity' => $avgProductivity,
        ];
    }

    private function getTopPerformers()
    {
        return WeeklyReport::with('user')
            ->where('productivity_score', '>', 0)
            ->orderBy('productivity_score', 'desc')
            ->limit(5)
            ->get();
    }
}
