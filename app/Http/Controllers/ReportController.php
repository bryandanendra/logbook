<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\WorkSession;
use App\Models\WeeklyReport;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $reports = WeeklyReport::where('user_id', $user->id)
            ->orderBy('week_start', 'desc')
            ->paginate(10);

        return view('reports.index', compact('reports'));
    }

    public function show(WeeklyReport $weeklyReport)
    {
        if ($weeklyReport->user_id !== Auth::id()) {
            abort(403);
        }

        $tasks = Task::where('user_id', $weeklyReport->user_id)
            ->whereBetween('created_at', [$weeklyReport->week_start, $weeklyReport->week_end])
            ->get();

        $sessions = WorkSession::where('user_id', $weeklyReport->user_id)
            ->whereBetween('start_time', [$weeklyReport->week_start, $weeklyReport->week_end])
            ->get();

        return view('reports.show', compact('weeklyReport', 'tasks', 'sessions'));
    }

    public function generateWeekly()
    {
        $user = Auth::user();
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $existingReport = WeeklyReport::where('user_id', $user->id)
            ->where('week_start', $startOfWeek)
            ->first();

        if ($existingReport) {
            return redirect()->route('reports.show', $existingReport)
                ->with('warning', 'Laporan mingguan sudah ada!');
        }

        $tasks = Task::where('user_id', $user->id)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->get();

        $sessions = WorkSession::where('user_id', $user->id)
            ->where('status', 'completed')
            ->whereBetween('start_time', [$startOfWeek, $endOfWeek])
            ->get();

        $totalHours = $sessions->sum(function ($session) {
            if ($session->end_time) {
                $diffInMinutes = $session->start_time->diffInMinutes($session->end_time);
                return round($diffInMinutes / 60, 2);
            }
            return 0;
        });

        $tasksCompleted = $tasks->where('status', 'completed')->count();
        $tasksPending = $tasks->where('status', 'pending')->count();
        $totalTasks = $tasks->count();

        $productivityScore = $totalTasks > 0 ? ($tasksCompleted / $totalTasks) * 100 : 0;

        $report = WeeklyReport::create([
            'user_id' => $user->id,
            'week_start' => $startOfWeek,
            'week_end' => $endOfWeek,
            'total_hours' => $totalHours,
            'tasks_completed' => $tasksCompleted,
            'tasks_pending' => $tasksPending,
            'productivity_score' => $productivityScore,
            'notes' => "Laporan otomatis untuk minggu {$startOfWeek->format('d M Y')} - {$endOfWeek->format('d M Y')}",
        ]);

        return redirect()->route('reports.show', $report)
            ->with('success', 'Laporan mingguan berhasil dibuat!');
    }

    public function analytics()
    {
        $user = Auth::user();
        
        $currentMonth = Carbon::now(); // Bulan ini, bukan bulan lalu
        
        $monthlyStats = $this->getMonthlyStats($user->id, $currentMonth);
        $weeklyTrends = $this->getWeeklyTrends($user->id);
        $taskDistribution = $this->getTaskDistribution($user->id);
        
        return view('reports.analytics', compact('monthlyStats', 'weeklyTrends', 'taskDistribution'));
    }

    private function getMonthlyStats($userId, $month)
    {
        $startOfMonth = $month->copy()->startOfMonth();
        $endOfMonth = $month->copy()->endOfMonth();

        $tasks = Task::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->get();

        $sessions = WorkSession::where('user_id', $userId)
            ->where('status', 'completed')
            ->whereBetween('start_time', [$startOfMonth, $endOfMonth])
            ->get();

        return [
            'total_tasks' => $tasks->count(),
            'completed_tasks' => $tasks->where('status', 'completed')->count(),
            'total_hours' => $sessions->sum(function ($session) {
                if ($session->end_time) {
                    $diffInMinutes = $session->start_time->diffInMinutes($session->end_time);
                    return round($diffInMinutes / 60, 2);
                }
                return 0;
            }),
            'avg_productivity' => $tasks->count() > 0 ? 
                ($tasks->where('status', 'completed')->count() / $tasks->count()) * 100 : 0,
        ];
    }

    private function getWeeklyTrends($userId)
    {
        $weeks = collect();
        
        for ($i = 3; $i >= 0; $i--) {
            $weekStart = Carbon::now()->subWeeks($i)->startOfWeek();
            $weekEnd = Carbon::now()->subWeeks($i)->endOfWeek();
            
            $tasks = Task::where('user_id', $userId)
                ->whereBetween('created_at', [$weekStart, $weekEnd])
                ->get();
                
            $weeks->push([
                'week' => $weekStart->format('d M'),
                'total_tasks' => $tasks->count(),
                'completed_tasks' => $tasks->where('status', 'completed')->count(),
            ]);
        }
        
        return $weeks;
    }

    private function getTaskDistribution($userId)
    {
        $tasks = Task::where('user_id', $userId)
            ->where('created_at', '>=', Carbon::now()->subMonth())
            ->get();

        return [
            'pending' => $tasks->where('status', 'pending')->count(),
            'in_progress' => $tasks->where('status', 'in_progress')->count(),
            'completed' => $tasks->where('status', 'completed')->count(),
        ];
    }
}
