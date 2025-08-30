<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Logbook System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#F27127',
                        'secondary': '#5C6B87',
                        'light': '#EBE8E3',
                        'dark': '#000000',
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body class="bg-light min-h-screen">
    @auth
        <nav class="bg-secondary shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <h1 class="text-white text-xl font-bold">📋 Logbook</h1>
                        </div>
                        <div class="hidden md:block ml-10">
                            <div class="flex items-baseline space-x-4">
                                @if(auth()->user()->isAdmin() && request()->is('admin*'))
                                    {{-- Navigation untuk Admin di halaman Admin --}}
                                    <a href="{{ route('admin.dashboard') }}" class="text-white hover:text-primary px-3 py-2 rounded-md text-sm font-medium">
                                        <i class="fas fa-home mr-2"></i>Dashboard
                                    </a>
                                    <a href="{{ route('admin.employees.index') }}" class="text-white hover:text-primary px-3 py-2 rounded-md text-sm font-medium">
                                        <i class="fas fa-users mr-2"></i>Karyawan
                                    </a>
                                    <a href="{{ route('admin.reports.index') }}" class="text-white hover:text-primary px-3 py-2 rounded-md text-sm font-medium">
                                        <i class="fas fa-chart-bar mr-2"></i>Laporan
                                    </a>
                                    <a href="{{ route('admin.analytics') }}" class="text-white hover:text-primary px-3 py-2 rounded-md text-sm font-medium">
                                        <i class="fas fa-chart-line mr-2"></i>Analytics
                                    </a>
                                    <a href="{{ route('dashboard') }}" class="text-primary bg-white px-3 py-2 rounded-md text-sm font-medium">
                                        <i class="fas fa-user mr-2"></i>Mode Karyawan
                                    </a>
                                @else
                                    {{-- Navigation untuk Karyawan atau Admin di halaman Karyawan --}}
                                    <a href="{{ route('dashboard') }}" class="text-white hover:text-primary px-3 py-2 rounded-md text-sm font-medium">
                                        <i class="fas fa-home mr-2"></i>Dashboard
                                    </a>
                                    <a href="{{ route('work-sessions.index') }}" class="text-white hover:text-primary px-3 py-2 rounded-md text-sm font-medium">
                                        <i class="fas fa-clock mr-2"></i>Sesi Kerja
                                    </a>
                                    <a href="{{ route('tasks.index') }}" class="text-white hover:text-primary px-3 py-2 rounded-md text-sm font-medium">
                                        <i class="fas fa-tasks mr-2"></i>Tugas
                                    </a>
                                    <a href="{{ route('reports.index') }}" class="text-white hover:text-primary px-3 py-2 rounded-md text-sm font-medium">
                                        <i class="fas fa-chart-bar mr-2"></i>Laporan
                                    </a>
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="text-primary bg-white px-3 py-2 rounded-md text-sm font-medium">
                                            <i class="fas fa-cog mr-2"></i>Admin
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="ml-3 relative">
                            <div class="flex items-center space-x-4">
                                <span class="text-white text-sm">{{ auth()->user()->name }}</span>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-white hover:text-primary px-3 py-2 rounded-md text-sm font-medium">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    @endauth

    <main class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            @if(session('warning'))
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                    <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('warning') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <i class="fas fa-times-circle mr-2"></i>{{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    @stack('scripts')
</body>
</html>
