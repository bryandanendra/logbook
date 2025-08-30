@extends('layouts.app')

@section('title', 'Tugas - Logbook System')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-dark">Daftar Tugas</h1>
        <div class="flex space-x-2">
            <a href="{{ route('tasks.today') }}" class="bg-secondary text-white px-4 py-2 rounded-md hover:bg-blue-600">
                <i class="fas fa-calendar-day mr-2"></i>Hari Ini
            </a>
            <a href="{{ route('tasks.pending') }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600">
                <i class="fas fa-clock mr-2"></i>Pending
            </a>
            <a href="{{ route('tasks.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-orange-600">
                <i class="fas fa-plus mr-2"></i>Tambah Tugas
            </a>
        </div>
    </div>

    @if($tasks->count() > 0)
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider">Prioritas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider">Deadline</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider">Dibuat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($tasks as $task)
                        <tr>
                            <td class="px-6 py-4">
                                <div>
                                    <div class="text-sm font-medium text-dark">{{ $task->title }}</div>
                                    @if($task->description)
                                        <div class="text-sm text-secondary truncate max-w-xs">{{ $task->description }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($task->status === 'pending')
                                    <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                                @elseif($task->status === 'in_progress')
                                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">Proses</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Selesai</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($task->priority === 'high')
                                    <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">High</span>
                                @elseif($task->priority === 'medium')
                                    <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Medium</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Low</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-dark">
                                {{ $task->due_date ? $task->due_date->format('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary relative group">
                                <span class="cursor-help">{{ $task->created_at->format('d M Y H:i') }}</span>
                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
                                    📅 Dibuat {{ $task->created_at->diffForHumans() }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('tasks.show', $task) }}" class="text-primary hover:text-orange-600">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('tasks.edit', $task) }}" class="text-secondary hover:text-blue-600">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus tugas ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-4">
            {{ $tasks->links() }}
        </div>
    @else
        <div class="bg-white p-8 rounded-lg shadow-md text-center">
            <i class="fas fa-tasks text-4xl text-secondary mb-4"></i>
            <h3 class="text-lg font-medium text-dark mb-2">Belum ada tugas</h3>
            <p class="text-secondary mb-4">Mulai dengan membuat tugas pertama kamu!</p>
            <a href="{{ route('tasks.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-orange-600">
                <i class="fas fa-plus mr-2"></i>Buat Tugas Pertama
            </a>
        </div>
    @endif
</div>
@endsection
