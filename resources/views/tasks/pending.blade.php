@extends('layouts.app')

@section('title', 'Tugas Pending - Logbook System')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-dark">Tugas Pending</h1>
        <div class="flex space-x-2">
            <a href="{{ route('tasks.index') }}" class="bg-secondary text-white px-4 py-2 rounded-md hover:bg-blue-600">
                <i class="fas fa-list mr-2"></i>Semua Tugas
            </a>
            <a href="{{ route('tasks.today') }}" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                <i class="fas fa-calendar-day mr-2"></i>Hari Ini
            </a>
            <a href="{{ route('tasks.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-orange-600">
                <i class="fas fa-plus mr-2"></i>Tambah Tugas
            </a>
        </div>
    </div>

    @if($pendingTasks->count() > 0)
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-4 bg-yellow-50 border-b">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-yellow-800">
                        <i class="fas fa-clock mr-2"></i>Tugas yang Belum Dikerjakan
                    </h2>
                    <span class="text-sm text-yellow-700">{{ $pendingTasks->count() }} tugas pending</span>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider">Prioritas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider">Deadline</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider">Dibuat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($pendingTasks as $task)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div>
                                    <div class="text-sm font-medium text-dark">{{ $task->title }}</div>
                                    @if($task->description)
                                        <div class="text-sm text-secondary truncate max-w-xs">{{ $task->description }}</div>
                                    @endif
                                </div>
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
                                @if($task->due_date)
                                    @if($task->due_date->isPast())
                                        <span class="text-red-600 font-medium">{{ $task->due_date->format('d M Y H:i') }}</span>
                                    @else
                                        {{ $task->due_date->format('d M Y H:i') }}
                                    @endif
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary">
                                {{ $task->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <form action="{{ route('tasks.update-status', $task) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" name="status" value="in_progress" 
                                                class="text-blue-600 hover:text-blue-900" title="Mulai Kerjakan">
                                            <i class="fas fa-play"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('tasks.show', $task) }}" class="text-primary hover:text-orange-600" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('tasks.edit', $task) }}" class="text-secondary hover:text-blue-600" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-4">
            {{ $pendingTasks->links() }}
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-dark mb-4">Ringkasan Prioritas</h3>
            <div class="grid grid-cols-3 gap-4">
                <div class="text-center p-4 bg-red-50 rounded-lg">
                    <div class="text-2xl font-bold text-red-600">{{ $pendingTasks->where('priority', 'high')->count() }}</div>
                    <div class="text-sm text-red-700">High Priority</div>
                </div>
                <div class="text-center p-4 bg-yellow-50 rounded-lg">
                    <div class="text-2xl font-bold text-yellow-600">{{ $pendingTasks->where('priority', 'medium')->count() }}</div>
                    <div class="text-sm text-yellow-700">Medium Priority</div>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <div class="text-2xl font-bold text-green-600">{{ $pendingTasks->where('priority', 'low')->count() }}</div>
                    <div class="text-sm text-green-700">Low Priority</div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white p-8 rounded-lg shadow-md text-center">
            <i class="fas fa-check-circle text-4xl text-green-500 mb-4"></i>
            <h3 class="text-lg font-medium text-dark mb-2">Tidak ada tugas pending!</h3>
            <p class="text-secondary mb-4">Semua tugas sudah selesai dikerjakan. Mantap! 🎉</p>
            <a href="{{ route('tasks.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-orange-600">
                <i class="fas fa-plus mr-2"></i>Buat Tugas Baru
            </a>
        </div>
    @endif
</div>
@endsection
