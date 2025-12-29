<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#EA580C">
    <title>{{ $title ?? 'Dashboard' }} - BangJaki Petugas</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@400,0..1&display=swap"
        rel="stylesheet">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --color-primary: #EA580C;
            --color-primary-light: #FB923C;
            --color-primary-soft: #FFF7ED;
            --color-background: #F8FAFC;
            --color-surface: #FFFFFF;
            --color-text: #1E293B;
            --color-text-secondary: #64748B;
            --color-border: #E2E8F0;
            --safe-area-bottom: env(safe-area-inset-bottom, 0px);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #E2E8F0;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .material-symbols-outlined.filled {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .bottom-nav {
            padding-bottom: var(--safe-area-bottom);
        }

        .fab-button {
            transform: translateY(-50%);
            box-shadow: 0 4px 20px rgba(234, 88, 12, 0.4);
        }

        .fab-button:active {
            transform: translateY(-50%) scale(0.95);
        }

        .page-container {
            min-height: calc(100vh - 80px - var(--safe-area-bottom));
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        input,
        textarea,
        select {
            font-size: 16px !important;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
        }
    </style>
</head>

<body class="text-slate-800 antialiased bg-slate-200">
    <div class="mobile-container max-w-md mx-auto min-h-screen bg-white shadow-2xl relative">
        <div id="app" class="flex flex-col min-h-screen">
            <header class="sticky top-0 z-30 bg-white border-b border-slate-100 px-4 py-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center">
                            @if (auth()->user()->foto_profil)
                                <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="Profile"
                                    class="h-10 w-10 rounded-full object-cover">
                            @else
                                <span class="text-orange-600 font-bold text-sm">
                                    {{ substr(auth()->user()->nama ?? 'P', 0, 1) }}
                                </span>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Selamat datang,</p>
                            <h1 class="text-sm font-semibold text-slate-800 leading-tight">
                                {{ auth()->user()->nama ?? 'Petugas' }}
                            </h1>
                        </div>
                    </div>


                    <div x-data="{ open: false, notifications: [] }" @click.outside="open = false" class="relative">
                        @php
                            $unreadCount = auth()->user()->unreadNotifications->count();
                            $notifications = auth()->user()->notifications()->latest()->take(10)->get();
                        @endphp

                        <button @click="open = !open"
                            class="relative p-2 rounded-full hover:bg-slate-100 transition-colors">
                            <span class="material-symbols-outlined text-slate-600">notifications</span>
                            @if ($unreadCount > 0)
                                <span
                                    class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] px-1 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center animate-pulse">
                                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                </span>
                            @endif
                        </button>


                        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 top-12 w-80 bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden z-50">

                            <div class="px-4 py-3 border-b border-slate-100 flex justify-between items-center">
                                <h3 class="font-semibold text-slate-800">Notifikasi</h3>
                                @if ($unreadCount > 0)
                                    <form action="{{ route('petugas.notifications.read') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-xs text-orange-600 hover:underline">Tandai
                                            semua dibaca</button>
                                    </form>
                                @endif
                            </div>

                            <div class="max-h-80 overflow-y-auto">
                                @forelse($notifications as $notif)
                                    <div
                                        class="px-4 py-3 border-b border-slate-50 {{ $notif->read_at ? 'bg-white' : 'bg-orange-50' }} hover:bg-slate-50">
                                        <div class="flex items-start gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 {{ $notif->data['color'] === 'green' ? 'bg-green-100' : 'bg-red-100' }}">
                                                <span
                                                    class="material-symbols-outlined text-[18px] {{ $notif->data['color'] === 'green' ? 'text-green-600' : 'text-red-600' }}">
                                                    {{ $notif->data['icon'] }}
                                                </span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm text-slate-700 leading-snug">
                                                    {{ $notif->data['message'] }}</p>
                                                <p class="text-xs text-slate-400 mt-1">
                                                    {{ $notif->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="px-4 py-8 text-center">
                                        <span
                                            class="material-symbols-outlined text-4xl text-slate-300">notifications_off</span>
                                        <p class="text-slate-500 text-sm mt-2">Belum ada notifikasi</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 page-container">
                {{ $slot }}
            </main>

            @include('petugas.partials.bottom-nav')
        </div>
    </div>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        </script>
    @endif

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</body>

</html>
