@extends('layouts.app')

@section('title', 'Analytics - Logbook System')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-dark">Analytics & Insights</h1>
        <a href="{{ route('reports.index') }}" class="text-primary hover:text-orange-600">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Laporan
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-primary relative group">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-primary bg-opacity-10">
                    <i class="fas fa-tasks text-primary text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-secondary">Total Tugas</p>
                    <p class="text-2xl font-semibold text-dark">{{ $monthlyStats['total_tasks'] }}</p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                📅 Total tugas yang dibuat bulan ini ({{ now()->format('M Y') }})
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500 relative group">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-500 bg-opacity-10">
                    <i class="fas fa-check text-green-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-secondary">Tugas Selesai</p>
                    <p class="text-2xl font-semibold text-dark">{{ $monthlyStats['completed_tasks'] }}</p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                ✅ Tugas dengan status 'completed' bulan ini
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-secondary relative group">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-secondary bg-opacity-10">
                    <i class="fas fa-clock text-secondary text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-secondary">Total Jam</p>
                    <p class="text-2xl font-semibold text-dark">{{ number_format($monthlyStats['total_hours'], 1) }}h</p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                ⏰ Total jam dari sesi kerja yang sudah selesai bulan ini
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500 relative group">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-500 bg-opacity-10">
                    <i class="fas fa-chart-line text-yellow-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-secondary">Productivity</p>
                    <p class="text-2xl font-semibold text-dark">{{ number_format($monthlyStats['avg_productivity'], 1) }}%</p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                📊 Rata-rata produktivitas: (Tugas Selesai / Total Tugas) × 100%
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-dark mb-4">Trend Mingguan</h2>
            <div class="space-y-4">
                @foreach($weeklyTrends as $week)
                <div class="flex items-center justify-between p-3 bg-light rounded-md">
                    <div>
                        <h3 class="font-medium text-dark">{{ $week['week'] }}</h3>
                        <p class="text-sm text-secondary">{{ $week['total_tasks'] }} total tugas</p>
                    </div>
                    <div class="text-right">
                        <div class="text-lg font-semibold text-green-600">{{ $week['completed_tasks'] }}</div>
                        <div class="text-sm text-secondary">selesai</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-dark mb-4">Distribusi Tugas</h2>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-secondary">Pending</span>
                        <span class="text-dark font-medium">{{ $taskDistribution['pending'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        @php
                            $totalTasks = array_sum($taskDistribution);
                            $pendingPercent = $totalTasks > 0 ? ($taskDistribution['pending'] / $totalTasks) * 100 : 0;
                        @endphp
                        <div class="bg-yellow-500 h-3 rounded-full" style="width: {{ $pendingPercent }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-secondary">In Progress</span>
                        <span class="text-dark font-medium">{{ $taskDistribution['in_progress'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        @php
                            $inProgressPercent = $totalTasks > 0 ? ($taskDistribution['in_progress'] / $totalTasks) * 100 : 0;
                        @endphp
                        <div class="bg-blue-500 h-3 rounded-full" style="width: {{ $inProgressPercent }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-secondary">Completed</span>
                        <span class="text-dark font-medium">{{ $taskDistribution['completed'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        @php
                            $completedPercent = $totalTasks > 0 ? ($taskDistribution['completed'] / $totalTasks) * 100 : 0;
                        @endphp
                        <div class="bg-green-500 h-3 rounded-full" style="width: {{ $completedPercent }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-dark mb-4">Insights & Rekomendasi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div class="p-4 bg-blue-50 rounded-lg">
                    <h3 class="font-medium text-blue-800 mb-2">
                        <i class="fas fa-lightbulb mr-2"></i>Productivity Tips
                    </h3>
                    <ul class="text-sm text-blue-700 space-y-1">
                        <li>• Fokus pada tugas prioritas tinggi</li>
                        <li>• Istirahat teratur setiap 2 jam</li>
                        <li>• Review progress harian</li>
                        <li>• Set target realistis</li>
                    </ul>
                </div>

                <div class="p-4 bg-green-50 rounded-lg">
                    <h3 class="font-medium text-green-800 mb-2">
                        <i class="fas fa-trophy mr-2"></i>Pencapaian
                    </h3>
                    <div class="text-sm text-green-700">
                        @if($monthlyStats['avg_productivity'] >= 80)
                            <p>Excellent! Productivity kamu sangat tinggi. Pertahankan!</p>
                        @elseif($monthlyStats['avg_productivity'] >= 60)
                            <p>Good job! Productivity kamu sudah bagus, bisa ditingkatkan lagi.</p>
                        @else
                            <p>Ada ruang untuk improvement. Coba fokus pada prioritas tugas.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div class="p-4 bg-yellow-50 rounded-lg">
                    <h3 class="font-medium text-yellow-800 mb-2">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Area Perbaikan
                    </h3>
                    <ul class="text-sm text-yellow-700 space-y-1">
                        @if($taskDistribution['pending'] > $taskDistribution['completed'])
                            <li>• Terlalu banyak tugas pending</li>
                        @endif
                        @if($monthlyStats['total_hours'] < 40)
                            <li>• Jam kerja masih rendah</li>
                        @endif
                        @if($monthlyStats['avg_productivity'] < 70)
                            <li>• Productivity perlu ditingkatkan</li>
                        @endif
                        <li>• Review dan update status tugas secara rutin</li>
                    </ul>
                </div>

                <div class="p-4 bg-purple-50 rounded-lg">
                    <h3 class="font-medium text-purple-800 mb-2">
                        <i class="fas fa-chart-bar mr-2"></i>Statistik Bulanan
                    </h3>
                    <div class="text-sm text-purple-700 space-y-1">
                        <p><strong>Rata-rata jam kerja/hari:</strong> {{ $monthlyStats['total_hours'] > 0 ? number_format($monthlyStats['total_hours'] / 30, 1) : 0 }} jam</p>
                        <p><strong>Completion rate:</strong> {{ $monthlyStats['total_tasks'] > 0 ? number_format(($monthlyStats['completed_tasks'] / $monthlyStats['total_tasks']) * 100, 1) : 0 }}%</p>
                        <p><strong>Efisiensi:</strong> {{ $monthlyStats['total_hours'] > 0 ? number_format($monthlyStats['completed_tasks'] / $monthlyStats['total_hours'], 1) : 0 }} tugas/jam</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
