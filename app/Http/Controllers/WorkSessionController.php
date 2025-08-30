<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkSession;
use Carbon\Carbon;

class WorkSessionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $sessions = WorkSession::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('work-sessions.index', compact('sessions'));
    }

    public function create()
    {
        $activeSession = WorkSession::where('user_id', Auth::id())
            ->where('status', 'active')
            ->first();

        if ($activeSession) {
            return redirect()->route('work-sessions.show', $activeSession)
                ->with('warning', 'Kamu masih punya sesi kerja yang aktif!');
        }

        return view('work-sessions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        $session = WorkSession::create([
            'user_id' => Auth::id(),
            'start_time' => Carbon::now(),
            'status' => 'active',
            'notes' => $request->notes,
        ]);

        return redirect()->route('work-sessions.show', $session)
            ->with('success', 'Sesi kerja dimulai!');
    }

    public function show(WorkSession $workSession)
    {
        if ($workSession->user_id !== Auth::id()) {
            abort(403);
        }

        $tasks = $workSession->tasks()->orderBy('created_at', 'desc')->get();

        return view('work-sessions.show', compact('workSession', 'tasks'));
    }

    public function edit(WorkSession $workSession)
    {
        if ($workSession->user_id !== Auth::id()) {
            abort(403);
        }

        return view('work-sessions.edit', compact('workSession'));
    }

    public function update(Request $request, WorkSession $workSession)
    {
        if ($workSession->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        $workSession->update([
            'notes' => $request->notes,
        ]);

        return redirect()->route('work-sessions.show', $workSession)
            ->with('success', 'Sesi kerja berhasil diupdate!');
    }

    public function destroy(WorkSession $workSession)
    {
        if ($workSession->user_id !== Auth::id()) {
            abort(403);
        }

        $workSession->delete();

        return redirect()->route('work-sessions.index')
            ->with('success', 'Sesi kerja berhasil dihapus!');
    }

    public function endSession(WorkSession $workSession)
    {
        if ($workSession->user_id !== Auth::id()) {
            abort(403);
        }

        if ($workSession->status === 'completed') {
            return back()->with('warning', 'Sesi kerja sudah selesai!');
        }

        $workSession->update([
            'end_time' => Carbon::now(),
            'status' => 'completed',
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Sesi kerja selesai! Selamat beristirahat.');
    }

    public function startSession()
    {
        $activeSession = WorkSession::where('user_id', Auth::id())
            ->where('status', 'active')
            ->first();

        if ($activeSession) {
            return redirect()->route('work-sessions.show', $activeSession)
                ->with('warning', 'Kamu masih punya sesi kerja yang aktif!');
        }

        $session = WorkSession::create([
            'user_id' => Auth::id(),
            'start_time' => Carbon::now(),
            'status' => 'active',
        ]);

        return redirect()->route('work-sessions.show', $session)
            ->with('success', 'Sesi kerja dimulai!');
    }
}
