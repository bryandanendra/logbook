@extends('layouts.app')

@section('title', 'Detail Tugas - Logbook System')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-dark">Detail Tugas</h1>
        <div class="flex space-x-2">
            <a href="{{ route('tasks.edit', $task) }}" class="bg-secondary text-white px-4 py-2 rounded-md hover:bg-blue-600">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600" onclick="return confirm('Yakin ingin menghapus tugas ini?')">
                    <i class="fas fa-trash mr-2"></i>Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-dark mb-4">Informasi Tugas</h2>
            <div class="space-y-4">
                <div>
                    <h3 class="text-lg font-medium text-dark">{{ $task->title }}</h3>
                    @if($task->description)
                        <p class="text-secondary mt-2">{{ $task->description }}</p>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="text-secondary text-sm">Status:</span>
                        <div class="mt-1">
                            @if($task->status === 'pending')
                                <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                            @elseif($task->status === 'in_progress')
                                <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">Proses</span>
                            @else
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Selesai</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <span class="text-secondary text-sm">Prioritas:</span>
                        <div class="mt-1">
                            @if($task->priority === 'high')
                                <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">High</span>
                            @elseif($task->priority === 'medium')
                                <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Medium</span>
                            @else
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Low</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <span class="text-secondary text-sm">Dibuat:</span>
                        <p class="text-dark">{{ $task->created_at->format('d M Y H:i') }}</p>
                    </div>

                    <div>
                        <span class="text-secondary text-sm">Deadline:</span>
                        <p class="text-dark">{{ $task->due_date ? $task->due_date->format('d M Y H:i') : '-' }}</p>
                    </div>
                </div>

                @if($task->workSession)
                <div class="border-t pt-4">
                    <span class="text-secondary text-sm">Sesi Kerja:</span>
                    <p class="text-dark">{{ $task->workSession->start_time->format('d M Y H:i') }}</p>
                </div>
                @endif
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-dark mb-4">Update Status</h2>
            <form action="{{ route('tasks.update-status', $task) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-dark mb-2">Status Tugas</label>
                    <select id="status" name="status" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                        <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-primary text-white px-4 py-2 rounded-md hover:bg-orange-600">
                    <i class="fas fa-save mr-2"></i>Update Status
                </button>
            </form>
        </div>
    </div>

    <div class="flex justify-between">
        <a href="{{ route('tasks.index') }}" class="text-primary hover:text-orange-600">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
        </a>
        <div class="flex space-x-2">
            @if($task->status !== 'completed')
                <a href="{{ route('tasks.edit', $task) }}" class="bg-secondary text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    <i class="fas fa-edit mr-2"></i>Edit Tugas
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
