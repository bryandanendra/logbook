@extends('layouts.app')

@section('title', 'Dashboard - Logbook System')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-dark">Dashboard</h1>
        <div class="flex space-x-2">
            @if(!$activeSession)
                <a href="{{ route('work-sessions.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-orange-600">
                    <i class="fas fa-play mr-2"></i>Mulai Kerja
                </a>
            @else
                <span class="bg-green-500 text-white px-4 py-2 rounded-md">
                    <i class="fas fa-clock mr-2"></i>Sedang Bekerja
                </span>
            @endif
            <a href="{{ route('tasks.today') }}" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 relative group">
                <i class="fas fa-calendar-day mr-2"></i>Hari Ini
                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
                    📅 Lihat tugas yang dibuat hari ini
                </div>
            </a>
            <a href="{{ route('tasks.pending') }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 relative group">
                <i class="fas fa-clock mr-2"></i>Pending
                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
                    ⏳ Lihat tugas yang belum dikerjakan
                </div>
            </a>
            <a href="{{ route('reports.analytics') }}" class="bg-secondary text-white px-4 py-2 rounded-md hover:bg-blue-600 relative group">
                <i class="fas fa-chart-line mr-2"></i>Analytics
                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
                    📊 Lihat analisis performa bulan ini
                </div>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-primary relative group">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-primary bg-opacity-10">
                    <i class="fas fa-tasks text-primary text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-secondary">Total Tugas</p>
                    <p class="text-2xl font-semibold text-dark">{{ $todayTasks->count() }}</p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                📅 Tugas yang dibuat hari ini ({{ now()->format('d M Y') }})
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500 relative group">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-500 bg-opacity-10">
                    <i class="fas fa-check text-green-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-secondary">Selesai</p>
                    <p class="text-2xl font-semibold text-dark">{{ $todayTasks->where('status', 'completed')->count() }}</p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                ✅ Tugas dengan status 'completed' hari ini
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500 relative group">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-500 bg-opacity-10">
                    <i class="fas fa-clock text-yellow-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-secondary">Pending</p>
                    <p class="text-2xl font-semibold text-dark">{{ $todayTasks->where('status', 'pending')->count() }}</p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                ⏳ Tugas dengan status 'pending' hari ini
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-secondary relative group">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-secondary bg-opacity-10">
                    <i class="fas fa-chart-line text-secondary text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-secondary">Jam Kerja</p>
                    <p class="text-2xl font-semibold text-dark">{{ number_format($weeklyStats['total_hours'], 1) }}h</p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                ⏰ Total jam dari sesi kerja yang sudah selesai minggu ini ({{ now()->startOfWeek()->format('d M') }} - {{ now()->endOfWeek()->format('d M') }})
            </div>
        </div>
    </div>

    @if($activeSession)
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-dark">Sesi Kerja Aktif</h2>
            <a href="{{ route('work-sessions.show', $activeSession) }}" class="text-primary hover:text-orange-600">
                <i class="fas fa-eye mr-2"></i>Lihat Detail
            </a>
        </div>
        <div class="bg-light p-4 rounded-md">
            <p class="text-secondary"><strong>Mulai:</strong> {{ $activeSession->start_time->format('H:i, d M Y') }}</p>
            <p class="text-secondary"><strong>Durasi:</strong> {{ $activeSession->start_time->diffForHumans() }}</p>
            @if($activeSession->notes)
                <p class="text-secondary mt-2"><strong>Catatan:</strong> {{ $activeSession->notes }}</p>
            @endif
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-dark mb-4">Tugas Hari Ini</h2>
            @if($todayTasks->count() > 0)
                <div class="space-y-3">
                    @foreach($todayTasks as $task)
                    <div class="flex items-center justify-between p-3 bg-light rounded-md">
                        <div>
                            <h3 class="font-medium text-dark">{{ $task->title }}</h3>
                            <p class="text-sm text-secondary">{{ $task->description }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if($task->status === 'pending')
                                <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                            @elseif($task->status === 'in_progress')
                                <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">Proses</span>
                            @else
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Selesai</span>
                            @endif
                            <a href="{{ route('tasks.show', $task) }}" class="text-primary hover:text-orange-600">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-secondary text-center py-4">Belum ada tugas hari ini</p>
            @endif
            <div class="mt-4">
                <a href="{{ route('tasks.create') }}" class="text-primary hover:text-orange-600">
                    <i class="fas fa-plus mr-2"></i>Tambah Tugas
                </a>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-dark mb-4">Tugas Terbaru</h2>
            @if($recentTasks->count() > 0)
                <div class="space-y-3">
                    @foreach($recentTasks as $task)
                    <div class="flex items-center justify-between p-3 bg-light rounded-md">
                        <div>
                            <h3 class="font-medium text-dark">{{ $task->title }}</h3>
                            <p class="text-sm text-secondary">{{ $task->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if($task->priority === 'high')
                                <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">High</span>
                            @elseif($task->priority === 'medium')
                                <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Medium</span>
                            @else
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Low</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-secondary text-center py-4">Belum ada tugas</p>
            @endif
            <div class="mt-4">
                <a href="{{ route('tasks.index') }}" class="text-primary hover:text-orange-600">
                    <i class="fas fa-list mr-2"></i>Lihat Semua
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
