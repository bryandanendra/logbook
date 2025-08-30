@extends('layouts.app')

@section('title', 'Laporan Company - Admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-dark">Laporan Company</h1>
        <div class="flex space-x-2">
            <button onclick="printReport()" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 relative group">
                <i class="fas fa-print mr-2"></i>Print Laporan
                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
                    🖨️ Cetak laporan dalam format PDF
                </div>
            </button>
            <a href="{{ route('admin.analytics') }}" class="bg-secondary text-white px-4 py-2 rounded-md hover:bg-blue-600 relative group">
                <i class="fas fa-chart-line mr-2"></i>Analytics
                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
                    📊 Lihat analytics dan grafik
                </div>
            </a>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-dark mb-4">Filter Periode</h2>
        <form method="GET" class="flex space-x-4">
            <div>
                <label for="start_date" class="block text-sm font-medium text-dark mb-1">Dari Tanggal</label>
                <input type="date" id="start_date" name="start_date" 
                       value="{{ $startDate->format('Y-m-d') }}"
                       class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-dark mb-1">Sampai Tanggal</label>
                <input type="date" id="end_date" name="end_date" 
                       value="{{ $endDate->format('Y-m-d') }}"
                       class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-orange-600">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-primary relative group">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-primary bg-opacity-10">
                    <i class="fas fa-file-alt text-primary text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-secondary">Total Laporan</p>
                    <p class="text-2xl font-semibold text-dark">{{ $summary['total_reports'] }}</p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                📄 Jumlah laporan mingguan yang tersedia dalam periode yang dipilih
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500 relative group">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-500 bg-opacity-10">
                    <i class="fas fa-chart-line text-green-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-secondary">Rata-rata Productivity</p>
                    <p class="text-2xl font-semibold text-dark">{{ number_format($summary['avg_productivity'], 1) }}%</p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                📊 Rata-rata skor produktivitas dari semua laporan dalam periode
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-secondary relative group">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-secondary bg-opacity-10">
                    <i class="fas fa-clock text-secondary text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-secondary">Total Jam Kerja</p>
                    <p class="text-2xl font-semibold text-dark">{{ $summary['total_hours'] }}h</p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                ⏰ Total jam kerja dari semua laporan dalam periode yang dipilih
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500 relative group">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-500 bg-opacity-10">
                    <i class="fas fa-check text-yellow-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-secondary">Total Tugas Selesai</p>
                    <p class="text-2xl font-semibold text-dark">{{ $summary['total_tasks_completed'] }}</p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                ✅ Total tugas yang sudah diselesaikan dalam periode yang dipilih
            </div>
        </div>
    </div>

    @if($reports->count() > 0)
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider relative group">
                                Karyawan
                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
                                    👤 Nama karyawan yang membuat laporan
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider relative group">
                                Minggu
                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
                                    📅 Periode minggu laporan (tanggal mulai minggu)
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider relative group">
                                Jam Kerja
                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
                                    ⏰ Total jam kerja dalam minggu tersebut
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider relative group">
                                Tugas Selesai
                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
                                    ✅ Jumlah tugas yang diselesaikan dalam minggu
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider relative group">
                                Tugas Pending
                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
                                    ⏳ Jumlah tugas yang masih pending dalam minggu
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider relative group">
                                Productivity
                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
                                    📊 Skor produktivitas berdasarkan tugas selesai vs total
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider relative group">
                                Aksi
                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
                                    ⚙️ Aksi yang dapat dilakukan (lihat detail laporan)
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($reports as $report)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-primary flex items-center justify-center">
                                            <span class="text-white font-medium">{{ substr($report->user->name, 0, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-dark">{{ $report->user->name }}</div>
                                        <div class="text-sm text-secondary">{{ $report->user->department }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-dark">
                                {{ $report->week_start->format('d M Y') }} - {{ $report->week_end->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-dark">
                                {{ $report->total_hours }} jam
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-dark">
                                <span class="text-green-600 font-medium">{{ $report->tasks_completed }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-dark">
                                <span class="text-yellow-600 font-medium">{{ $report->tasks_pending }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                        <div class="bg-primary h-2 rounded-full" style="width: {{ $report->productivity_score }}%"></div>
                                    </div>
                                    <span class="text-sm text-dark">{{ number_format($report->productivity_score, 1) }}%</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('reports.show', $report) }}" class="text-primary hover:text-orange-600">
                                    <i class="fas fa-eye mr-1"></i>Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-4">
            {{ $reports->links() }}
        </div>
    @else
        <div class="bg-white p-8 rounded-lg shadow-md text-center">
            <i class="fas fa-chart-bar text-4xl text-secondary mb-4"></i>
            <h3 class="text-lg font-medium text-dark mb-2">Belum ada laporan</h3>
            <p class="text-secondary mb-4">Karyawan belum generate laporan mingguan</p>
        </div>
    @endif
</div>

<!-- Print Section (Hidden by default) -->
<div id="printSection" class="hidden">
    <div class="bg-white p-8">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-dark mb-2">Laporan Company</h1>
            <p class="text-secondary">Periode: {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</p>
            <p class="text-secondary">Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="border p-4 rounded">
                <h3 class="font-semibold text-dark mb-2">Ringkasan</h3>
                <p><strong>Total Laporan:</strong> {{ $summary['total_reports'] }}</p>
                <p><strong>Rata-rata Productivity:</strong> {{ number_format($summary['avg_productivity'], 1) }}%</p>
                <p><strong>Total Jam Kerja:</strong> {{ $summary['total_hours'] }}h</p>
                <p><strong>Total Tugas Selesai:</strong> {{ $summary['total_tasks_completed'] }}</p>
            </div>
        </div>

        @if($reports->count() > 0)
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left">Karyawan</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Minggu</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Jam Kerja</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Tugas Selesai</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Tugas Pending</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Productivity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">
                            <div>
                                <div class="font-medium">{{ $report->user->name }}</div>
                                <div class="text-sm text-gray-600">{{ $report->user->department }}</div>
                            </div>
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $report->week_start->format('d M Y') }} - {{ $report->week_end->format('d M Y') }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">{{ $report->total_hours }} jam</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $report->tasks_completed }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $report->tasks_pending }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ number_format($report->productivity_score, 1) }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
function printReport() {
    // Hide all elements except print section
    const mainContent = document.querySelector('.space-y-6');
    const printSection = document.getElementById('printSection');
    
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

// Add print styles
const style = document.createElement('style');
style.textContent = `
    @media print {
        body * {
            visibility: hidden;
        }
        #printSection, #printSection * {
            visibility: visible;
        }
        #printSection {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }
`;
document.head.appendChild(style);
</script>
@endpush
