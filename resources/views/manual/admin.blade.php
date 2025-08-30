@extends('layouts.app')

@section('title', 'Manual Book Admin - Logbook System')

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
        <h1 class="text-3xl font-bold text-dark">👨‍💼 Manual Book Admin</h1>
        <div class="flex space-x-2 no-print">
            <button onclick="window.print()" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                <i class="fas fa-print mr-2"></i>Print Manual
            </button>
            @if(auth()->user()->isAdmin() && (request()->is('admin*') || request()->get('mode') === 'admin'))
                <a href="{{ route('admin.dashboard') }}" class="bg-secondary text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Admin
                </a>
            @else
                <a href="{{ route('manual') }}" class="bg-secondary text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            @endif
        </div>
    </div>

    <!-- Table of Contents -->
    <div class="bg-white p-6 rounded-lg shadow-md manual-section">
        <h2 class="text-2xl font-bold text-dark mb-4">📋 Daftar Isi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <h3 class="font-semibold text-primary mb-2">1. Peran Admin</h3>
                <ul class="text-sm text-secondary space-y-1 ml-4">
                    <li>• Tanggung Jawab</li>
                    <li>• Hak Akses</li>
                    <li>• Dashboard Admin</li>
                </ul>
                
                <h3 class="font-semibold text-primary mb-2 mt-4">2. Manajemen Karyawan</h3>
                <ul class="text-sm text-secondary space-y-1 ml-4">
                    <li>• Tambah Karyawan</li>
                    <li>• Edit Data Karyawan</li>
                    <li>• Monitor Performa</li>
                </ul>
            </div>
            <div>
                <h3 class="font-semibold text-primary mb-2">3. Laporan & Analytics</h3>
                <ul class="text-sm text-secondary space-y-1 ml-4">
                    <li>• Laporan Company</li>
                    <li>• Analytics Dashboard</li>
                    <li>• Export PDF</li>
                </ul>
                
                <h3 class="font-semibold text-primary mb-2 mt-4">4. Tips & Best Practices</h3>
                <ul class="text-sm text-secondary space-y-1 ml-4">
                    <li>• Monitoring Efektif</li>
                    <li>• Evaluasi Performa</li>
                    <li>• Security Guidelines</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Peran Admin -->
    <div class="bg-white p-6 rounded-lg shadow-md manual-section">
        <h2 class="text-2xl font-bold text-dark mb-4">👨‍💼 Peran Admin</h2>
        
        <div class="space-y-6">
            <div>
                <h3 class="text-xl font-semibold text-primary mb-3">Tanggung Jawab</h3>
                <ul class="text-secondary space-y-2">
                    <li>🔐 <strong>Manajemen User:</strong> Menambah, mengedit, dan menghapus akun karyawan dengan data lengkap</li>
                    <li>👀 <strong>Monitoring:</strong> Memantau aktivitas kerja dan performa seluruh karyawan secara real-time</li>
                    <li>📈 <strong>Analisis Data:</strong> Menganalisis statistik perusahaan untuk evaluasi dan decision making</li>
                    <li>📋 <strong>Pelaporan:</strong> Membuat laporan company komprehensif untuk manajemen tingkat atas</li>
                    <li>⚙️ <strong>Konfigurasi:</strong> Mengatur sistem, parameter, dan kebijakan perusahaan</li>
                    <li>🛡️ <strong>Security:</strong> Menjaga keamanan data dan akses sistem</li>
                </ul>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-primary mb-3">Hak Akses</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-light p-4 rounded-lg">
                        <h4 class="font-semibold text-dark mb-2">✅ Akses Penuh</h4>
                        <ul class="text-sm text-secondary space-y-1">
                            <li>• Dashboard Admin dengan statistik lengkap</li>
                            <li>• CRUD manajemen karyawan</li>
                            <li>• Laporan company seluruh karyawan</li>
                            <li>• Analytics & grafik mendalam</li>
                            <li>• Export data ke format PDF</li>
                        </ul>
                    </div>
                    <div class="bg-light p-4 rounded-lg">
                        <h4 class="font-semibold text-dark mb-2">🔒 Keamanan & Privacy</h4>
                        <ul class="text-sm text-secondary space-y-1">
                            <li>• Akses data sensitif seluruh karyawan</li>
                            <li>• Monitoring aktivitas real-time</li>
                            <li>• Generate laporan konfidensial</li>
                            <li>• Audit trail system activities</li>
                            <li>• Role-based access control</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-primary mb-3">Dashboard Admin Overview</h3>
                <div class="bg-light p-4 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-medium text-dark mb-2">📊 Statistik Harian:</h4>
                            <ul class="text-sm text-secondary space-y-1">
                                <li>• Total karyawan aktif</li>
                                <li>• Karyawan sedang bekerja</li>
                                <li>• Total tugas hari ini</li>
                                <li>• Tugas completed hari ini</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-medium text-dark mb-2">📈 Statistik Mingguan:</h4>
                            <ul class="text-sm text-secondary space-y-1">
                                <li>• Total tugas minggu ini</li>
                                <li>• Completion rate</li>
                                <li>• Total jam kerja company</li>
                                <li>• Rata-rata productivity</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Manajemen Karyawan -->
    <div class="bg-white p-6 rounded-lg shadow-md manual-section">
        <h2 class="text-2xl font-bold text-dark mb-4">👥 Manajemen Karyawan</h2>

        <div class="space-y-6">
            <div class="bg-light p-4 rounded-lg">
                <h3 class="text-xl font-semibold text-dark mb-3">Menambah Karyawan Baru:</h3>
                <ol class="text-secondary space-y-2 ml-4">
                    <li><strong>1.</strong> Akses menu <span class="bg-secondary text-white px-2 py-1 rounded text-sm">Karyawan</span> di admin panel</li>
                    <li><strong>2.</strong> Klik tombol <span class="bg-primary text-white px-2 py-1 rounded text-sm">Tambah Karyawan</span></li>
                    <li><strong>3.</strong> Isi data lengkap karyawan:
                        <ul class="ml-4 mt-2 space-y-1">
                            <li>• <strong>Nama Lengkap:</strong> Sesuai dokumen resmi</li>
                            <li>• <strong>Email:</strong> Email active yang akan digunakan login</li>
                            <li>• <strong>Employee ID:</strong> ID unik karyawan (tidak boleh sama)</li>
                            <li>• <strong>Department:</strong> Bagian/divisi karyawan</li>
                            <li>• <strong>Position:</strong> Jabatan/posisi dalam perusahaan</li>
                            <li>• <strong>Password:</strong> Password sementara (will be changed by employee)</li>
                        </ul>
                    </li>
                    <li><strong>4.</strong> Set role sebagai <span class="bg-blue-500 text-white px-2 py-1 rounded text-sm">estimator</span> (default)</li>
                    <li><strong>5.</strong> Pastikan status <span class="bg-green-500 text-white px-2 py-1 rounded text-sm">Active</span></li>
                    <li><strong>6.</strong> Klik <span class="bg-primary text-white px-2 py-1 rounded text-sm">Simpan</span> untuk membuat akun</li>
                    <li><strong>7.</strong> Berikan kredensial login kepada karyawan</li>
                </ol>

                <div class="mt-4 p-3 bg-blue-50 border-l-4 border-blue-400">
                    <p class="text-sm text-blue-800">
                        <strong>💡 Tips:</strong> Gunakan password sementara yang mudah diingat dan minta karyawan untuk mengganti setelah login pertama.
                    </p>
                </div>
            </div>

            <div class="bg-light p-4 rounded-lg">
                <h3 class="text-xl font-semibold text-dark mb-3">Mengedit Data Karyawan:</h3>
                <ol class="text-secondary space-y-2 ml-4">
                    <li><strong>1.</strong> Dari daftar karyawan, klik icon <span class="text-blue-500">✏️ Edit</span></li>
                    <li><strong>2.</strong> Update data yang diperlukan:
                        <ul class="ml-4 mt-2 space-y-1">
                            <li>• Department atau position jika ada promosi</li>
                            <li>• Status active/inactive sesuai kebutuhan</li>
                            <li>• Contact information jika berubah</li>
                        </ul>
                    </li>
                    <li><strong>3.</strong> Klik <span class="bg-primary text-white px-2 py-1 rounded text-sm">Update</span> untuk menyimpan perubahan</li>
                    <li><strong>4.</strong> Sistem akan otomatis log perubahan data</li>
                </ol>

                <div class="mt-4 p-3 bg-yellow-50 border-l-4 border-yellow-400">
                    <p class="text-sm text-yellow-800">
                        <strong>⚠️ Perhatian:</strong> Perubahan data karyawan akan mempengaruhi laporan dan analytics. Pastikan data selalu akurat.
                    </p>
                </div>
            </div>

            <div class="bg-light p-4 rounded-lg">
                <h3 class="text-xl font-semibold text-dark mb-3">Melihat Detail Karyawan:</h3>
                <ol class="text-secondary space-y-2 ml-4">
                    <li><strong>1.</strong> Klik icon <span class="text-green-500">👁️ Lihat</span> pada karyawan</li>
                    <li><strong>2.</strong> Review informasi lengkap:
                        <ul class="ml-4 mt-2 space-y-1">
                            <li>• Data personal dan contact</li>
                            <li>• Statistik performa mingguan</li>
                            <li>• Recent activities dan tasks</li>
                            <li>• Work session history</li>
                            <li>• Productivity trends</li>
                        </ul>
                    </li>
                    <li><strong>3.</strong> Analisis performa untuk evaluasi</li>
                    <li><strong>4.</strong> Identifikasi area yang perlu improvement</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Laporan Company -->
    <div class="bg-white p-6 rounded-lg shadow-md manual-section">
        <h2 class="text-2xl font-bold text-dark mb-4">📋 Laporan Company</h2>

        <div class="space-y-6">
            <div class="bg-light p-4 rounded-lg">
                <h3 class="text-xl font-semibold text-dark mb-3">Mengakses Laporan:</h3>
                <ol class="text-secondary space-y-2 ml-4">
                    <li><strong>1.</strong> Akses menu <span class="bg-secondary text-white px-2 py-1 rounded text-sm">Laporan</span> di admin panel</li>
                    <li><strong>2.</strong> Set filter periode jika diperlukan:
                        <ul class="ml-4 mt-2 space-y-1">
                            <li>• Tanggal mulai dan akhir</li>
                            <li>• Department specific (optional)</li>
                            <li>• Employee specific (optional)</li>
                        </ul>
                    </li>
                    <li><strong>3.</strong> Lihat ringkasan company performance</li>
                    <li><strong>4.</strong> Review laporan detail per karyawan</li>
                    <li><strong>5.</strong> Analisis trends dan patterns</li>
                </ol>
            </div>

            <div class="bg-light p-4 rounded-lg">
                <h3 class="text-xl font-semibold text-dark mb-3">Print Laporan ke PDF:</h3>
                <ol class="text-secondary space-y-2 ml-4">
                    <li><strong>1.</strong> Klik tombol <span class="bg-green-500 text-white px-2 py-1 rounded text-sm">Print Laporan</span></li>
                    <li><strong>2.</strong> Sistem akan menyiapkan format print-friendly</li>
                    <li><strong>3.</strong> Pilih printer atau <strong>Save as PDF</strong></li>
                    <li><strong>4.</strong> Laporan akan dicetak dengan:
                        <ul class="ml-4 mt-2 space-y-1">
                            <li>• Header company dengan periode</li>
                            <li>• Ringkasan executive summary</li>
                            <li>• Tabel detail per karyawan</li>
                            <li>• Footer dengan timestamp</li>
                        </ul>
                    </li>
                </ol>

                <div class="mt-4 p-3 bg-green-50 border-l-4 border-green-400">
                    <p class="text-sm text-green-800">
                        <strong>✨ Fitur PDF:</strong> Laporan PDF siap untuk dipresentasikan ke manajemen atau stakeholder eksternal.
                    </p>
                </div>
            </div>

            <div class="bg-light p-4 rounded-lg">
                <h3 class="text-xl font-semibold text-dark mb-3">Data Laporan Komprehensif:</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h4 class="font-medium text-dark mb-2">📈 Ringkasan Company:</h4>
                        <ul class="text-sm text-secondary space-y-1">
                            <li>• Total laporan dalam periode</li>
                            <li>• Rata-rata productivity score</li>
                            <li>• Total jam kerja company</li>
                            <li>• Total tugas completed</li>
                            <li>• Growth rate vs periode sebelumnya</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-medium text-dark mb-2">👥 Detail Per Karyawan:</h4>
                        <ul class="text-sm text-secondary space-y-1">
                            <li>• Nama, department, position</li>
                            <li>• Periode minggu laporan</li>
                            <li>• Jam kerja individual</li>
                            <li>• Tugas completed vs pending</li>
                            <li>• Individual productivity score</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics & Grafik -->
    <div class="bg-white p-6 rounded-lg shadow-md manual-section">
        <h2 class="text-2xl font-bold text-dark mb-4">📊 Analytics & Grafik</h2>

        <div class="space-y-6">
            <div class="bg-light p-4 rounded-lg">
                <h3 class="text-xl font-semibold text-dark mb-3">Mengakses Analytics:</h3>
                <ol class="text-secondary space-y-2 ml-4">
                    <li><strong>1.</strong> Akses menu <span class="bg-secondary text-white px-2 py-1 rounded text-sm">Analytics</span> di admin panel</li>
                    <li><strong>2.</strong> Dashboard akan menampilkan 4 section utama:
                        <ul class="ml-4 mt-2 space-y-1">
                            <li>• Company Statistics overview</li>
                            <li>• Interactive Charts & Graphs</li>
                            <li>• Top Performers ranking</li>
                            <li>• Insights & Recommendations</li>
                        </ul>
                    </li>
                    <li><strong>3.</strong> Interact dengan grafik untuk detail data</li>
                    <li><strong>4.</strong> Export analytics untuk external reporting</li>
                </ol>
            </div>

            <div class="bg-light p-4 rounded-lg">
                <h3 class="text-xl font-semibold text-dark mb-3">Grafik yang Tersedia:</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h4 class="font-medium text-dark mb-2">📈 Trend Bulanan (Line Chart):</h4>
                        <ul class="text-xs text-secondary space-y-1">
                            <li>• Menampilkan trend 6 bulan terakhir</li>
                            <li>• Perbandingan total tugas vs completed</li>
                            <li>• Identifikasi seasonal patterns</li>
                            <li>• Growth/decline analysis</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-medium text-dark mb-2">🥧 Distribusi Tugas (Doughnut):</h4>
                        <ul class="text-xs text-secondary space-y-1">
                            <li>• Breakdown tugas by status</li>
                            <li>• Percentage completion rate</li>
                            <li>• Visual representation workload</li>
                            <li>• Quick performance indicator</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-medium text-dark mb-2">📊 Productivity 4 Minggu (Bar):</h4>
                        <ul class="text-xs text-secondary space-y-1">
                            <li>• Weekly productivity comparison</li>
                            <li>• Trend analysis short-term</li>
                            <li>• Performance fluctuation tracking</li>
                            <li>• Weekly goals achievement</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-medium text-dark mb-2">🏢 Performa Departemen (Bar):</h4>
                        <ul class="text-xs text-secondary space-y-1">
                            <li>• Department-wise comparison</li>
                            <li>• Cross-functional analysis</li>
                            <li>• Resource allocation insights</li>
                            <li>• Team performance ranking</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="bg-light p-4 rounded-lg">
                <h3 class="text-xl font-semibold text-dark mb-3">Print Analytics ke PDF:</h3>
                <ol class="text-secondary space-y-2 ml-4">
                    <li><strong>1.</strong> Klik tombol <span class="bg-green-500 text-white px-2 py-1 rounded text-sm">Print Analytics</span></li>
                    <li><strong>2.</strong> Sistem akan generate PDF dengan:
                        <ul class="ml-4 mt-2 space-y-1">
                            <li>• Company statistics summary</li>
                            <li>• Top performers table</li>
                            <li>• Key insights dan recommendations</li>
                            <li>• Timestamp dan metadata</li>
                        </ul>
                    </li>
                    <li><strong>3.</strong> Save as PDF untuk archival atau sharing</li>
                    <li><strong>4.</strong> Perfect untuk board meetings dan presentations</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Tips & Best Practices -->
    <div class="bg-white p-6 rounded-lg shadow-md manual-section">
        <h2 class="text-2xl font-bold text-dark mb-4">💡 Tips & Best Practices</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-primary mb-3">👥 Manajemen Karyawan</h3>
                <ul class="text-sm text-secondary space-y-2">
                    <li>• Review data karyawan secara berkala (monthly)</li>
                    <li>• Update status active/inactive tepat waktu</li>
                    <li>• Monitor performa karyawan konsisten</li>
                    <li>• Berikan feedback berdasarkan data aktual</li>
                    <li>• Maintain employee privacy dan confidentiality</li>
                    <li>• Document semua perubahan untuk audit trail</li>
                </ul>
            </div>
            
            <div>
                <h3 class="text-lg font-semibold text-primary mb-3">📊 Pelaporan Efektif</h3>
                <ul class="text-sm text-secondary space-y-2">
                    <li>• Generate laporan mingguan setiap Jumat</li>
                    <li>• Review analytics bulanan untuk trend analysis</li>
                    <li>• Export data untuk backup dan archival</li>
                    <li>• Share insights dengan management team</li>
                    <li>• Compare performance across departments</li>
                    <li>• Use data untuk strategic decision making</li>
                </ul>
            </div>
            
            <div>
                <h3 class="text-lg font-semibold text-primary mb-3">📈 Monitoring & Analytics</h3>
                <ul class="text-sm text-secondary space-y-2">
                    <li>• Check dashboard daily untuk real-time insights</li>
                    <li>• Identify underperforming employees early</li>
                    <li>• Monitor productivity trends dan patterns</li>
                    <li>• Set KPIs berdasarkan historical data</li>
                    <li>• Track goal achievement dan milestones</li>
                    <li>• Use predictive analytics untuk planning</li>
                </ul>
            </div>
            
            <div>
                <h3 class="text-lg font-semibold text-primary mb-3">🔒 Security & Compliance</h3>
                <ul class="text-sm text-secondary space-y-2">
                    <li>• Protect sensitive employee data always</li>
                    <li>• Regular backup sistem dan database</li>
                    <li>• Monitor unauthorized access attempts</li>
                    <li>• Maintain audit logs untuk compliance</li>
                    <li>• Update security policies regularly</li>
                    <li>• Train users on security best practices</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Advanced Features -->
    <div class="bg-white p-6 rounded-lg shadow-md manual-section">
        <h2 class="text-2xl font-bold text-dark mb-4">🚀 Advanced Features</h2>
        
        <div class="space-y-6">
            <div class="bg-light p-4 rounded-lg">
                <h3 class="text-xl font-semibold text-dark mb-3">Bulk Operations:</h3>
                <ul class="text-secondary space-y-2">
                    <li>📥 <strong>Bulk Import:</strong> Import multiple employees dari Excel/CSV file</li>
                    <li>📤 <strong>Bulk Export:</strong> Export semua data employee untuk backup</li>
                    <li>🔄 <strong>Bulk Update:</strong> Update department/position multiple employees sekaligus</li>
                    <li>📧 <strong>Bulk Notification:</strong> Send announcement ke semua atau specific group</li>
                </ul>
            </div>

            <div class="bg-light p-4 rounded-lg">
                <h3 class="text-xl font-semibold text-dark mb-3">Reporting Automation:</h3>
                <ul class="text-secondary space-y-2">
                    <li>⏰ <strong>Scheduled Reports:</strong> Set laporan otomatis weekly/monthly</li>
                    <li>📧 <strong>Email Reports:</strong> Auto-send reports ke management via email</li>
                    <li>📊 <strong>Custom Analytics:</strong> Create custom metrics sesuai kebutuhan</li>
                    <li>🎯 <strong>KPI Dashboard:</strong> Track company KPIs real-time</li>
                </ul>
            </div>

            <div class="bg-light p-4 rounded-lg">
                <h3 class="text-xl font-semibold text-dark mb-3">Integration Capabilities:</h3>
                <ul class="text-secondary space-y-2">
                    <li>💼 <strong>HR Systems:</strong> Integrate dengan existing HR management</li>
                    <li>💰 <strong>Payroll Integration:</strong> Connect dengan sistem payroll</li>
                    <li>📅 <strong>Calendar Sync:</strong> Sync dengan Google Calendar/Outlook</li>
                    <li>🔔 <strong>Slack/Teams:</strong> Notifications via team communication tools</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Troubleshooting Admin -->
    <div class="bg-white p-6 rounded-lg shadow-md manual-section">
        <h2 class="text-2xl font-bold text-dark mb-4">🔧 Troubleshooting Admin</h2>
        
        <div class="space-y-4">
            <div class="border-l-4 border-red-400 pl-4">
                <h3 class="font-semibold text-red-800">❌ Employee tidak bisa login</h3>
                <p class="text-sm text-secondary mb-2">Solusi Admin:</p>
                <ul class="text-sm text-secondary ml-4 space-y-1">
                    <li>• Verify email dan employee_id di database</li>
                    <li>• Check status is_active = true</li>
                    <li>• Reset password temporary</li>
                    <li>• Clear any account locks/restrictions</li>
                    <li>• Verify role = 'estimator' untuk regular employee</li>
                </ul>
            </div>
            
            <div class="border-l-4 border-yellow-400 pl-4">
                <h3 class="font-semibold text-yellow-800">⚠️ Data tidak akurat</h3>
                <p class="text-sm text-secondary mb-2">Solusi Admin:</p>
                <ul class="text-sm text-secondary ml-4 space-y-1">
                    <li>• Audit employee work sessions completion</li>
                    <li>• Check for orphaned tasks tanpa work session</li>
                    <li>• Verify timezone settings consistency</li>
                    <li>• Run data cleanup scripts if available</li>
                    <li>• Manual adjustment untuk discrepancies</li>
                </ul>
            </div>
            
            <div class="border-l-4 border-blue-400 pl-4">
                <h3 class="font-semibold text-blue-800">ℹ️ Performance issues</h3>
                <p class="text-sm text-secondary mb-2">Optimasi Admin:</p>
                <ul class="text-sm text-secondary ml-4 space-y-1">
                    <li>• Monitor database query performance</li>
                    <li>• Optimize large reports dengan pagination</li>
                    <li>• Archive old data yang tidak diperlukan</li>
                    <li>• Check server resources usage</li>
                    <li>• Implement caching untuk frequent queries</li>
                </ul>
            </div>
            
            <div class="border-l-4 border-green-400 pl-4">
                <h3 class="font-semibold text-green-800">📞 Escalation & Support</h3>
                <p class="text-sm text-secondary mb-2">Untuk masalah complex:</p>
                <ul class="text-sm text-secondary ml-4 space-y-1">
                    <li>• Contact system developer/vendor</li>
                    <li>• Provide detailed error logs dan screenshots</li>
                    <li>• Backup data sebelum major troubleshooting</li>
                    <li>• Document solutions untuk future reference</li>
                    <li>• Update user training based pada common issues</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="bg-white p-6 rounded-lg shadow-md manual-section">
        <div class="text-center">
            <h2 class="text-xl font-bold text-dark mb-2">📋 Logbook System</h2>
            <p class="text-secondary">Manual Book Admin - Versi 1.0</p>
            <p class="text-sm text-gray-500 mt-2">Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
            <div class="mt-4 text-xs text-gray-400">
                <p>© 2024 Logbook System. Admin manual untuk penggunaan internal.</p>
                <p>Confidential - Tidak untuk distribusi eksternal tanpa authorization.</p>
            </div>
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
