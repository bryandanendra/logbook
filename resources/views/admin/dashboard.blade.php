@extends('layouts.app')

@section('title', 'Admin Dashboard - Logbook System')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-dark">Admin Dashboard</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.employees.index') }}" class="bg-secondary text-white px-4 py-2 rounded-md hover:bg-blue-600 relative group">
                <i class="fas fa-users mr-2"></i>Kelola Karyawan
                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
                    👥 Kelola data karyawan (tambah, edit, lihat detail)
                </div>
            </a>
            <a href="{{ route('admin.reports.index') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-orange-600 relative group">
                <i class="fas fa-chart-bar mr-2"></i>Laporan Company
                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
                    📊 Lihat laporan dan analytics company
                </div>
            </a>
            <a href="{{ route('manual') }}" class="bg-purple-500 text-white px-4 py-2 rounded-md hover:bg-purple-600 relative group">
                <i class="fas fa-book mr-2"></i>Manual
                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
                    📚 Buka panduan admin dan sistem
                </div>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-primary relative group">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-primary bg-opacity-10">
                    <i class="fas fa-users text-primary text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-secondary">Total Karyawan</p>
                    <p class="text-2xl font-semibold text-dark">{{ $totalEmployees }}</p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                👥 Jumlah total karyawan estimator yang terdaftar di sistem
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500 relative group">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-500 bg-opacity-10">
                    <i class="fas fa-clock text-green-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-secondary">Sedang Bekerja</p>
                    <p class="text-2xl font-semibold text-dark">{{ $activeEmployees }}</p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                ⏰ Karyawan yang sedang dalam sesi kerja aktif saat ini
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-secondary relative group">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-secondary bg-opacity-10">
                    <i class="fas fa-tasks text-secondary text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-secondary">Total Tugas Hari Ini</p>
                    <p class="text-2xl font-semibold text-dark">{{ $todayStats['total_tasks'] }}</p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                📅 Total tugas yang dibuat oleh semua karyawan hari ini ({{ now()->format('d M Y') }})
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500 relative group">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-500 bg-opacity-10">
                    <i class="fas fa-check text-yellow-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-secondary">Tugas Selesai</p>
                    <p class="text-2xl font-semibold text-dark">{{ $todayStats['completed_tasks'] }}</p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                ✅ Tugas yang sudah diselesaikan oleh karyawan hari ini
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-dark mb-4">Statistik Hari Ini</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 bg-light rounded-md relative group">
                    <div>
                        <p class="font-medium text-dark">Total Tugas</p>
                        <p class="text-sm text-secondary">Semua karyawan</p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-primary">{{ $todayStats['total_tasks'] }}</p>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                        📅 Total tugas yang dibuat oleh semua karyawan hari ini
                    </div>
                </div>

                <div class="flex justify-between items-center p-3 bg-light rounded-md relative group">
                    <div>
                        <p class="font-medium text-dark">Tugas Selesai</p>
                        <p class="text-sm text-secondary">Completed tasks</p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-green-600">{{ $todayStats['completed_tasks'] }}</p>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                        ✅ Tugas dengan status 'completed' yang diselesaikan hari ini
                    </div>
                </div>

                <div class="flex justify-between items-center p-3 bg-light rounded-md relative group">
                    <div>
                        <p class="font-medium text-dark">Sesi Aktif</p>
                        <p class="text-sm text-secondary">Active work sessions</p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-blue-600">{{ $todayStats['active_sessions'] }}</p>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                        ⏰ Sesi kerja yang masih aktif (belum diakhiri) saat ini
                    </div>
                </div>

                <div class="flex justify-between items-center p-3 bg-light rounded-md relative group">
                    <div>
                        <p class="font-medium text-dark">Total Jam Kerja</p>
                        <p class="text-sm text-secondary">Working hours today</p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-secondary">{{ $todayStats['total_hours'] }}h</p>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                        ⏰ Total jam kerja dari sesi yang sudah selesai hari ini
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-dark mb-4">Statistik Mingguan</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 bg-light rounded-md relative group">
                    <div>
                        <p class="font-medium text-dark">Total Tugas</p>
                        <p class="text-sm text-secondary">Minggu ini</p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-primary">{{ $weeklyStats['total_tasks'] }}</p>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                        📅 Total tugas yang dibuat dari awal minggu ini sampai sekarang ({{ now()->startOfWeek()->format('d M') }} - {{ now()->endOfWeek()->format('d M') }})
                    </div>
                </div>

                <div class="flex justify-between items-center p-3 bg-light rounded-md relative group">
                    <div>
                        <p class="font-medium text-dark">Tugas Selesai</p>
                        <p class="text-sm text-secondary">Completed this week</p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-green-600">{{ $weeklyStats['completed_tasks'] }}</p>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                        ✅ Tugas yang sudah diselesaikan dalam minggu ini
                    </div>
                </div>

                <div class="flex justify-between items-center p-3 bg-light rounded-md relative group">
                    <div>
                        <p class="font-medium text-dark">Total Jam Kerja</p>
                        <p class="text-sm text-secondary">This week</p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-secondary">{{ $weeklyStats['total_hours'] }}h</p>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                        ⏰ Total jam kerja dari semua sesi yang selesai dalam minggu ini
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-dark mb-4">Departemen</h2>
            @if($departmentStats->count() > 0)
                <div class="space-y-3">
                    @foreach($departmentStats as $dept)
                    <div class="flex justify-between items-center p-3 bg-light rounded-md">
                        <div>
                            <p class="font-medium text-dark">{{ $dept->department }}</p>
                            <p class="text-sm text-secondary">{{ $dept->total_employees }} karyawan</p>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-1 text-xs bg-primary text-white rounded-full">{{ $dept->total_employees }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-secondary text-center py-4">Belum ada data departemen</p>
            @endif
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-dark mb-4">Aktivitas Terbaru</h2>
            @if($recentActivities->count() > 0)
                <div class="space-y-3">
                    @foreach($recentActivities->take(5) as $activity)
                    <div class="flex items-start space-x-3 p-3 bg-light rounded-md">
                        <div class="flex-shrink-0">
                            @if($activity instanceof \App\Models\Task)
                                <i class="fas fa-tasks text-primary"></i>
                            @else
                                <i class="fas fa-clock text-secondary"></i>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-dark">
                                @if($activity instanceof \App\Models\Task)
                                    {{ $activity->user->name }} {{ $activity->status === 'completed' ? 'menyelesaikan' : 'membuat' }} tugas
                                @else
                                    {{ $activity->user->name }} {{ $activity->status === 'active' ? 'memulai' : 'mengakhiri' }} sesi kerja
                                @endif
                            </p>
                            <p class="text-xs text-secondary">{{ $activity->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-secondary text-center py-4">Belum ada aktivitas</p>
            @endif
        </div>
    </div>

    <div class="flex justify-center space-x-4">
        <a href="{{ route('admin.employees.index') }}" class="bg-secondary text-white px-6 py-3 rounded-md hover:bg-blue-600">
            <i class="fas fa-users mr-2"></i>Kelola Karyawan
        </a>
        <a href="{{ route('admin.reports.index') }}" class="bg-primary text-white px-6 py-3 rounded-md hover:bg-orange-600">
            <i class="fas fa-chart-bar mr-2"></i>Lihat Laporan
        </a>
        <a href="{{ route('admin.analytics') }}" class="bg-green-500 text-white px-6 py-3 rounded-md hover:bg-green-600">
            <i class="fas fa-chart-line mr-2"></i>Analytics
        </a>
    </div>
</div>
@endsection
