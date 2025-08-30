<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkSession;
use App\Models\Task;
use App\Models\WeeklyReport;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $activeSession = WorkSession::where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        $todayTasks = Task::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->get();

        $weeklyStats = $this->getWeeklyStats($user->id);
        
        $recentTasks = Task::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'activeSession',
            'todayTasks',
            'weeklyStats',
            'recentTasks'
        ));
    }

    private function getWeeklyStats($userId)
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $tasksCompleted = Task::where('user_id', $userId)
            ->where('status', 'completed')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->count();

        $tasksPending = Task::where('user_id', $userId)
            ->where('status', 'pending')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->count();

        $totalHours = WorkSession::where('user_id', $userId)
            ->where('status', 'completed')
            ->whereBetween('start_time', [$startOfWeek, $endOfWeek])
            ->get()
            ->sum(function ($session) {
                if ($session->end_time) {
                    $diffInMinutes = $session->start_time->diffInMinutes($session->end_time);
                    return round($diffInMinutes / 60, 2);
                }
                return 0;
            });

        return [
            'tasks_completed' => $tasksCompleted,
            'tasks_pending' => $tasksPending,
            'total_hours' => $totalHours,
        ];
    }
}
