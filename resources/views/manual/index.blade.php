@extends('layouts.app')

@section('title', 'Manual Book - Logbook System')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-dark">📚 Manual Book</h1>
        <a href="{{ route('dashboard') }}" class="bg-secondary text-white px-4 py-2 rounded-md hover:bg-blue-600">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
        </a>
    </div>

    <!-- Introduction -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-dark mb-4">🎯 Selamat Datang di Manual Book</h2>
        <p class="text-secondary leading-relaxed mb-4">
            Manual Book ini dirancang untuk membantu Anda memahami dan menggunakan Logbook System dengan maksimal. 
            Sistem ini menyediakan panduan lengkap untuk karyawan dan admin dalam mengelola aktivitas kerja sehari-hari.
        </p>
        <div class="bg-light p-4 rounded-lg">
            <h3 class="font-semibold text-dark mb-2">📖 Apa yang akan Anda pelajari:</h3>
            <ul class="text-sm text-secondary space-y-1">
                <li>✅ Cara menggunakan semua fitur sistem</li>
                <li>✅ Tips dan best practices</li>
                <li>✅ Troubleshooting masalah umum</li>
                <li>✅ Panduan role-specific (Karyawan & Admin)</li>
            </ul>
        </div>
    </div>

    <!-- Manual Options -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Employee Manual -->
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-primary hover:shadow-lg transition-shadow">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-primary bg-opacity-10">
                    <i class="fas fa-user text-primary text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-xl font-bold text-dark">Manual Karyawan</h3>
                    <p class="text-sm text-secondary">Panduan lengkap untuk estimator</p>
                </div>
            </div>
            
            <div class="space-y-3 mb-6">
                <h4 class="font-semibold text-dark">📋 Yang akan dipelajari:</h4>
                <ul class="text-sm text-secondary space-y-2">
                    <li>🕐 <strong>Sesi Kerja:</strong> Cara mulai dan akhiri sesi kerja</li>
                    <li>📝 <strong>Manajemen Tugas:</strong> Buat, edit, dan update status tugas</li>
                    <li>📊 <strong>Laporan:</strong> Generate dan lihat laporan mingguan</li>
                    <li>📈 <strong>Analytics:</strong> Analisis performa personal</li>
                    <li>💡 <strong>Tips:</strong> Best practices dan troubleshooting</li>
                </ul>
            </div>
            
            <a href="{{ route('manual.employee') }}" class="block w-full bg-primary text-white text-center py-3 rounded-md hover:bg-orange-600 transition-colors">
                <i class="fas fa-book-open mr-2"></i>Buka Manual Karyawan
            </a>
        </div>

        <!-- Admin Manual -->
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-secondary hover:shadow-lg transition-shadow">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-secondary bg-opacity-10">
                    <i class="fas fa-user-cog text-secondary text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-xl font-bold text-dark">Manual Admin</h3>
                    <p class="text-sm text-secondary">Panduan lengkap untuk administrator</p>
                </div>
            </div>
            
            <div class="space-y-3 mb-6">
                <h4 class="font-semibold text-dark">⚙️ Yang akan dipelajari:</h4>
                <ul class="text-sm text-secondary space-y-2">
                    <li>👥 <strong>Manajemen Karyawan:</strong> CRUD dan monitoring karyawan</li>
                    <li>📈 <strong>Dashboard Admin:</strong> Overview statistik perusahaan</li>
                    <li>📋 <strong>Laporan Company:</strong> Generate laporan company</li>
                    <li>📊 <strong>Analytics:</strong> Grafik dan analisis mendalam</li>
                    <li>🖨️ <strong>Print & Export:</strong> Cetak laporan ke PDF</li>
                </ul>
            </div>
            
            @if(auth()->user()->isAdmin())
                <a href="{{ route('manual.admin') }}" class="block w-full bg-secondary text-white text-center py-3 rounded-md hover:bg-blue-600 transition-colors">
                    <i class="fas fa-cogs mr-2"></i>Buka Manual Admin
                </a>
            @else
                <div class="block w-full bg-gray-300 text-gray-500 text-center py-3 rounded-md cursor-not-allowed">
                    <i class="fas fa-lock mr-2"></i>Hanya untuk Admin
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Access -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-dark mb-4">🚀 Akses Cepat</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center p-4 bg-light rounded-lg">
                <i class="fas fa-question-circle text-primary text-2xl mb-2"></i>
                <h3 class="font-semibold text-dark mb-1">FAQ</h3>
                <p class="text-xs text-secondary">Pertanyaan yang sering ditanyakan</p>
            </div>
            
            <div class="text-center p-4 bg-light rounded-lg">
                <i class="fas fa-life-ring text-green-500 text-2xl mb-2"></i>
                <h3 class="font-semibold text-dark mb-1">Support</h3>
                <p class="text-xs text-secondary">Bantuan teknis dan customer service</p>
            </div>
            
            <div class="text-center p-4 bg-light rounded-lg">
                <i class="fas fa-download text-blue-500 text-2xl mb-2"></i>
                <h3 class="font-semibold text-dark mb-1">Download PDF</h3>
                <p class="text-xs text-secondary">Manual dalam format PDF</p>
            </div>
        </div>
    </div>

    <!-- System Info -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="text-center">
            <h2 class="text-xl font-bold text-dark mb-2">📋 Logbook System</h2>
            <p class="text-secondary">Manual Book - Versi 1.0</p>
            <p class="text-sm text-gray-500 mt-2">Terakhir diupdate: {{ now()->format('d M Y') }}</p>
        </div>
    </div>
</div>
@endsection
