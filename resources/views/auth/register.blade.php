@extends('layouts.app')

@section('title', 'Register - Logbook System')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-light py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-primary">
                <i class="fas fa-user-plus text-white text-xl"></i>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-dark">
                Daftar Akun Baru
            </h2>
            <p class="mt-2 text-center text-sm text-secondary">
                Buat akun baru untuk sistem logbook
            </p>
        </div>
        <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-dark">Nama Lengkap</label>
                    <input id="name" name="name" type="text" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-dark rounded-md focus:outline-none focus:ring-primary focus:border-primary sm:text-sm @error('name') border-red-500 @enderror"
                           placeholder="Masukkan nama lengkap" value="{{ old('name') }}">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-dark">Email</label>
                    <input id="email" name="email" type="email" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-dark rounded-md focus:outline-none focus:ring-primary focus:border-primary sm:text-sm @error('email') border-red-500 @enderror"
                           placeholder="Masukkan email" value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="employee_id" class="block text-sm font-medium text-dark">ID Karyawan</label>
                    <input id="employee_id" name="employee_id" type="text" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-dark rounded-md focus:outline-none focus:ring-primary focus:border-primary sm:text-sm @error('employee_id') border-red-500 @enderror"
                           placeholder="Contoh: EMP001" value="{{ old('employee_id') }}">
                    @error('employee_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="department" class="block text-sm font-medium text-dark">Departemen</label>
                    <input id="department" name="department" type="text" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-dark rounded-md focus:outline-none focus:ring-primary focus:border-primary sm:text-sm @error('department') border-red-500 @enderror"
                           placeholder="Contoh: IT, HR, Finance" value="{{ old('department') }}">
                    @error('department')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="position" class="block text-sm font-medium text-dark">Jabatan</label>
                    <input id="position" name="position" type="text" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-dark rounded-md focus:outline-none focus:ring-primary focus:border-primary sm:text-sm @error('position') border-red-500 @enderror"
                           placeholder="Contoh: Senior Estimator" value="{{ old('position') }}">
                    @error('position')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-dark">Role</label>
                    <select id="role" name="role" required 
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary sm:text-sm @error('role') border-red-500 @enderror">
                        <option value="">Pilih role</option>
                        <option value="estimator" {{ old('role') == 'estimator' ? 'selected' : '' }}>Estimator</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-dark">Password</label>
                    <input id="password" name="password" type="password" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-dark rounded-md focus:outline-none focus:ring-primary focus:border-primary sm:text-sm @error('password') border-red-500 @enderror"
                           placeholder="Minimal 8 karakter">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-dark">Konfirmasi Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-dark rounded-md focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                           placeholder="Ulangi password">
                </div>
            </div>

            <div>
                <button type="submit" 
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-user-plus"></i>
                    </span>
                    Daftar
                </button>
            </div>

            <div class="text-center">
                <a href="{{ route('login') }}" class="text-primary hover:text-orange-600 text-sm">
                    Sudah punya akun? Login disini
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
