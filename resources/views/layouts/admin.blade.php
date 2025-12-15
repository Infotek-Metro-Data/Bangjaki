<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin' }} - BangJaki</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-secondary-50">
    <div class="flex h-screen overflow-hidden">
        <aside class="hidden lg:flex lg:flex-shrink-0">
            <div class="flex flex-col w-64 bg-white border-r border-secondary-200">
                <div class="flex items-center h-16 px-6 border-b border-secondary-200">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <span class="text-lg font-bold text-secondary-900">BangJaki</span>
                    </a>
                </div>

                <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <div class="pt-4">
                        <p class="px-3 text-xs font-semibold text-secondary-400 uppercase tracking-wider">Pelanggan</p>
                    </div>
                    <a href="{{ route('admin.pelanggan.index') }}" class="sidebar-link {{ request()->routeIs('admin.pelanggan.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span>Daftar Pelanggan</span>
                    </a>

                    <div class="pt-4">
                        <p class="px-3 text-xs font-semibold text-secondary-400 uppercase tracking-wider">Tagihan</p>
                    </div>
                    <a href="{{ route('admin.tagihan.index') }}" class="sidebar-link {{ request()->routeIs('admin.tagihan.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        <span>Semua Tagihan</span>
                    </a>

                    <div class="pt-4">
                        <p class="px-3 text-xs font-semibold text-secondary-400 uppercase tracking-wider">Verifikasi</p>
                    </div>
                    <a href="{{ route('admin.verifikasi.index') }}" class="sidebar-link {{ request()->routeIs('admin.verifikasi.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Verifikasi Bayar</span>
                        @if(($pendingCount ?? 0) > 0)
                            <span class="ml-auto bg-danger text-white text-xs font-medium px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
                        @endif
                    </a>

                    <div class="pt-4">
                        <p class="px-3 text-xs font-semibold text-secondary-400 uppercase tracking-wider">Keuangan</p>
                    </div>
                    <a href="{{ route('admin.settlement.index') }}" class="sidebar-link {{ request()->routeIs('admin.settlement.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span>Settlement</span>
                    </a>

                    <div class="pt-4">
                        <p class="px-3 text-xs font-semibold text-secondary-400 uppercase tracking-wider">Tim</p>
                    </div>
                    <a href="{{ route('admin.petugas.index') }}" class="sidebar-link {{ request()->routeIs('admin.petugas.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Petugas</span>
                    </a>

                    <div class="pt-4">
                        <p class="px-3 text-xs font-semibold text-secondary-400 uppercase tracking-wider">Pengaturan</p>
                    </div>
                    <a href="{{ route('admin.settings.tarif') }}" class="sidebar-link {{ request()->routeIs('admin.settings.tarif') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Tarif</span>
                    </a>
                    <a href="{{ route('admin.settings.wilayah') }}" class="sidebar-link {{ request()->routeIs('admin.settings.wilayah') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Wilayah</span>
                    </a>
                </nav>

                <div class="p-4 border-t border-secondary-200">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-primary-100 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium text-primary-700">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-secondary-900 truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-secondary-500">Administrator</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="p-2 text-secondary-400 hover:text-secondary-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex flex-col flex-1 overflow-hidden">
            <header class="lg:hidden flex items-center justify-between h-16 px-4 bg-white border-b border-secondary-200">
                <button type="button" onclick="toggleMobileSidebar()" class="p-2 text-secondary-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <span class="text-lg font-bold text-secondary-900">BangJaki</span>
                <div class="w-10"></div>
            </header>

            <main class="flex-1 overflow-y-auto bg-secondary-50">
                <div class="p-4 md:p-6 lg:p-8">
                    @if(isset($header))
                        <div class="mb-6">
                            {{ $header }}
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <div id="mobileSidebarOverlay" class="hidden fixed inset-0 bg-black/50 z-40 lg:hidden" onclick="toggleMobileSidebar()"></div>

    <div id="mobileSidebar" class="hidden fixed inset-y-0 left-0 w-64 bg-white z-50 transform -translate-x-full transition-transform duration-300 lg:hidden">
    </div>

    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('mobileSidebar');
            const overlay = document.getElementById('mobileSidebarOverlay');
            sidebar.classList.toggle('hidden');
            overlay.classList.toggle('hidden');
            sidebar.classList.toggle('-translate-x-full');
        }
    </script>
</body>
</html>
