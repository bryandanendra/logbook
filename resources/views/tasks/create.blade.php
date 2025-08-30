@extends('layouts.app')

@section('title', 'Buat Tugas - Logbook System')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-dark">Buat Tugas Baru</h1>
        <a href="{{ route('tasks.index') }}" class="text-primary hover:text-orange-600">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            
            <input type="hidden" name="work_session_id" value="{{ $activeSession->id }}">
            
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-dark mb-2">Judul Tugas *</label>
                <input type="text" id="title" name="title" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary @error('title') border-red-500 @enderror"
                       placeholder="Masukkan judul tugas" value="{{ old('title') }}">
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-dark mb-2">Deskripsi</label>
                <textarea id="description" name="description" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary @error('description') border-red-500 @enderror"
                          placeholder="Deskripsi detail tugas...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="priority" class="block text-sm font-medium text-dark mb-2">Prioritas *</label>
                    <select id="priority" name="priority" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary @error('priority') border-red-500 @enderror">
                        <option value="">Pilih prioritas</option>
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                    </select>
                    @error('priority')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="due_date" class="block text-sm font-medium text-dark mb-2">Deadline</label>
                    <input type="datetime-local" id="due_date" name="due_date" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary @error('due_date') border-red-500 @enderror"
                           value="{{ old('due_date') }}">
                    @error('due_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="bg-light p-4 rounded-md mb-6">
                <h3 class="font-medium text-dark mb-2">Informasi Sesi Kerja</h3>
                <p class="text-sm text-secondary">
                    <strong>Sesi Aktif:</strong> {{ $activeSession->start_time->format('H:i, d M Y') }}<br>
                    <strong>Status:</strong> Aktif
                </p>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('tasks.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-primary text-white rounded-md hover:bg-orange-600">
                    <i class="fas fa-plus mr-2"></i>Buat Tugas
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
