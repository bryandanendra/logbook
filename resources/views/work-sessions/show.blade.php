@extends('layouts.app')

@section('title', 'Detail Sesi Kerja - Logbook System')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-dark">Detail Sesi Kerja</h1>
        <div class="flex space-x-2">
            <a href="{{ route('work-sessions.edit', $workSession) }}" class="bg-secondary text-white px-4 py-2 rounded-md hover:bg-blue-600">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            @if($workSession->status === 'active')
                <form action="{{ route('work-sessions.end', $workSession) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600" onclick="return confirm('Yakin ingin mengakhiri sesi kerja?')">
                        <i class="fas fa-stop mr-2"></i>Akhiri Sesi
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-dark mb-4">Informasi Sesi Kerja</h2>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-secondary">Status:</span>
                    @if($workSession->status === 'active')
                        <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Aktif</span>
                    @else
                        <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">Selesai</span>
                    @endif
                </div>
                <div class="flex justify-between">
                    <span class="text-secondary">Waktu Mulai:</span>
                    <span class="text-dark">{{ $workSession->start_time->format('H:i, d M Y') }}</span>
                </div>
                @if($workSession->end_time)
                    <div class="flex justify-between">
                        <span class="text-secondary">Waktu Selesai:</span>
                        <span class="text-dark">{{ $workSession->end_time->format('H:i, d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-secondary">Durasi:</span>
                        <span class="text-dark">{{ number_format($workSession->start_time->diffInMinutes($workSession->end_time) / 60, 1) }} jam</span>
                    </div>
                @else
                    <div class="flex justify-between">
                        <span class="text-secondary">Durasi:</span>
                        <span class="text-dark">{{ $workSession->start_time->diffForHumans() }}</span>
                    </div>
                @endif
                @if($workSession->notes)
                    <div class="mt-4">
                        <span class="text-secondary block mb-2">Catatan:</span>
                        <p class="text-dark bg-light p-3 rounded-md">{{ $workSession->notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-dark mb-4">Tugas dalam Sesi Ini</h2>
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
                                <a href="{{ route('tasks.show', $task) }}" class="text-primary hover:text-orange-600">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        @if($task->description)
                            <p class="text-sm text-secondary">{{ $task->description }}</p>
                        @endif
                        <div class="flex items-center space-x-4 mt-2 text-xs text-secondary">
                            <span>Prioritas: 
                                @if($task->priority === 'high')
                                    <span class="text-red-600">High</span>
                                @elseif($task->priority === 'medium')
                                    <span class="text-yellow-600">Medium</span>
                                @else
                                    <span class="text-green-600">Low</span>
                                @endif
                            </span>
                            <span>Dibuat: {{ $task->created_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-secondary text-center py-4">Belum ada tugas dalam sesi ini</p>
            @endif
            
            @if($workSession->status === 'active')
                <div class="mt-4">
                    <a href="{{ route('tasks.create') }}" class="text-primary hover:text-orange-600">
                        <i class="fas fa-plus mr-2"></i>Tambah Tugas
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="flex justify-between">
        <a href="{{ route('work-sessions.index') }}" class="text-primary hover:text-orange-600">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
        </a>
        @if($workSession->status === 'active')
            <a href="{{ route('tasks.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-orange-600">
                <i class="fas fa-plus mr-2"></i>Tambah Tugas Baru
            </a>
        @endif
    </div>
</div>
@endsection
