@extends('layouts.app')

@section('title', 'Manual Book Karyawan - Logbook System')

@push('styles')
<style>
    .manual-section {
        page-break-inside: avoid;
    }
    @media print {
        .no-print { display: none; }
        .manual-section { page-break-inside: avoid; }
        body { font-size: 12px; }
        .text-3xl { font-size: 24px; }
        .text-2xl { font-size: 20px; }
        .text-xl { font-size: 18px; }
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-dark">📚 Manual Book Karyawan</h1>
        <div class="flex space-x-2 no-print">
            <button onclick="window.print()" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                <i class="fas fa-print mr-2"></i>Print Manual
            </button>
            <a href="{{ route('manual') }}" class="bg-secondary text-white px-4 py-2 rounded-md hover:bg-blue-600">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Table of Contents -->
    <div class="bg-white p-6 rounded-lg shadow-md manual-section">
        <h2 class="text-2xl font-bold text-dark mb-4">📋 Daftar Isi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <h3 class="font-semibold text-primary mb-2">1. Pendahuluan</h3>
                <ul class="text-sm text-secondary space-y-1 ml-4">
                    <li>• Tujuan Sistem</li>
                    <li>• Manfaat Penggunaan</li>
                    <li>• Fitur Utama</li>
                </ul>
                
                <h3 class="font-semibold text-primary mb-2 mt-4">2. Login & Logout</h3>
                <ul class="text-sm text-secondary space-y-1 ml-4">
                    <li>• Cara Login</li>
                    <li>• Cara Logout</li>
                    <li>• Troubleshooting Login</li>
                </ul>
            </div>
            <div>
                <h3 class="font-semibold text-primary mb-2">3. Sesi Kerja</h3>
                <ul class="text-sm text-secondary space-y-1 ml-4">
                    <li>• Memulai Sesi Kerja</li>
                    <li>• Mengakhiri Sesi Kerja</li>
                    <li>• Melihat Histori Sesi</li>
                </ul>
                
                <h3 class="font-semibold text-primary mb-2 mt-4">4. Manajemen Tugas</h3>
                <ul class="text-sm text-secondary space-y-1 ml-4">
                    <li>• Membuat Tugas Baru</li>
                    <li>• Update Status Tugas</li>
                    <li>• Edit & Delete Tugas</li>
                    <li>• Filter Tugas</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Pendahuluan -->
    <div class="bg-white p-6 rounded-lg shadow-md manual-section">
        <h2 class="text-2xl font-bold text-dark mb-4">🎯 Pendahuluan</h2>
        
        <div class="space-y-6">
            <div>
                <h3 class="text-xl font-semibold text-primary mb-3">Tujuan Sistem</h3>
                <p class="text-secondary leading-relaxed">
                    Logbook System adalah aplikasi web yang dirancang untuk membantu karyawan mencatat dan mengelola aktivitas kerja sehari-hari. 
                    Sistem ini memungkinkan tracking waktu kerja yang akurat, manajemen tugas yang terstruktur, dan pelaporan performa otomatis.
                </p>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-primary mb-3">Manfaat Penggunaan</h3>
                <ul class="text-secondary space-y-2">
                    <li>✅ <strong>Tracking Waktu Kerja:</strong> Mencatat waktu mulai dan selesai kerja dengan presisi tinggi</li>
                    <li>✅ <strong>Manajemen Tugas:</strong> Mengorganisir dan melacak progress tugas harian dengan status yang jelas</li>
                    <li>✅ <strong>Pelaporan Otomatis:</strong> Generate laporan mingguan secara otomatis berdasarkan data aktivitas</li>
                    <li>✅ <strong>Analisis Performa:</strong> Melihat statistik produktivitas dan trend kerja personal</li>
                    <li>✅ <strong>Transparansi:</strong> Memberikan visibilitas kepada manajemen tentang progress kerja</li>
                    <li>✅ <strong>Evaluasi Diri:</strong> Membantu karyawan mengevaluasi dan meningkatkan produktivitas</li>
                </ul>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-primary mb-3">Fitur Utama</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-light p-4 rounded-lg">
                        <h4 class="font-semibold text-dark mb-2">🕐 Sesi Kerja</h4>
                        <p class="text-sm text-secondary">Mulai dan akhiri sesi kerja, catat aktivitas harian dengan timestamp akurat</p>
                    </div>
                    <div class="bg-light p-4 rounded-lg">
                        <h4 class="font-semibold text-dark mb-2">📝 Manajemen Tugas</h4>
                        <p class="text-sm text-secondary">Buat, edit, update status tugas dengan prioritas dan deadline</p>
                    </div>
                    <div class="bg-light p-4 rounded-lg">
                        <h4 class="font-semibold text-dark mb-2">📊 Laporan Mingguan</h4>
                        <p class="text-sm text-secondary">Generate laporan otomatis dengan statistik jam kerja dan productivity score</p>
                    </div>
                    <div class="bg-light p-4 rounded-lg">
                        <h4 class="font-semibold text-dark mb-2">📈 Analytics Personal</h4>
                        <p class="text-sm text-secondary">Lihat statistik bulanan, trend produktivitas, dan distribusi tugas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Login & Logout -->
    <div class="bg-white p-6 rounded-lg shadow-md manual-section">
        <h2 class="text-2xl font-bold text-dark mb-4">🔐 Login & Logout</h2>

        <div class="space-y-6">
            <div class="bg-light p-4 rounded-lg">
                <h3 class="text-xl font-semibold text-dark mb-3">Cara Login:</h3>
                <ol class="text-secondary space-y-2 ml-4">
                    <li><strong>1.</strong> Buka browser (Chrome, Firefox, Safari, dll)</li>
                    <li><strong>2.</strong> Akses URL sistem logbook yang telah diberikan oleh admin</li>
                    <li><strong>3.</strong> Masukkan <strong>email</strong> dan <strong>password</strong> yang telah diberikan</li>
                    <li><strong>4.</strong> Klik tombol <span class="bg-primary text-white px-2 py-1 rounded text-sm">Login</span></li>
                    <li><strong>5.</strong> Sistem akan mengarahkan ke dashboard sesuai role Anda</li>
                </ol>
                
                <div class="mt-4 p-3 bg-blue-50 border-l-4 border-blue-400">
                    <p class="text-sm text-blue-800">
                        <strong>💡 Tips:</strong> Simpan URL di bookmark browser untuk akses cepat di hari berikutnya.
                    </p>
                </div>
            </div>

            <div class="bg-light p-4 rounded-lg">
                <h3 class="text-xl font-semibold text-dark mb-3">Cara Logout:</h3>
                <ol class="text-secondary space-y-2 ml-4">
                    <li><strong>1.</strong> Klik nama user di pojok kanan atas navbar</li>
                    <li><strong>2.</strong> Klik tombol <span class="bg-red-500 text-white px-2 py-1 rounded text-sm">Logout</span></li>
                    <li><strong>3.</strong> Sistem akan mengarahkan kembali ke halaman login</li>
                    <li><strong>4.</strong> Session Anda akan otomatis berakhir</li>
                </ol>
                
                <div class="mt-4 p-3 bg-yellow-50 border-l-4 border-yellow-400">
                    <p class="text-sm text-yellow-800">
                        <strong>⚠️ Penting:</strong> Selalu logout setelah selesai menggunakan sistem, terutama di komputer bersama.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sesi Kerja -->
    <div class="bg-white p-6 rounded-lg shadow-md manual-section">
        <h2 class="text-2xl font-bold text-dark mb-4">🕐 Sesi Kerja</h2>

        <div class="space-y-6">
            <div class="bg-light p-4 rounded-lg">
                <h3 class="text-xl font-semibold text-dark mb-3">Memulai Sesi Kerja:</h3>
                <ol class="text-secondary space-y-2 ml-4">
                    <li><strong>1.</strong> Setelah login, Anda akan berada di Dashboard</li>
                    <li><strong>2.</strong> Klik tombol <span class="bg-primary text-white px-2 py-1 rounded text-sm">Mulai Kerja</span> (hijau) di bagian atas</li>
                    <li><strong>3.</strong> Atau akses menu "Sesi Kerja" → "Buat Sesi Baru"</li>
                    <li><strong>4.</strong> Isi catatan kerja (opsional) untuk mencatat rencana hari ini</li>
                    <li><strong>5.</strong> Klik <span class="bg-primary text-white px-2 py-1 rounded text-sm">Mulai Sesi</span></li>
                    <li><strong>6.</strong> Status akan berubah menjadi <span class="bg-green-500 text-white px-2 py-1 rounded text-sm">Sedang Bekerja</span></li>
                </ol>

                <div class="mt-4 p-3 bg-green-50 border-l-4 border-green-400">
                    <p class="text-sm text-green-800">
                        <strong>✅ Berhasil:</strong> Anda sekarang dapat mulai membuat tugas dan mencatat aktivitas kerja.
                    </p>
                </div>
            </div>

            <div class="bg-light p-4 rounded-lg">
                <h3 class="text-xl font-semibold text-dark mb-3">Mengakhiri Sesi Kerja:</h3>
                <ol class="text-secondary space-y-2 ml-4">
                    <li><strong>1.</strong> Pastikan semua tugas hari ini sudah diinput</li>
                    <li><strong>2.</strong> Dari dashboard, klik "Lihat Detail" pada sesi aktif</li>
                    <li><strong>3.</strong> Review tugas-tugas yang sudah dibuat</li>
                    <li><strong>4.</strong> Klik tombol <span class="bg-red-500 text-white px-2 py-1 rounded text-sm">Akhiri Sesi</span></li>
                    <li><strong>5.</strong> Konfirmasi pengakhiran sesi</li>
                    <li><strong>6.</strong> Sistem akan menghitung durasi kerja otomatis</li>
                </ol>

                <div class="mt-4 p-3 bg-red-50 border-l-4 border-red-400">
                    <p class="text-sm text-red-800">
                        <strong>⚠️ Perhatian:</strong> Pastikan mengakhiri sesi kerja sebelum pulang agar data waktu kerja tercatat dengan akurat.
                    </p>
                </div>
            </div>

            <div class="bg-light p-4 rounded-lg">
                <h3 class="text-xl font-semibold text-dark mb-3">Melihat Histori Sesi:</h3>
                <ol class="text-secondary space-y-2 ml-4">
                    <li><strong>1.</strong> Akses menu "Sesi Kerja" di navbar</li>
                    <li><strong>2.</strong> Anda akan melihat daftar semua sesi kerja</li>
                    <li><strong>3.</strong> Klik icon mata untuk melihat detail sesi</li>
                    <li><strong>4.</strong> Review tugas yang dibuat dalam sesi tersebut</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Manajemen Tugas -->
    <div class="bg-white p-6 rounded-lg shadow-md manual-section">
        <h2 class="text-2xl font-bold text-dark mb-4">📝 Manajemen Tugas</h2>

        <div class="space-y-6">
            <div class="bg-light p-4 rounded-lg">
                <h3 class="text-xl font-semibold text-dark mb-3">Membuat Tugas Baru:</h3>
                <ol class="text-secondary space-y-2 ml-4">
                    <li><strong>1.</strong> Pastikan sesi kerja sudah aktif</li>
                    <li><strong>2.</strong> Akses menu "Tugas" → "Buat Tugas Baru"</li>
                    <li><strong>3.</strong> Isi <strong>Judul Tugas</strong> (wajib diisi)</li>
                    <li><strong>4.</strong> Isi <strong>Deskripsi</strong> tugas dengan detail (opsional)</li>
                    <li><strong>5.</strong> Pilih <strong>Prioritas:</strong>
                        <ul class="ml-4 mt-2 space-y-1">
                            <li>• <span class="text-red-600">High:</span> Tugas urgent/penting</li>
                            <li>• <span class="text-yellow-600">Medium:</span> Tugas normal</li>
                            <li>• <span class="text-green-600">Low:</span> Tugas tidak urgent</li>
                        </ul>
                    </li>
                    <li><strong>6.</strong> Set <strong>Deadline</strong> jika ada (opsional)</li>
                    <li><strong>7.</strong> Klik <span class="bg-primary text-white px-2 py-1 rounded text-sm">Simpan Tugas</span></li>
                </ol>

                <div class="mt-4 p-3 bg-blue-50 border-l-4 border-blue-400">
                    <p class="text-sm text-blue-800">
                        <strong>💡 Tips:</strong> Gunakan deskripsi yang jelas agar mudah diingat dan dipahami oleh atasan.
                    </p>
                </div>
            </div>

            <div class="bg-light p-4 rounded-lg">
                <h3 class="text-xl font-semibold text-dark mb-3">Update Status Tugas:</h3>
                <ol class="text-secondary space-y-2 ml-4">
                    <li><strong>1.</strong> Akses menu "Tugas" atau dari dashboard</li>
                    <li><strong>2.</strong> Klik pada tugas yang ingin diupdate</li>
                    <li><strong>3.</strong> Pilih status baru:
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-3">
                            <div class="text-center p-2 bg-yellow-100 rounded">
                                <span class="text-yellow-800 font-medium">⏳ Pending</span>
                                <p class="text-xs text-yellow-600">Belum dikerjakan</p>
                            </div>
                            <div class="text-center p-2 bg-blue-100 rounded">
                                <span class="text-blue-800 font-medium">🔄 In Progress</span>
                                <p class="text-xs text-blue-600">Sedang dikerjakan</p>
                            </div>
                            <div class="text-center p-2 bg-green-100 rounded">
                                <span class="text-green-800 font-medium">✅ Completed</span>
                                <p class="text-xs text-green-600">Sudah selesai</p>
                            </div>
                        </div>
                    </li>
                    <li><strong>4.</strong> Klik <span class="bg-green-500 text-white px-2 py-1 rounded text-sm">Update Status</span></li>
                </ol>
            </div>

            <div class="bg-light p-4 rounded-lg">
                <h3 class="text-xl font-semibold text-dark mb-3">Filter Tugas:</h3>
                <ul class="text-secondary space-y-2">
                    <li>📅 <strong>Hari Ini:</strong> Klik tombol "Hari Ini" untuk melihat tugas yang dibuat hari ini</li>
                    <li>⏳ <strong>Pending:</strong> Klik tombol "Pending" untuk melihat tugas yang belum dikerjakan</li>
                    <li>📊 <strong>Semua Tugas:</strong> Akses menu "Tugas" untuk melihat semua tugas dengan pagination</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Laporan & Analytics -->
    <div class="bg-white p-6 rounded-lg shadow-md manual-section">
        <h2 class="text-2xl font-bold text-dark mb-4">📊 Laporan & Analytics</h2>

        <div class="space-y-6">
            <div class="bg-light p-4 rounded-lg">
                <h3 class="text-xl font-semibold text-dark mb-3">Generate Laporan Mingguan:</h3>
                <ol class="text-secondary space-y-2 ml-4">
                    <li><strong>1.</strong> Akses menu "Laporan"</li>
                    <li><strong>2.</strong> Klik <span class="bg-green-500 text-white px-2 py-1 rounded text-sm">Generate Laporan Mingguan</span></li>
                    <li><strong>3.</strong> Sistem akan membuat laporan otomatis untuk minggu ini</li>
                    <li><strong>4.</strong> Laporan berisi:
                        <ul class="ml-4 mt-2 space-y-1">
                            <li>• Total jam kerja</li>
                            <li>• Jumlah tugas selesai</li>
                            <li>• Jumlah tugas pending</li>
                            <li>• Productivity Score (%)</li>
                        </ul>
                    </li>
                </ol>

                <div class="mt-4 p-3 bg-green-50 border-l-4 border-green-400">
                    <p class="text-sm text-green-800">
                        <strong>✨ Productivity Score:</strong> Dihitung berdasarkan persentase tugas yang selesai dibanding total tugas dalam periode tertentu.
                    </p>
                </div>
            </div>

            <div class="bg-light p-4 rounded-lg">
                <h3 class="text-xl font-semibold text-dark mb-3">Analytics Personal:</h3>
                <ol class="text-secondary space-y-2 ml-4">
                    <li><strong>1.</strong> Akses menu "Laporan" → "Analytics"</li>
                    <li><strong>2.</strong> Atau klik tombol "Analytics" di dashboard</li>
                    <li><strong>3.</strong> Lihat statistik bulanan:
                        <ul class="ml-4 mt-2 space-y-1">
                            <li>• Total tugas bulan ini</li>
                            <li>• Total jam kerja</li>
                            <li>• Rata-rata jam per hari</li>
                            <li>• Productivity score bulanan</li>
                        </ul>
                    </li>
                    <li><strong>4.</strong> Analisis trend produktivitas 4 minggu terakhir</li>
                    <li><strong>5.</strong> Review distribusi tugas berdasarkan status</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Tips & Best Practices -->
    <div class="bg-white p-6 rounded-lg shadow-md manual-section">
        <h2 class="text-2xl font-bold text-dark mb-4">💡 Tips & Best Practices</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-primary mb-3">⏰ Manajemen Waktu</h3>
                <ul class="text-sm text-secondary space-y-2">
                    <li>• Mulai sesi kerja tepat waktu setiap hari</li>
                    <li>• Akhiri sesi kerja sebelum pulang</li>
                    <li>• Gunakan catatan untuk aktivitas penting</li>
                    <li>• Review laporan mingguan secara rutin</li>
                    <li>• Bandingkan performa mingguan untuk evaluasi</li>
                </ul>
            </div>
            
            <div>
                <h3 class="text-lg font-semibold text-primary mb-3">📝 Manajemen Tugas</h3>
                <ul class="text-sm text-secondary space-y-2">
                    <li>• Buat tugas dengan deskripsi yang jelas</li>
                    <li>• Update status tugas secara berkala</li>
                    <li>• Set prioritas sesuai urgensi pekerjaan</li>
                    <li>• Gunakan deadline untuk tugas penting</li>
                    <li>• Pecah tugas besar menjadi sub-tugas kecil</li>
                </ul>
            </div>
            
            <div>
                <h3 class="text-lg font-semibold text-primary mb-3">📊 Pelaporan</h3>
                <ul class="text-sm text-secondary space-y-2">
                    <li>• Generate laporan mingguan setiap Jumat</li>
                    <li>• Review analytics bulanan untuk evaluasi</li>
                    <li>• Bandingkan performa antar periode</li>
                    <li>• Gunakan data untuk perbaikan produktivitas</li>
                    <li>• Diskusikan hasil dengan atasan jika perlu</li>
                </ul>
            </div>
            
            <div>
                <h3 class="text-lg font-semibold text-primary mb-3">🔒 Keamanan</h3>
                <ul class="text-sm text-secondary space-y-2">
                    <li>• Jangan bagikan password ke siapapun</li>
                    <li>• Logout setelah selesai menggunakan</li>
                    <li>• Jangan akses dari perangkat publik</li>
                    <li>• Laporkan masalah teknis ke admin</li>
                    <li>• Jaga kerahasiaan data perusahaan</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Troubleshooting -->
    <div class="bg-white p-6 rounded-lg shadow-md manual-section">
        <h2 class="text-2xl font-bold text-dark mb-4">🔧 Troubleshooting</h2>
        
        <div class="space-y-4">
            <div class="border-l-4 border-red-400 pl-4">
                <h3 class="font-semibold text-red-800">❌ Tidak bisa login</h3>
                <p class="text-sm text-secondary mb-2">Solusi:</p>
                <ul class="text-sm text-secondary ml-4 space-y-1">
                    <li>• Periksa email dan password</li>
                    <li>• Pastikan caps lock tidak aktif</li>
                    <li>• Clear cache browser</li>
                    <li>• Hubungi admin jika lupa password</li>
                </ul>
            </div>
            
            <div class="border-l-4 border-yellow-400 pl-4">
                <h3 class="font-semibold text-yellow-800">⚠️ Tidak bisa buat tugas</h3>
                <p class="text-sm text-secondary mb-2">Solusi:</p>
                <ul class="text-sm text-secondary ml-4 space-y-1">
                    <li>• Pastikan sesi kerja sudah aktif</li>
                    <li>• Mulai sesi kerja terlebih dahulu</li>
                    <li>• Refresh halaman jika perlu</li>
                    <li>• Periksa koneksi internet</li>
                </ul>
            </div>
            
            <div class="border-l-4 border-blue-400 pl-4">
                <h3 class="font-semibold text-blue-800">ℹ️ Laporan tidak muncul</h3>
                <p class="text-sm text-secondary mb-2">Solusi:</p>
                <ul class="text-sm text-secondary ml-4 space-y-1">
                    <li>• Pastikan sudah ada data tugas dalam periode tersebut</li>
                    <li>• Cek apakah sesi kerja sudah diakhiri</li>
                    <li>• Tunggu beberapa saat lalu refresh</li>
                    <li>• Hubungi admin jika masih bermasalah</li>
                </ul>
            </div>
            
            <div class="border-l-4 border-green-400 pl-4">
                <h3 class="font-semibold text-green-800">📞 Kontak Support</h3>
                <p class="text-sm text-secondary mb-2">Untuk bantuan lebih lanjut:</p>
                <ul class="text-sm text-secondary ml-4 space-y-1">
                    <li>• Hubungi admin sistem</li>
                    <li>• Contact tim IT support</li>
                    <li>• Email ke support@company.com</li>
                    <li>• Sertakan screenshot error jika ada</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="bg-white p-6 rounded-lg shadow-md manual-section">
        <div class="text-center">
            <h2 class="text-xl font-bold text-dark mb-2">📋 Logbook System</h2>
            <p class="text-secondary">Manual Book Karyawan - Versi 1.0</p>
            <p class="text-sm text-gray-500 mt-2">Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Print functionality
    const style = document.createElement('style');
    style.textContent = `
        @media print {
            body * {
                visibility: hidden;
            }
            .space-y-6, .space-y-6 * {
                visibility: visible;
            }
            .no-print {
                display: none !important;
            }
        }
    `;
    document.head.appendChild(style);
</script>
@endpush
@endsection
