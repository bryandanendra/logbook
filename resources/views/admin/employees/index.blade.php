@extends('layouts.app')

@section('title', 'Kelola Karyawan - Admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-dark">Kelola Karyawan</h1>
        <a href="{{ route('admin.employees.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-orange-600">
            <i class="fas fa-plus mr-2"></i>Tambah Karyawan
        </a>
    </div>

    @if($employees->count() > 0)
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider relative group">
                                Karyawan
                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
                                    👤 Nama dan email karyawan
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider relative group">
                                ID
                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
                                    🆔 ID unik karyawan untuk identifikasi
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider relative group">
                                Departemen
                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
                                    🏢 Departemen tempat karyawan bekerja
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider relative group">
                                Jabatan
                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
                                    💼 Jabatan atau posisi karyawan
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider relative group">
                                Status
                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
                                    🔄 Status aktif/nonaktif karyawan
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider relative group">
                                Aksi
                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 bg-gray-800 text-white text-xs p-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
                                    ⚙️ Aksi yang dapat dilakukan (lihat detail, edit)
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($employees as $employee)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-primary flex items-center justify-center">
                                            <span class="text-white font-medium">{{ substr($employee->name, 0, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-dark">{{ $employee->name }}</div>
                                        <div class="text-sm text-secondary">{{ $employee->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-dark">
                                {{ $employee->employee_id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-dark">
                                {{ $employee->department }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-dark">
                                {{ $employee->position }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($employee->is_active)
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Aktif</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.employees.show', $employee) }}" class="text-primary hover:text-orange-600">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.employees.edit', $employee) }}" class="text-secondary hover:text-blue-600">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-4">
            {{ $employees->links() }}
        </div>
    @else
        <div class="bg-white p-8 rounded-lg shadow-md text-center">
            <i class="fas fa-users text-4xl text-secondary mb-4"></i>
            <h3 class="text-lg font-medium text-dark mb-2">Belum ada karyawan</h3>
            <p class="text-secondary mb-4">Mulai dengan menambahkan karyawan pertama!</p>
            <a href="{{ route('admin.employees.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-orange-600">
                <i class="fas fa-plus mr-2"></i>Tambah Karyawan
            </a>
        </div>
    @endif
</div>
@endsection
