@extends('layouts.app')

@section('title', 'Edit Karyawan - Admin')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-dark">Edit Karyawan</h1>
        <a href="{{ route('admin.employees.show', $employee) }}" class="text-primary hover:text-orange-600">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('admin.employees.update', $employee) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-dark mb-2">Nama Lengkap *</label>
                    <input type="text" id="name" name="name" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary @error('name') border-red-500 @enderror"
                           placeholder="Masukkan nama lengkap" value="{{ old('name', $employee->name) }}">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-dark mb-2">Email *</label>
                    <input type="email" id="email" name="email" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary @error('email') border-red-500 @enderror"
                           placeholder="Masukkan email" value="{{ old('email', $employee->email) }}">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="employee_id" class="block text-sm font-medium text-dark mb-2">ID Karyawan *</label>
                    <input type="text" id="employee_id" name="employee_id" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary @error('employee_id') border-red-500 @enderror"
                           placeholder="Contoh: EMP001" value="{{ old('employee_id', $employee->employee_id) }}">
                    @error('employee_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="department" class="block text-sm font-medium text-dark mb-2">Departemen *</label>
                    <input type="text" id="department" name="department" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary @error('department') border-red-500 @enderror"
                           placeholder="Contoh: IT, HR, Finance" value="{{ old('department', $employee->department) }}">
                    @error('department')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="position" class="block text-sm font-medium text-dark mb-2">Jabatan *</label>
                    <input type="text" id="position" name="position" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary @error('position') border-red-500 @enderror"
                           placeholder="Contoh: Senior Estimator" value="{{ old('position', $employee->position) }}">
                    @error('position')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-dark mb-2">Status</label>
                    <div class="flex items-center">
                        <input type="checkbox" id="is_active" name="is_active" 
                               class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded"
                               {{ old('is_active', $employee->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="ml-2 block text-sm text-dark">
                            Karyawan Aktif
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <div class="bg-light p-4 rounded-md">
                    <h3 class="font-medium text-dark mb-2">Informasi Akun</h3>
                    <p class="text-sm text-secondary">
                        <strong>Role:</strong> {{ ucfirst($employee->role) }}<br>
                        <strong>Bergabung:</strong> {{ $employee->created_at->format('d M Y') }}<br>
                        <strong>Terakhir Update:</strong> {{ $employee->updated_at->format('d M Y H:i') }}
                    </p>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('admin.employees.show', $employee) }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-primary text-white rounded-md hover:bg-orange-600">
                    <i class="fas fa-save mr-2"></i>Update Karyawan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
