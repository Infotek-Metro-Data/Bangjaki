<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} - BangJaki Admin</title>

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
            --accent: #F97316;
            --accent-light: #FB923C;
            --accent-badge: #FFEDD5;
            --border: #E5E7EB;
            --sidebar-width: 288px;
            --sidebar-collapsed-width: 72px;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        /* Custom Orange Scrollbar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(249, 115, 22, 0.4);
            border-radius: 10px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(234, 88, 12, 0.8);
        }

        .sidebar-scroll {
            scrollbar-width: thin;
            scrollbar-color: rgba(249, 115, 22, 0.4) transparent;
        }

        .sidebar {
            width: var(--sidebar-width);
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: visible;
        }

        .sidebar-collapsed .sidebar {
            width: var(--sidebar-collapsed-width);
            overflow: visible;
        }

        .sidebar-inner {
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar-collapsed .sidebar-inner {
            overflow: visible;
        }

        .sidebar-collapsed .sidebar-text,
        .sidebar-collapsed .sidebar-brand-text,
        .sidebar-collapsed .user-info,
        .sidebar-collapsed .logout-btn,
        .sidebar-collapsed .menu-group-header-text,
        .sidebar-collapsed .accordion-content {
            opacity: 0;
            width: 0;
            height: 0;
            overflow: hidden;
            pointer-events: none;
            position: absolute;
        }

        .sidebar-collapsed .nav-link {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }

        .sidebar-collapsed .menu-parent-icon {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }

        .sidebar-collapsed .chevron-icon {
            display: none;
        }

        .sidebar-collapsed .user-profile {
            justify-content: center;
            padding: 0.75rem;
        }

        .sidebar-collapsed .brand-section {
            justify-content: center;
            padding: 1rem;
        }

        .sidebar-collapsed .brand-logo {
            height: 2.5rem;
        }

        /* Flyout Menu - Fixed Position to bypass overflow */
        .flyout-menu {
            position: fixed;
            left: var(--sidebar-collapsed-width);
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateX(-8px);
            transition: all 0.2s ease;
            z-index: 9999;
            pointer-events: none;
        }

        .flyout-trigger:hover .flyout-menu {
            opacity: 1;
            visibility: visible;
            transform: translateX(0);
            pointer-events: auto;
        }

        .flyout-menu::before {
            content: '';
            position: absolute;
            left: -12px;
            top: 0;
            width: 12px;
            height: 100%;
        }

        .slide-over-backdrop {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .slide-over-backdrop.active {
            opacity: 1;
        }

        .slide-over-panel {
            transform: translateX(100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .slide-over-panel.active {
            transform: translateX(0);
        }

        @media (max-width: 767px) {
            .sidebar {
                position: fixed !important;
                left: 0;
                top: 0;
                height: 100%;
                width: 280px !important;
                z-index: 50;
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                display: flex !important;
            }

            .mobile-sidebar-open .sidebar {
                transform: translateX(0);
            }

            .mobile-sidebar-backdrop {
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.3s ease;
            }

            .mobile-sidebar-open .mobile-sidebar-backdrop {
                opacity: 1;
                pointer-events: auto;
            }

            .flyout-menu {
                display: none !important;
            }
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800 antialiased overflow-hidden">
    <div id="app" class="flex h-screen w-full" x-data="{
        sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true',
        masterOpen: {{ request()->routeIs('admin.pelanggan.*') || request()->routeIs('admin.petugas.*') ? 'true' : 'false' }},
        transaksiOpen: {{ request()->routeIs('admin.tagihan.*') || request()->routeIs('admin.verifikasi.*') || request()->routeIs('admin.settlement.*') ? 'true' : 'false' }},
        masterFlyoutTop: 0,
        transaksiFlyoutTop: 0,
        toggleSidebar() {
            if (window.innerWidth < 768) {
                this.$el.classList.toggle('mobile-sidebar-open');
            } else {
                this.sidebarCollapsed = !this.sidebarCollapsed;
                this.$el.classList.toggle('sidebar-collapsed', this.sidebarCollapsed);
                localStorage.setItem('sidebarCollapsed', this.sidebarCollapsed);
            }
        },
        updateFlyoutPosition(event, type) {
            const rect = event.currentTarget.getBoundingClientRect();
            if (type === 'master') {
                this.masterFlyoutTop = rect.top;
            } else if (type === 'transaksi') {
                this.transaksiFlyoutTop = rect.top;
            }
        }
    }"
        :class="{ 'sidebar-collapsed': sidebarCollapsed }">
        <div class="mobile-sidebar-backdrop fixed inset-0 bg-black/50 z-40 md:hidden"
            @click="$el.parentElement.classList.remove('mobile-sidebar-open')">
        </div>

        <aside class="sidebar flex flex-col h-full bg-white border-r border-gray-100 shrink-0 shadow-sm z-30">
            <div class="sidebar-inner flex flex-col h-full justify-between sidebar-scroll">
                <div class="flex flex-col">
                    <div class="brand-section flex flex-col items-center px-4 py-5 border-b border-gray-50">
                        <img src="{{ asset('images/logo.png') }}" alt="BangJaki Logo"
                            class="brand-logo h-12 w-auto object-contain transition-all duration-300">
                        <span
                            class="sidebar-brand-text text-[10px] font-semibold text-gray-400 uppercase tracking-widest mt-2 transition-all duration-300">Admin
                            Panel</span>
                    </div>

                    <nav class="flex-1 px-3 py-4">
                        <!-- Dashboard - Single Link -->
                        <a href="{{ route('admin.dashboard') }}"
                            class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl mb-2 {{ request()->routeIs('admin.dashboard') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/30' : 'text-gray-600 hover:bg-gray-50 hover:text-orange-600' }} transition-all duration-200 group">
                            <span
                                class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.dashboard') ? '' : 'text-gray-400 group-hover:text-orange-500' }}">dashboard</span>
                            <span
                                class="sidebar-text text-sm font-medium whitespace-nowrap transition-all duration-300">Dashboard</span>
                        </a>

                        <div class="relative mb-1">
                            <div x-show="!sidebarCollapsed" x-cloak>
                                <button @click="masterOpen = !masterOpen"
                                    class="w-full flex items-center justify-between px-3 py-2 rounded-lg transition-all duration-200 mt-3"
                                    :class="masterOpen ? 'text-orange-600' :
                                        'text-gray-500 hover:text-slate-900 hover:bg-gray-50'">
                                    <span
                                        class="menu-group-header-text text-xs font-semibold uppercase tracking-wider">Master
                                        Data</span>
                                    <span
                                        class="material-symbols-outlined chevron-icon text-[18px] transition-transform duration-200"
                                        :class="masterOpen ? 'rotate-180' : ''">expand_more</span>
                                </button>
                                <div x-show="masterOpen" x-collapse
                                    class="accordion-content flex flex-col gap-1 pl-1 border-l-2 ml-3 mt-1 mb-2"
                                    :class="masterOpen ? 'border-orange-500' : 'border-gray-200'">
                                    <a href="{{ route('admin.pelanggan.index') }}"
                                        class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.pelanggan.*') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/30' : 'text-gray-600 hover:bg-gray-50 hover:text-orange-600' }} transition-all duration-200 group">
                                        <span
                                            class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.pelanggan.*') ? '' : 'text-gray-400 group-hover:text-orange-500' }}">group</span>
                                        <span
                                            class="sidebar-text text-sm font-medium whitespace-nowrap">Pelanggan</span>
                                    </a>
                                    <a href="{{ route('admin.petugas.index') }}"
                                        class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.petugas.*') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/30' : 'text-gray-600 hover:bg-gray-50 hover:text-orange-600' }} transition-all duration-200 group">
                                        <span
                                            class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.petugas.*') ? '' : 'text-gray-400 group-hover:text-orange-500' }}">badge</span>
                                        <span class="sidebar-text text-sm font-medium whitespace-nowrap">Petugas</span>
                                    </a>
                                </div>
                            </div>

                            <div x-show="sidebarCollapsed" x-cloak class="flyout-trigger"
                                @mouseenter="updateFlyoutPosition($event, 'master')">
                                <button
                                    class="menu-parent-icon w-full flex items-center justify-center px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.pelanggan.*') || request()->routeIs('admin.petugas.*') ? 'bg-orange-100 text-orange-600' : 'text-gray-500 hover:bg-gray-50 hover:text-orange-600' }}">
                                    <span class="material-symbols-outlined text-[20px]">folder_shared</span>
                                </button>
                                <div class="flyout-menu bg-white rounded-xl shadow-xl border border-gray-100 py-2 px-1"
                                    :style="'top: ' + masterFlyoutTop + 'px'">
                                    <p
                                        class="px-3 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-50 mb-1">
                                        Master Data</p>
                                    <a href="{{ route('admin.pelanggan.index') }}"
                                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.pelanggan.*') ? 'bg-orange-500 text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-orange-500' }} transition-all">
                                        <span class="material-symbols-outlined text-[18px]">group</span>
                                        <span class="text-sm font-medium">Pelanggan</span>
                                    </a>
                                    <a href="{{ route('admin.petugas.index') }}"
                                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.petugas.*') ? 'bg-orange-500 text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-orange-500' }} transition-all">
                                        <span class="material-symbols-outlined text-[18px]">badge</span>
                                        <span class="text-sm font-medium">Petugas</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="relative mb-1">
                            <!-- Expanded: Accordion Header -->
                            <div x-show="!sidebarCollapsed" x-cloak>
                                <button @click="transaksiOpen = !transaksiOpen"
                                    class="w-full flex items-center justify-between px-3 py-2 rounded-lg transition-all duration-200 mt-2"
                                    :class="transaksiOpen ? 'text-orange-600' :
                                        'text-gray-500 hover:text-slate-900 hover:bg-gray-50'">
                                    <span
                                        class="menu-group-header-text text-xs font-semibold uppercase tracking-wider">Transaksi</span>
                                    <span
                                        class="material-symbols-outlined chevron-icon text-[18px] transition-transform duration-200"
                                        :class="transaksiOpen ? 'rotate-180' : ''">expand_more</span>
                                </button>
                                <div x-show="transaksiOpen" x-collapse
                                    class="accordion-content flex flex-col gap-1 pl-1 border-l-2 ml-3 mt-1 mb-2"
                                    :class="transaksiOpen ? 'border-orange-500' : 'border-gray-200'">
                                    <a href="{{ route('admin.tagihan.index') }}"
                                        class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.tagihan.*') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/30' : 'text-gray-600 hover:bg-gray-50 hover:text-orange-600' }} transition-all duration-200 group">
                                        <span
                                            class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.tagihan.*') ? '' : 'text-gray-400 group-hover:text-orange-500' }}">receipt_long</span>
                                        <span class="sidebar-text text-sm font-medium whitespace-nowrap">Tagihan</span>
                                    </a>
                                    <a href="{{ route('admin.verifikasi.index') }}"
                                        class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.verifikasi.*') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/30' : 'text-gray-600 hover:bg-gray-50 hover:text-orange-600' }} transition-all duration-200 group">
                                        <span
                                            class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.verifikasi.*') ? '' : 'text-gray-400 group-hover:text-orange-500' }}">verified</span>
                                        <span
                                            class="sidebar-text text-sm font-medium whitespace-nowrap">Verifikasi</span>
                                    </a>
                                    <a href="{{ route('admin.settlement.index') }}"
                                        class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.settlement.*') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/30' : 'text-gray-600 hover:bg-gray-50 hover:text-orange-600' }} transition-all duration-200 group">
                                        <span
                                            class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.settlement.*') ? '' : 'text-gray-400 group-hover:text-orange-500' }}">account_balance_wallet</span>
                                        <span
                                            class="sidebar-text text-sm font-medium whitespace-nowrap">Settlement</span>
                                    </a>
                                </div>
                            </div>

                            <div x-show="sidebarCollapsed" x-cloak class="flyout-trigger"
                                @mouseenter="updateFlyoutPosition($event, 'transaksi')">
                                <button
                                    class="menu-parent-icon w-full flex items-center justify-center px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.tagihan.*') || request()->routeIs('admin.verifikasi.*') || request()->routeIs('admin.settlement.*') ? 'bg-orange-100 text-orange-600' : 'text-gray-500 hover:bg-gray-50 hover:text-orange-600' }}">
                                    <span class="material-symbols-outlined text-[20px]">swap_horiz</span>
                                </button>
                                <div class="flyout-menu bg-white rounded-xl shadow-xl border border-gray-100 py-2 px-1"
                                    :style="'top: ' + transaksiFlyoutTop + 'px'">
                                    <p
                                        class="px-3 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-50 mb-1">
                                        Transaksi</p>
                                    <a href="{{ route('admin.tagihan.index') }}"
                                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.tagihan.*') ? 'bg-orange-500 text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-orange-500' }} transition-all">
                                        <span class="material-symbols-outlined text-[18px]">receipt_long</span>
                                        <span class="text-sm font-medium">Tagihan</span>
                                    </a>
                                    <a href="{{ route('admin.verifikasi.index') }}"
                                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.verifikasi.*') ? 'bg-orange-500 text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-orange-500' }} transition-all">
                                        <span class="material-symbols-outlined text-[18px]">verified</span>
                                        <span class="text-sm font-medium">Verifikasi</span>
                                    </a>
                                    <a href="{{ route('admin.settlement.index') }}"
                                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.settlement.*') ? 'bg-orange-500 text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-orange-500' }} transition-all">
                                        <span
                                            class="material-symbols-outlined text-[18px]">account_balance_wallet</span>
                                        <span class="text-sm font-medium">Settlement</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="my-3 border-t border-gray-100"></div>

                        <a href="{{ route('admin.settings.index') }}"
                            class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl mb-1 {{ request()->routeIs('admin.settings.*') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/30' : 'text-gray-600 hover:bg-gray-50 hover:text-orange-600' }} transition-all duration-200 group">
                            <span
                                class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.settings.*') ? '' : 'text-gray-400 group-hover:text-orange-500' }}">settings</span>
                            <span
                                class="sidebar-text text-sm font-medium whitespace-nowrap transition-all duration-300">Pengaturan</span>
                        </a>

                        <a href="{{ route('admin.profile.index') }}"
                            class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.profile.*') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/30' : 'text-gray-600 hover:bg-gray-50 hover:text-orange-600' }} transition-all duration-200 group">
                            <span
                                class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.profile.*') ? '' : 'text-gray-400 group-hover:text-orange-500' }}">person</span>
                            <span
                                class="sidebar-text text-sm font-medium whitespace-nowrap transition-all duration-300">Profil
                                Saya</span>
                        </a>
                    </nav>
                </div>

                <div class="p-3 border-t border-gray-100">
                    <a href="{{ route('admin.profile.index') }}"
                        class="user-profile flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors block text-left border border-transparent hover:border-gray-100">
                        <div class="h-9 w-9 rounded-full bg-orange-100 flex items-center justify-center shrink-0">
                            <span
                                class="text-orange-600 font-bold text-sm">{{ substr(auth()->user()->nama ?? 'A', 0, 1) }}</span>
                        </div>
                        <div class="user-info flex-1 min-w-0 transition-all duration-300">
                            <p class="text-slate-900 text-sm font-medium truncate">
                                {{ auth()->user()->nama ?? 'Admin' }}
                            </p>
                            <p class="text-gray-500 text-xs">Administrator</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}"
                            class="logout-btn shrink-0 transition-all duration-300">
                            @csrf
                            <button type="submit"
                                class="text-gray-400 hover:text-red-500 transition-colors p-1 rounded-lg hover:bg-red-50">
                                <span class="material-symbols-outlined text-[20px]">logout</span>
                            </button>
                        </form>
                    </a>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col h-full overflow-hidden bg-gray-50/50">
            <header
                class="flex items-center justify-between bg-white px-4 md:px-8 py-4 shrink-0 border-b border-gray-100/50">
                <div class="flex items-center gap-3 md:gap-4">
                    <button @click="toggleSidebar()"
                        class="text-gray-500 hover:text-slate-900 transition-colors p-1 rounded-lg hover:bg-gray-100">
                        <span class="material-symbols-outlined"
                            x-text="sidebarCollapsed ? 'menu' : 'menu_open'"></span>
                    </button>
                    <h2 class="text-slate-900 text-lg md:text-xl font-bold truncate">{{ $title ?? 'Dashboard' }}</h2>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 md:p-8">
                {{ $slot }}
            </main>
        </div>

        <div id="slideOverBackdrop" class="slide-over-backdrop fixed inset-0 bg-black/40 z-40 hidden"
            onclick="closeSlideOver()"></div>

        @if (isset($slideOver))
            <aside id="slideOverPanel"
                class="slide-over-panel fixed right-0 top-0 h-full w-full sm:w-[480px] bg-white flex-col shrink-0 shadow-2xl z-50 overflow-y-auto hidden">
                {{ $slideOver }}
            </aside>
        @endif
    </div>

    <script>
        function openSlideOver() {
            const backdrop = document.getElementById('slideOverBackdrop');
            const panel = document.getElementById('slideOverPanel');

            backdrop.classList.remove('hidden');
            panel.classList.remove('hidden');
            panel.classList.add('flex');

            requestAnimationFrame(() => {
                backdrop.classList.add('active');
                panel.classList.add('active');
            });
        }

        function closeSlideOver() {
            const backdrop = document.getElementById('slideOverBackdrop');
            const panel = document.getElementById('slideOverPanel');

            backdrop.classList.remove('active');
            panel.classList.remove('active');

            setTimeout(() => {
                backdrop.classList.add('hidden');
                panel.classList.add('hidden');
                panel.classList.remove('flex');
            }, 300);
        }
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</body>

</html>
