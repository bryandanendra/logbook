@extends('layouts.app')

@section('title', 'Sesi Kerja - Logbook System')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-dark">Sesi Kerja</h1>
        <a href="{{ route('work-sessions.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-orange-600">
            <i class="fas fa-plus mr-2"></i>Buat Sesi Baru
        </a>
    </div>

    @if($sessions->count() > 0)
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider">Mulai</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider">Selesai</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider">Durasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($sessions as $session)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-dark">
                                {{ $session->start_time->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-dark">
                                {{ $session->start_time->format('H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-dark">
                                {{ $session->end_time ? $session->end_time->format('H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-dark relative group">
                                @if($session->end_time)
                                    <span class="cursor-help">{{ number_format($session->start_time->diffInMinutes($session->end_time) / 60, 1) }} jam</span>
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
                                        ⏰ Durasi: {{ $session->start_time->format('H:i') }} - {{ $session->end_time->format('H:i') }}
                                    </div>
                                @else
                                    <span class="cursor-help">{{ $session->start_time->diffForHumans() }}</span>
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
                                        🔄 Sesi masih aktif sejak {{ $session->start_time->format('H:i') }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($session->status === 'active')
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Aktif</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">Selesai</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('work-sessions.show', $session) }}" class="text-primary hover:text-orange-600 mr-3">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($session->status === 'active')
                                    <form action="{{ route('work-sessions.end', $session) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin mengakhiri sesi kerja?')">
                                            <i class="fas fa-stop"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-4">
            {{ $sessions->links() }}
        </div>
    @else
        <div class="bg-white p-8 rounded-lg shadow-md text-center">
            <i class="fas fa-clock text-4xl text-secondary mb-4"></i>
            <h3 class="text-lg font-medium text-dark mb-2">Belum ada sesi kerja</h3>
            <p class="text-secondary mb-4">Mulai sesi kerja pertama kamu sekarang!</p>
            <a href="{{ route('work-sessions.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-orange-600">
                <i class="fas fa-play mr-2"></i>Mulai Sesi Kerja
            </a>
        </div>
    @endif
</div>
@endsection
