<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\WorkSession;

class TaskController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $tasks = Task::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $activeSession = WorkSession::where('user_id', Auth::id())
            ->where('status', 'active')
            ->first();

        if (!$activeSession) {
            return redirect()->route('work-sessions.create')
                ->with('warning', 'Kamu harus mulai sesi kerja dulu!');
        }

        return view('tasks.create', compact('activeSession'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date|after:now',
            'work_session_id' => 'required|exists:work_sessions,id',
        ]);

        $task = Task::create([
            'user_id' => Auth::id(),
            'work_session_id' => $request->work_session_id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'pending',
            'priority' => $request->priority,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Tugas berhasil ditambahkan!');
    }

    public function show(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Tugas berhasil diupdate!');
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Tugas berhasil dihapus!');
    }

    public function updateStatus(Task $task, Request $request)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task->update([
            'status' => $request->status,
        ]);

        $statusText = match($request->status) {
            'pending' => 'Belum dikerjakan',
            'in_progress' => 'Sedang dikerjakan',
            'completed' => 'Selesai',
        };

        return back()->with('success', "Status tugas diubah menjadi: {$statusText}");
    }

    public function today()
    {
        $user = Auth::user();
        $todayTasks = Task::where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tasks.today', compact('todayTasks'));
    }

    public function pending()
    {
        $user = Auth::user();
        $pendingTasks = Task::where('user_id', $user->id)
            ->where('status', 'pending')
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('tasks.pending', compact('pendingTasks'));
    }
}
