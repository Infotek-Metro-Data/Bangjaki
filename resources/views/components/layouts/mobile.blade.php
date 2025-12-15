<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#059669">
    <title>{{ $title ?? 'BangJaki' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-secondary-50">
    <div class="flex flex-col min-h-screen pb-16">
        <header class="sticky top-0 z-30 bg-white border-b border-secondary-200">
            <div class="flex items-center justify-between h-14 px-4">
                <div class="flex items-center gap-3">
                    @if(isset($backUrl))
                        <a href="{{ $backUrl }}" class="p-1 text-secondary-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                    @endif
                    <h1 class="text-lg font-semibold text-secondary-900">{{ $title ?? 'BangJaki' }}</h1>
                </div>
                <div class="flex items-center gap-2">
                    @if(isset($headerAction))
                        {{ $headerAction }}
                    @endif
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto">
            {{ $slot }}
        </main>

        @if(($role ?? 'petugas') === 'petugas')
        <nav class="fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-secondary-200 safe-area-bottom">
            <div class="flex items-center justify-around h-16">
                <a href="{{ route('petugas.home') }}" class="bottom-nav-link {{ request()->routeIs('petugas.home') ? 'bottom-nav-link-active' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="text-xs mt-1">Home</span>
                </a>
                <a href="{{ route('petugas.tagihan.index') }}" class="bottom-nav-link {{ request()->routeIs('petugas.tagihan.*') ? 'bottom-nav-link-active' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span class="text-xs mt-1">Tagihan</span>
                </a>
                <a href="{{ route('petugas.input.create') }}" class="relative -top-3">
                    <div class="w-14 h-14 bg-primary-600 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                </a>
                <a href="{{ route('petugas.saldo') }}" class="bottom-nav-link {{ request()->routeIs('petugas.saldo') ? 'bottom-nav-link-active' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="text-xs mt-1">Saldo</span>
                </a>
                <a href="{{ route('petugas.profile') }}" class="bottom-nav-link {{ request()->routeIs('petugas.profile') ? 'bottom-nav-link-active' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="text-xs mt-1">Profil</span>
                </a>
            </div>
        </nav>
        @endif

        @if(($role ?? '') === 'pelanggan')
        <nav class="fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-secondary-200 safe-area-bottom">
            <div class="flex items-center justify-around h-16">
                <a href="{{ route('pelanggan.home') }}" class="bottom-nav-link {{ request()->routeIs('pelanggan.home') ? 'bottom-nav-link-active' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="text-xs mt-1">Home</span>
                </a>
                <a href="{{ route('pelanggan.riwayat') }}" class="bottom-nav-link {{ request()->routeIs('pelanggan.riwayat') ? 'bottom-nav-link-active' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span class="text-xs mt-1">Riwayat</span>
                </a>
                <a href="{{ route('pelanggan.jadwal') }}" class="bottom-nav-link {{ request()->routeIs('pelanggan.jadwal') ? 'bottom-nav-link-active' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-xs mt-1">Jadwal</span>
                </a>
                <a href="{{ route('pelanggan.lapor') }}" class="bottom-nav-link {{ request()->routeIs('pelanggan.lapor') ? 'bottom-nav-link-active' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                    <span class="text-xs mt-1">Lapor</span>
                </a>
                <a href="{{ route('pelanggan.profile') }}" class="bottom-nav-link {{ request()->routeIs('pelanggan.profile') ? 'bottom-nav-link-active' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="text-xs mt-1">Profil</span>
                </a>
            </div>
        </nav>
        @endif
    </div>
</body>
</html>
