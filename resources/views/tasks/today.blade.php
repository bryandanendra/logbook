@extends('layouts.app')

@section('title', 'Tugas Hari Ini - Logbook System')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-dark">Tugas Hari Ini</h1>
        <div class="flex space-x-2">
            <a href="{{ route('tasks.index') }}" class="bg-secondary text-white px-4 py-2 rounded-md hover:bg-blue-600">
                <i class="fas fa-list mr-2"></i>Semua Tugas
            </a>
            <a href="{{ route('tasks.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-orange-600">
                <i class="fas fa-plus mr-2"></i>Tambah Tugas
            </a>
        </div>
    </div>

    <div class="bg-white p-4 rounded-lg shadow-md">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-dark">{{ now()->format('l, d F Y') }}</h2>
            <span class="text-sm text-secondary">{{ $todayTasks->count() }} tugas</span>
        </div>

        @if($todayTasks->count() > 0)
            <div class="space-y-4">
                @foreach($todayTasks as $task)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex-1">
                            <h3 class="font-medium text-dark text-lg">{{ $task->title }}</h3>
                            @if($task->description)
                                <p class="text-secondary mt-1">{{ $task->description }}</p>
                            @endif
                        </div>
                        <div class="flex items-center space-x-2 ml-4">
                            @if($task->priority === 'high')
                                <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">High</span>
                            @elseif($task->priority === 'medium')
                                <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Medium</span>
                            @else
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Low</span>
                            @endif
                            
                            @if($task->status === 'pending')
                                <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                            @elseif($task->status === 'in_progress')
                                <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">Proses</span>
                            @else
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Selesai</span>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4 text-sm text-secondary">
                            <span><i class="fas fa-clock mr-1"></i>{{ $task->created_at->format('H:i') }}</span>
                            @if($task->due_date)
                                <span><i class="fas fa-calendar mr-1"></i>Deadline: {{ $task->due_date->format('H:i') }}</span>
                            @endif
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <form action="{{ route('tasks.update-status', $task) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" 
                                        class="text-xs border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-primary focus:border-primary">
                                    <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>Proses</option>
                                    <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </form>
                            
                            <a href="{{ route('tasks.show', $task) }}" class="text-primary hover:text-orange-600">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('tasks.edit', $task) }}" class="text-secondary hover:text-blue-600">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-6 pt-4 border-t">
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div class="bg-yellow-50 p-3 rounded-lg">
                        <div class="text-2xl font-bold text-yellow-600">{{ $todayTasks->where('status', 'pending')->count() }}</div>
                        <div class="text-sm text-yellow-700">Pending</div>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $todayTasks->where('status', 'in_progress')->count() }}</div>
                        <div class="text-sm text-blue-700">Proses</div>
                    </div>
                    <div class="bg-green-50 p-3 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $todayTasks->where('status', 'completed')->count() }}</div>
                        <div class="text-sm text-green-700">Selesai</div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-calendar-day text-4xl text-secondary mb-4"></i>
                <h3 class="text-lg font-medium text-dark mb-2">Tidak ada tugas hari ini</h3>
                <p class="text-secondary mb-4">Mulai dengan membuat tugas untuk hari ini!</p>
                <a href="{{ route('tasks.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-orange-600">
                    <i class="fas fa-plus mr-2"></i>Buat Tugas
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
