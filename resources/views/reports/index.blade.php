@extends('layouts.app')

@section('title', 'Laporan - Logbook System')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-dark">Laporan Mingguan</h1>
        <div class="flex space-x-2">
            <a href="{{ route('reports.analytics') }}" class="bg-secondary text-white px-4 py-2 rounded-md hover:bg-blue-600">
                <i class="fas fa-chart-line mr-2"></i>Analytics
            </a>
            <form action="{{ route('reports.generate-weekly') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-orange-600">
                    <i class="fas fa-plus mr-2"></i>Generate Laporan
                </button>
            </form>
        </div>
    </div>

    @if($reports->count() > 0)
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider">Minggu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider">Jam Kerja</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider">Tugas Selesai</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider">Tugas Pending</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider">Productivity Score</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($reports as $report)
                        <tr>
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

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-primary bg-opacity-10">
                        <i class="fas fa-clock text-primary text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-secondary">Total Jam Kerja</p>
                        <p class="text-2xl font-semibold text-dark">{{ $reports->sum('total_hours') }} jam</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-500 bg-opacity-10">
                        <i class="fas fa-check text-green-500 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-secondary">Total Tugas Selesai</p>
                        <p class="text-2xl font-semibold text-dark">{{ $reports->sum('tasks_completed') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-secondary bg-opacity-10">
                        <i class="fas fa-chart-line text-secondary text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-secondary">Rata-rata Productivity</p>
                        <p class="text-2xl font-semibold text-dark">{{ number_format($reports->avg('productivity_score'), 1) }}%</p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white p-8 rounded-lg shadow-md text-center">
            <i class="fas fa-chart-bar text-4xl text-secondary mb-4"></i>
            <h3 class="text-lg font-medium text-dark mb-2">Belum ada laporan mingguan</h3>
            <p class="text-secondary mb-4">Generate laporan mingguan pertama kamu sekarang!</p>
            <form action="{{ route('reports.generate-weekly') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-orange-600">
                    <i class="fas fa-plus mr-2"></i>Generate Laporan
                </button>
            </form>
        </div>
    @endif
</div>
@endsection
