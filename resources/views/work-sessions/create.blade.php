@extends('layouts.app')

@section('title', 'Buat Sesi Kerja - Logbook System')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-dark">Buat Sesi Kerja Baru</h1>
        <a href="{{ route('work-sessions.index') }}" class="text-primary hover:text-orange-600">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('work-sessions.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="notes" class="block text-sm font-medium text-dark mb-2">Catatan (Opsional)</label>
                <textarea id="notes" name="notes" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary @error('notes') border-red-500 @enderror"
                          placeholder="Catatan untuk sesi kerja ini...">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-light p-4 rounded-md mb-6">
                <h3 class="font-medium text-dark mb-2">Informasi Sesi Kerja</h3>
                <p class="text-sm text-secondary">
                    <strong>Waktu Mulai:</strong> {{ now()->format('H:i, d M Y') }}<br>
                    <strong>Status:</strong> Aktif
                </p>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('work-sessions.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-primary text-white rounded-md hover:bg-orange-600">
                    <i class="fas fa-play mr-2"></i>Mulai Sesi Kerja
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
