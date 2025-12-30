 <!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} - BangJaki Pelanggan</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@400,0&display=swap"
        rel="stylesheet">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --bg-primary: #FFFFFF;
            --bg-secondary: #F9FAFB;
            --text-primary: #0F172A;
            --text-secondary: #6B7280;
            --accent: #0EA5E9;
            --accent-light: #38BDF8;
            --accent-badge: #E0F2FE;
            --border: #E5E7EB;
            --sidebar-width: 280px;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(14, 165, 233, 0.4);
            border-radius: 10px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(14, 165, 233, 0.8);
        }

        .sidebar {
            width: var(--sidebar-width);
        }

        @media (max-width: 1023px) {
            .sidebar {
                position: fixed;
                left: 0;
                top: 0;
                height: 100%;
                z-index: 50;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .mobile-sidebar-open .sidebar {
                transform: translateX(0);
            }
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800 antialiased overflow-hidden">
    <div id="app" class="flex h-screen w-full" x-data="{ mobileSidebarOpen: false }">
        <div class="mobile-sidebar-backdrop fixed inset-0 bg-black/50 z-40 lg:hidden" @click="mobileSidebarOpen = false"
            x-show="mobileSidebarOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
        </div>

        <aside class="sidebar flex flex-col h-full bg-white border-r border-gray-100 shrink-0 shadow-sm z-30"
            :class="{ 'transform-none': mobileSidebarOpen }">
            <div class="sidebar-inner flex flex-col h-full justify-between sidebar-scroll">
                <div class="flex flex-col">
                    <div class="flex flex-col items-center px-4 py-5 border-b border-gray-50">
                        <img src="{{ asset('images/logo.png') }}" alt="BangJaki Logo"
                            class="h-12 w-auto object-contain">
                        <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest mt-2">
                            Portal Pelanggan
                        </span>
                    </div>

                    <nav class="flex-1 px-3 py-4 space-y-1">
                        <a href="{{ route('pelanggan.dashboard') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('pelanggan.dashboard') ? 'bg-sky-500 text-white shadow-lg shadow-sky-500/30' : 'text-gray-600 hover:bg-gray-50 hover:text-sky-600' }} transition-all duration-200 group">
                            <span
                                class="material-symbols-outlined text-[20px] {{ request()->routeIs('pelanggan.dashboard') ? '' : 'text-gray-400 group-hover:text-sky-500' }}">dashboard</span>
                            <span class="text-sm font-medium">Dashboard</span>
                        </a>

                        <a href="{{ route('pelanggan.tagihan') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('pelanggan.tagihan') ? 'bg-sky-500 text-white shadow-lg shadow-sky-500/30' : 'text-gray-600 hover:bg-gray-50 hover:text-sky-600' }} transition-all duration-200 group">
                            <span
                                class="material-symbols-outlined text-[20px] {{ request()->routeIs('pelanggan.tagihan') ? '' : 'text-gray-400 group-hover:text-sky-500' }}">receipt_long</span>
                            <span class="text-sm font-medium">Tagihan</span>
                        </a>

                        <a href="{{ route('pelanggan.riwayat') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('pelanggan.riwayat') ? 'bg-sky-500 text-white shadow-lg shadow-sky-500/30' : 'text-gray-600 hover:bg-gray-50 hover:text-sky-600' }} transition-all duration-200 group">
                            <span
                                class="material-symbols-outlined text-[20px] {{ request()->routeIs('pelanggan.riwayat') ? '' : 'text-gray-400 group-hover:text-sky-500' }}">history</span>
                            <span class="text-sm font-medium">Riwayat Pembayaran</span>
                        </a>

                        <div class="my-3 border-t border-gray-100"></div>

                        <a href="{{ route('pelanggan.profile') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('pelanggan.profile') ? 'bg-sky-500 text-white shadow-lg shadow-sky-500/30' : 'text-gray-600 hover:bg-gray-50 hover:text-sky-600' }} transition-all duration-200 group">
                            <span
                                class="material-symbols-outlined text-[20px] {{ request()->routeIs('pelanggan.profile') ? '' : 'text-gray-400 group-hover:text-sky-500' }}">person</span>
                            <span class="text-sm font-medium">Profil Saya</span>
                        </a>
                    </nav>
                </div>

                <div class="p-3 border-t border-gray-100">
                    @php $pelanggan = Auth::guard('pelanggan')->user(); @endphp
                    <div class="flex items-center gap-3 px-3 py-3 rounded-xl bg-gray-50">
                        <div class="h-9 w-9 rounded-full bg-sky-100 flex items-center justify-center shrink-0">
                            <span
                                class="text-sky-600 font-bold text-sm">{{ substr($pelanggan->nama ?? 'P', 0, 1) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-slate-900 text-sm font-medium truncate">
                                {{ $pelanggan->nama ?? 'Pelanggan' }}</p>
                            <p class="text-gray-500 text-xs truncate">{{ $pelanggan->email ?? '-' }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="text-gray-400 hover:text-red-500 transition-colors p-1 rounded-lg hover:bg-red-50">
                                <span class="material-symbols-outlined text-[20px]">logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col h-full overflow-hidden bg-gray-50/50">
            <header
                class="flex items-center justify-between bg-white px-4 lg:px-8 py-4 shrink-0 border-b border-gray-100/50">
                <div class="flex items-center gap-3">
                    <button @click="mobileSidebarOpen = !mobileSidebarOpen"
                        class="lg:hidden text-gray-500 hover:text-slate-900 transition-colors p-1 rounded-lg hover:bg-gray-100">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <h2 class="text-slate-900 text-lg lg:text-xl font-bold truncate">{{ $title ?? 'Dashboard' }}</h2>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 lg:p-8">
                {{ $slot }}
            </main>
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
