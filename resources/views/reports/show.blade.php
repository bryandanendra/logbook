@extends('layouts.app')

@section('title', 'Detail Laporan - Logbook System')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-dark">Detail Laporan Mingguan</h1>
        <a href="{{ route('reports.index') }}" class="text-primary hover:text-orange-600">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-dark mb-4">Ringkasan Mingguan</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-light rounded-lg">
                        <div class="text-2xl font-bold text-primary">{{ $weeklyReport->total_hours }}</div>
                        <div class="text-sm text-secondary">Jam Kerja</div>
                    </div>
                    <div class="text-center p-4 bg-light rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $weeklyReport->tasks_completed }}</div>
                        <div class="text-sm text-secondary">Tugas Selesai</div>
                    </div>
                    <div class="text-center p-4 bg-light rounded-lg">
                        <div class="text-2xl font-bold text-yellow-600">{{ $weeklyReport->tasks_pending }}</div>
                        <div class="text-sm text-secondary">Tugas Pending</div>
                    </div>
                    <div class="text-center p-4 bg-light rounded-lg">
                        <div class="text-2xl font-bold text-secondary">{{ number_format($weeklyReport->productivity_score, 1) }}%</div>
                        <div class="text-sm text-secondary">Productivity</div>
                    </div>
                </div>
                
                <div class="mt-6">
                    <h3 class="font-medium text-dark mb-2">Periode Laporan</h3>
                    <p class="text-secondary">
                        {{ $weeklyReport->week_start->format('d M Y') }} - {{ $weeklyReport->week_end->format('d M Y') }}
                    </p>
                </div>

                @if($weeklyReport->notes)
                <div class="mt-4">
                    <h3 class="font-medium text-dark mb-2">Catatan</h3>
                    <p class="text-secondary bg-light p-3 rounded-md">{{ $weeklyReport->notes }}</p>
                </div>
                @endif
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-dark mb-4">Tugas dalam Minggu Ini</h2>
                @if($tasks->count() > 0)
                    <div class="space-y-3">
                        @foreach($tasks as $task)
                        <div class="border border-gray-200 rounded-md p-3">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-medium text-dark">{{ $task->title }}</h3>
                                <div class="flex items-center space-x-2">
                                    @if($task->status === 'pending')
                                        <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                                    @elseif($task->status === 'in_progress')
                                        <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">Proses</span>
                                    @else
                                        <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Selesai</span>
                                    @endif
                                    @if($task->priority === 'high')
                                        <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">High</span>
                                    @elseif($task->priority === 'medium')
                                        <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Medium</span>
                                    @else
                                        <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Low</span>
                                    @endif
                                </div>
                            </div>
                            @if($task->description)
                                <p class="text-sm text-secondary mb-2">{{ $task->description }}</p>
                            @endif
                            <div class="flex items-center space-x-4 text-xs text-secondary">
                                <span>Dibuat: {{ $task->created_at->format('d M Y H:i') }}</span>
                                @if($task->due_date)
                                    <span>Deadline: {{ $task->due_date->format('d M Y H:i') }}</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-secondary text-center py-4">Tidak ada tugas dalam periode ini</p>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-dark mb-4">Sesi Kerja</h2>
                @if($sessions->count() > 0)
                    <div class="space-y-3">
                        @foreach($sessions as $session)
                        <div class="border border-gray-200 rounded-md p-3">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h3 class="font-medium text-dark">{{ $session->start_time->format('d M Y') }}</h3>
                                    <p class="text-sm text-secondary">{{ $session->start_time->format('H:i') }} - {{ $session->end_time ? $session->end_time->format('H:i') : 'Aktif' }}</p>
                                </div>
                                @if($session->status === 'active')
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Aktif</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">Selesai</span>
                                @endif
                            </div>
                            @if($session->end_time)
                                <p class="text-xs text-secondary">
                                    Durasi: {{ $session->start_time->diffInHours($session->end_time) }} jam
                                </p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-secondary text-center py-4">Tidak ada sesi kerja dalam periode ini</p>
                @endif
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-dark mb-4">Statistik</h2>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-secondary">Productivity Score</span>
                            <span class="text-dark font-medium">{{ number_format($weeklyReport->productivity_score, 1) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-primary h-2 rounded-full" style="width: {{ $weeklyReport->productivity_score }}%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-secondary">Completion Rate</span>
                            <span class="text-dark font-medium">
                                @php
                                    $totalTasks = $weeklyReport->tasks_completed + $weeklyReport->tasks_pending;
                                    $completionRate = $totalTasks > 0 ? ($weeklyReport->tasks_completed / $totalTasks) * 100 : 0;
                                @endphp
                                {{ number_format($completionRate, 1) }}%
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $completionRate }}%"></div>
                        </div>
                    </div>

                    <div class="pt-4 border-t">
                        <div class="flex justify-between text-sm">
                            <span class="text-secondary">Rata-rata Jam/Hari</span>
                            <span class="text-dark font-medium">
                                {{ $weeklyReport->total_hours > 0 ? number_format($weeklyReport->total_hours / 7, 1) : 0 }} jam
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
