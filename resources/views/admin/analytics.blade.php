@extends('layouts.app')

@section('title', 'Analytics Company - Admin')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-dark">Analytics Company</h1>
        <div class="flex space-x-2">
            <button onclick="printAnalytics()" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 relative group">
                <i class="fas fa-print mr-2"></i>Print Analytics
                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
                    🖨️ Cetak analytics dalam format PDF
                </div>
            </button>
            <a href="{{ route('admin.reports.index') }}" class="bg-secondary text-white px-4 py-2 rounded-md hover:bg-blue-600 relative group">
                <i class="fas fa-chart-bar mr-2"></i>Laporan
                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
                    📄 Lihat laporan company
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
                    <p class="text-2xl font-semibold text-dark">{{ $companyStats['total_employees'] }}</p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                👥 Jumlah total karyawan estimator yang terdaftar di sistem
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500 relative group">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-500 bg-opacity-10">
                    <i class="fas fa-tasks text-green-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-secondary">Total Tugas</p>
                    <p class="text-2xl font-semibold text-dark">{{ $companyStats['total_tasks'] }}</p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                📋 Total semua tugas yang pernah dibuat di sistem
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-secondary relative group">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-secondary bg-opacity-10">
                    <i class="fas fa-clock text-secondary text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-secondary">Total Jam Kerja</p>
                    <p class="text-2xl font-semibold text-dark">{{ $companyStats['total_hours'] }}h</p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                ⏰ Total jam kerja dari semua sesi yang sudah selesai
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500 relative group">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-500 bg-opacity-10">
                    <i class="fas fa-chart-line text-yellow-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-secondary">Avg Productivity</p>
                    <p class="text-2xl font-semibold text-dark">{{ number_format($companyStats['avg_productivity'], 1) }}%</p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                📊 Rata-rata skor produktivitas dari semua laporan mingguan
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-dark mb-4">Top Performers</h2>
            @if($topPerformers->count() > 0)
                <div class="space-y-4">
                    @foreach($topPerformers as $index => $performer)
                    <div class="flex items-center justify-between p-3 bg-light rounded-md">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center text-sm font-medium mr-3">
                                {{ $index + 1 }}
                            </div>
                            <div>
                                <h3 class="font-medium text-dark">{{ $performer->user->name }}</h3>
                                <p class="text-sm text-secondary">{{ $performer->user->department }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-semibold text-green-600">{{ number_format($performer->productivity_score, 1) }}%</div>
                            <div class="text-sm text-secondary">{{ $performer->tasks_completed }} tugas</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-secondary text-center py-4">Belum ada data performa</p>
            @endif
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-dark mb-4">Departemen Performance</h2>
            @if($departmentPerformance->count() > 0)
                <div class="space-y-4">
                    @foreach($departmentPerformance as $dept)
                    <div class="p-3 bg-light rounded-md">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-medium text-dark">{{ $dept->department }}</h3>
                            <span class="text-sm text-secondary">{{ $dept->total_employees }} karyawan</span>
                        </div>
                        <div class="flex justify-between text-sm text-secondary">
                            <span>Avg Productivity: {{ number_format($dept->avg_productivity, 1) }}%</span>
                            <span>{{ $dept->total_tasks }} tugas</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="bg-primary h-2 rounded-full" style="width: {{ $dept->avg_productivity }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-secondary text-center py-4">Belum ada data departemen</p>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-dark mb-4">Trend Bulanan</h2>
            <div class="space-y-4">
                @foreach($monthlyTrends as $month)
                <div class="flex items-center justify-between p-3 bg-light rounded-md">
                    <div>
                        <h3 class="font-medium text-dark">{{ $month['month'] }}</h3>
                        <p class="text-sm text-secondary">{{ $month['total_tasks'] }} total tugas</p>
                    </div>
                    <div class="text-right">
                        <div class="text-lg font-semibold text-green-600">{{ $month['completed_tasks'] }}</div>
                        <div class="text-sm text-secondary">selesai</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-dark mb-4">Distribusi Status Tugas</h2>
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

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Monthly Trends Chart -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-dark mb-4">Trend Bulanan</h2>
            <canvas id="monthlyTrendsChart" width="400" height="200"></canvas>
        </div>

        <!-- Task Distribution Chart -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-dark mb-4">Distribusi Tugas</h2>
            <canvas id="taskDistributionChart" width="400" height="200"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Productivity Chart -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-dark mb-4">Productivity 4 Minggu Terakhir</h2>
            <canvas id="productivityChart" width="400" height="200"></canvas>
        </div>

        <!-- Department Performance Chart -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-dark mb-4">Performa Departemen</h2>
            <canvas id="departmentChart" width="400" height="200"></canvas>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-dark mb-4">Insights & Rekomendasi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div class="p-4 bg-blue-50 rounded-lg">
                    <h3 class="font-medium text-blue-800 mb-2">
                        <i class="fas fa-lightbulb mr-2"></i>Performa Terbaik
                    </h3>
                    <ul class="text-sm text-blue-700 space-y-1">
                        @if($topPerformers->count() > 0)
                            <li>• {{ $topPerformers->first()->user->name }} - {{ number_format($topPerformers->first()->productivity_score, 1) }}%</li>
                        @endif
                        <li>• Rata-rata productivity: {{ number_format($companyStats['avg_productivity'], 1) }}%</li>
                        <li>• Total jam kerja: {{ $companyStats['total_hours'] }} jam</li>
                    </ul>
                </div>

                <div class="p-4 bg-green-50 rounded-lg">
                    <h3 class="font-medium text-green-800 mb-2">
                        <i class="fas fa-trophy mr-2"></i>Pencapaian Company
                    </h3>
                    <div class="text-sm text-green-700 space-y-1">
                        <p><strong>Completion Rate:</strong> {{ $companyStats['total_tasks'] > 0 ? number_format(($companyStats['completed_tasks'] / $companyStats['total_tasks']) * 100, 1) : 0 }}%</p>
                        <p><strong>Efisiensi:</strong> {{ $companyStats['total_hours'] > 0 ? number_format($companyStats['completed_tasks'] / $companyStats['total_hours'], 1) : 0 }} tugas/jam</p>
                        <p><strong>Karyawan Aktif:</strong> {{ $companyStats['active_employees'] }}/{{ $companyStats['total_employees'] }}</p>
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
                        @if($companyStats['avg_productivity'] < 70)
                            <li>• Productivity perlu ditingkatkan</li>
                        @endif
                        @if($companyStats['active_employees'] < $companyStats['total_employees'] * 0.8)
                            <li>• Tingkat kehadiran karyawan rendah</li>
                        @endif
                        <li>• Review dan evaluasi performa rutin</li>
                    </ul>
                </div>

                <div class="p-4 bg-purple-50 rounded-lg">
                    <h3 class="font-medium text-purple-800 mb-2">
                        <i class="fas fa-chart-bar mr-2"></i>Statistik Company
                    </h3>
                    <div class="text-sm text-purple-700 space-y-1">
                        <p><strong>Rata-rata jam kerja/karyawan:</strong> {{ $companyStats['total_employees'] > 0 ? number_format($companyStats['total_hours'] / $companyStats['total_employees'], 1) : 0 }} jam</p>
                        <p><strong>Rata-rata tugas/karyawan:</strong> {{ $companyStats['total_employees'] > 0 ? number_format($companyStats['total_tasks'] / $companyStats['total_employees'], 1) : 0 }} tugas</p>
                        <p><strong>Departemen terbaik:</strong> 
                            @if($departmentPerformance->count() > 0)
                                {{ $departmentPerformance->sortByDesc('avg_productivity')->first()->department }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Print Section for Analytics (Hidden by default) -->
<div id="printAnalyticsSection" class="hidden">
    <div class="bg-white p-8">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-dark mb-2">Analytics Company</h1>
            <p class="text-secondary">Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="border p-4 rounded">
                <h3 class="font-semibold text-dark mb-2">Ringkasan Company</h3>
                <p><strong>Total Karyawan:</strong> {{ $companyStats['total_employees'] }}</p>
                <p><strong>Total Tugas:</strong> {{ $companyStats['total_tasks'] }}</p>
                <p><strong>Total Jam Kerja:</strong> {{ $companyStats['total_hours'] }}h</p>
                <p><strong>Rata-rata Productivity:</strong> {{ number_format($companyStats['avg_productivity'], 1) }}%</p>
            </div>
        </div>

        @if($topPerformers->count() > 0)
            <div class="mb-6">
                <h3 class="font-semibold text-dark mb-2">Top Performers</h3>
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2 text-left">Rank</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Nama</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Departemen</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Productivity</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Tugas Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topPerformers as $index => $performer)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $performer->user->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $performer->user->department }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ number_format($performer->productivity_score, 1) }}%</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $performer->tasks_completed }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
function printAnalytics() {
    // Hide all elements except print section
    const mainContent = document.querySelector('.space-y-6');
    const printSection = document.getElementById('printAnalyticsSection');
    
    mainContent.style.display = 'none';
    printSection.classList.remove('hidden');
    
    // Print
    window.print();
    
    // Restore display after printing
    setTimeout(() => {
        mainContent.style.display = 'block';
        printSection.classList.add('hidden');
    }, 1000);
}

// Add print styles for analytics
const analyticsPrintStyle = document.createElement('style');
analyticsPrintStyle.textContent = `
    @media print {
        body * {
            visibility: hidden;
        }
        #printAnalyticsSection, #printAnalyticsSection * {
            visibility: visible;
        }
        #printAnalyticsSection {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }
`;
document.head.appendChild(analyticsPrintStyle);

// Monthly Trends Chart
const monthlyTrendsCtx = document.getElementById('monthlyTrendsChart').getContext('2d');
const monthlyTrendsChart = new Chart(monthlyTrendsCtx, {
    type: 'line',
    data: {
        labels: @json($monthlyTrends->pluck('month')),
        datasets: [{
            label: 'Total Tugas',
            data: @json($monthlyTrends->pluck('total_tasks')),
            borderColor: '#F27127',
            backgroundColor: 'rgba(242, 113, 39, 0.1)',
            tension: 0.4
        }, {
            label: 'Tugas Selesai',
            data: @json($monthlyTrends->pluck('completed_tasks')),
            borderColor: '#10B981',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Task Distribution Chart
const taskDistributionCtx = document.getElementById('taskDistributionChart').getContext('2d');
const taskDistributionChart = new Chart(taskDistributionCtx, {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'In Progress', 'Completed'],
        datasets: [{
            data: [
                {{ $taskDistribution['pending'] }},
                {{ $taskDistribution['in_progress'] }},
                {{ $taskDistribution['completed'] }}
            ],
            backgroundColor: [
                '#F59E0B',
                '#3B82F6',
                '#10B981'
            ],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
            }
        }
    }
});

// Productivity Chart
const productivityCtx = document.getElementById('productivityChart').getContext('2d');
const productivityChart = new Chart(productivityCtx, {
    type: 'bar',
    data: {
        labels: @json($productivityChart->pluck('week')),
        datasets: [{
            label: 'Rata-rata Productivity (%)',
            data: @json($productivityChart->pluck('avg_productivity')),
            backgroundColor: '#5C6B87',
            borderColor: '#5C6B87',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                max: 100
            }
        }
    }
});

// Department Performance Chart
const departmentCtx = document.getElementById('departmentChart').getContext('2d');
const departmentChart = new Chart(departmentCtx, {
    type: 'bar',
    data: {
        labels: @json($departmentPerformance->pluck('department')),
        datasets: [{
            label: 'Productivity (%)',
            data: @json($departmentPerformance->pluck('avg_productivity')),
            backgroundColor: '#F27127',
            borderColor: '#F27127',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                max: 100
            }
        }
    }
});
</script>
@endpush
