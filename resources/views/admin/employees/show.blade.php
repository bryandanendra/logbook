@extends('layouts.app')

@section('title', 'Detail Karyawan - Admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-dark">Detail Karyawan</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.employees.edit', $employee) }}" class="bg-secondary text-white px-4 py-2 rounded-md hover:bg-blue-600">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('admin.employees.index') }}" class="text-primary hover:text-orange-600">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-dark mb-4">Informasi Karyawan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-secondary">Nama Lengkap</label>
                        <p class="text-dark font-medium">{{ $employee->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-secondary">Email</label>
                        <p class="text-dark">{{ $employee->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-secondary">ID Karyawan</label>
                        <p class="text-dark">{{ $employee->employee_id }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-secondary">Departemen</label>
                        <p class="text-dark">{{ $employee->department }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-secondary">Jabatan</label>
                        <p class="text-dark">{{ $employee->position }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-secondary">Status</label>
                        <p class="text-dark">
                            @if($employee->is_active)
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Aktif</span>
                            @else
                                <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">Nonaktif</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-secondary">Bergabung Sejak</label>
                        <p class="text-dark">{{ $employee->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-dark mb-4">Statistik Mingguan</h2>
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-light rounded-lg">
                        <div class="text-2xl font-bold text-primary">{{ $weeklyStats['total_tasks'] }}</div>
                        <div class="text-sm text-secondary">Total Tugas</div>
                    </div>
                    <div class="text-center p-4 bg-light rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $weeklyStats['completed_tasks'] }}</div>
                        <div class="text-sm text-secondary">Selesai</div>
                    </div>
                    <div class="text-center p-4 bg-light rounded-lg">
                        <div class="text-2xl font-bold text-secondary">{{ number_format($weeklyStats['productivity'], 1) }}%</div>
                        <div class="text-sm text-secondary">Productivity</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-dark mb-4">Tugas Terbaru</h2>
                @if($recentTasks->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentTasks as $task)
                        <div class="border border-gray-200 rounded-md p-3">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-medium text-dark text-sm">{{ $task->title }}</h3>
                                <div class="flex items-center space-x-1">
                                    @if($task->status === 'pending')
                                        <span class="px-1 py-0.5 text-xs bg-yellow-100 text-yellow-800 rounded">P</span>
                                    @elseif($task->status === 'in_progress')
                                        <span class="px-1 py-0.5 text-xs bg-blue-100 text-blue-800 rounded">IP</span>
                                    @else
                                        <span class="px-1 py-0.5 text-xs bg-green-100 text-green-800 rounded">C</span>
                                    @endif
                                </div>
                            </div>
                            <p class="text-xs text-secondary">{{ $task->created_at->format('d M H:i') }}</p>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-secondary text-center py-4">Belum ada tugas</p>
                @endif
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-dark mb-4">Sesi Kerja Terbaru</h2>
                @if($recentSessions->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentSessions as $session)
                        <div class="border border-gray-200 rounded-md p-3">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h3 class="font-medium text-dark text-sm">{{ $session->start_time->format('d M Y') }}</h3>
                                    <p class="text-xs text-secondary">{{ $session->start_time->format('H:i') }} - {{ $session->end_time ? $session->end_time->format('H:i') : 'Aktif' }}</p>
                                </div>
                                @if($session->status === 'active')
                                    <span class="px-1 py-0.5 text-xs bg-green-100 text-green-800 rounded">Aktif</span>
                                @else
                                    <span class="px-1 py-0.5 text-xs bg-gray-100 text-gray-800 rounded">Selesai</span>
                                @endif
                            </div>
                            @if($session->end_time)
                                <p class="text-xs text-secondary">Durasi: {{ $session->start_time->diffInHours($session->end_time) }} jam</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-secondary text-center py-4">Belum ada sesi kerja</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
