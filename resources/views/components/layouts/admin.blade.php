<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} - BangJaki Admin</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@400,0&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --bg-primary: #FFFFFF;
            --bg-secondary: #F0FDF4;
            --text-primary: #064E3B;
            --text-secondary: #1F2937;
            --accent: #059669;
            --accent-light: #10B981;
            --accent-badge: #D1FAE5;
            --border: #D1FAE5;
        }
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Sidebar transitions */
        .sidebar {
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .sidebar-collapsed .sidebar {
            width: 72px;
        }
        
        .sidebar-collapsed .sidebar-text,
        .sidebar-collapsed .sidebar-brand-text,
        .sidebar-collapsed .user-info,
        .sidebar-collapsed .logout-btn {
            opacity: 0;
            width: 0;
            overflow: hidden;
            transition: opacity 0.2s ease, width 0.3s ease;
        }
        
        .sidebar-text,
        .sidebar-brand-text,
        .user-info {
            transition: opacity 0.2s ease, width 0.3s ease;
        }
        
        .sidebar-collapsed .nav-link {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }
        
        .sidebar-collapsed .user-profile {
            justify-content: center;
            padding: 0.75rem;
        }
        
        /* Slide-over animations */
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
        
        /* Mobile sidebar */
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
        }
    </style>
</head>
<body class="bg-white text-gray-800 antialiased overflow-hidden">
    <div id="app" class="flex h-screen w-full">
        <div class="mobile-sidebar-backdrop fixed inset-0 bg-black/50 z-40 md:hidden" onclick="closeMobileSidebar()"></div>
        
        <aside class="sidebar flex flex-col w-72 h-full bg-emerald-50 border-r border-emerald-100 overflow-y-auto shrink-0">
            <div class="flex flex-col h-full p-4 justify-between">
                <div class="flex flex-col gap-6">
                    <div class="flex gap-3 items-center px-2">
                        <div class="h-10 w-10 rounded-xl bg-emerald-600 flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <div class="sidebar-brand-text flex flex-col">
                            <h1 class="text-emerald-900 text-lg font-bold leading-tight">BangJaki</h1>
                            <p class="text-emerald-600 text-xs font-medium">Admin Panel</p>
                        </div>
                    </div>
                    
                    <nav class="flex flex-col gap-1">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link flex items-center gap-3 px-3 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-600 text-white shadow-sm' : 'text-emerald-800 hover:bg-emerald-100' }} transition-all duration-200">
                            <span class="material-symbols-outlined text-[22px]">dashboard</span>
                            <span class="sidebar-text text-sm font-medium">Dashboard</span>
                        </a>
                        <a href="{{ route('admin.pelanggan.index') }}" class="nav-link flex items-center gap-3 px-3 py-3 rounded-lg {{ request()->routeIs('admin.pelanggan.*') ? 'bg-emerald-600 text-white shadow-sm' : 'text-emerald-800 hover:bg-emerald-100' }} transition-all duration-200">
                            <span class="material-symbols-outlined text-[22px]">group</span>
                            <span class="sidebar-text text-sm font-medium">Pelanggan</span>
                        </a>
                        <a href="{{ route('admin.verifikasi.index') }}" class="nav-link flex items-center gap-3 px-3 py-3 rounded-lg {{ request()->routeIs('admin.verifikasi.*') ? 'bg-emerald-600 text-white shadow-sm' : 'text-emerald-800 hover:bg-emerald-100' }} transition-all duration-200">
                            <span class="material-symbols-outlined text-[22px]">verified</span>
                            <span class="sidebar-text text-sm font-medium">Verifikasi</span>
                        </a>
                        <a href="{{ route('admin.settlement.index') }}" class="nav-link flex items-center gap-3 px-3 py-3 rounded-lg {{ request()->routeIs('admin.settlement.*') ? 'bg-emerald-600 text-white shadow-sm' : 'text-emerald-800 hover:bg-emerald-100' }} transition-all duration-200">
                            <span class="material-symbols-outlined text-[22px]">account_balance_wallet</span>
                            <span class="sidebar-text text-sm font-medium">Settlement</span>
                        </a>
                        <a href="{{ route('admin.petugas.index') }}" class="nav-link flex items-center gap-3 px-3 py-3 rounded-lg {{ request()->routeIs('admin.petugas.*') ? 'bg-emerald-600 text-white shadow-sm' : 'text-emerald-800 hover:bg-emerald-100' }} transition-all duration-200">
                            <span class="material-symbols-outlined text-[22px]">badge</span>
                            <span class="sidebar-text text-sm font-medium">Petugas</span>
                        </a>
                        
                        <div class="my-2 border-t border-emerald-200"></div>
                        
                        <a href="{{ route('admin.profile.index') }}" class="nav-link flex items-center gap-3 px-3 py-3 rounded-lg {{ request()->routeIs('admin.profile.*') ? 'bg-emerald-600 text-white shadow-sm' : 'text-emerald-800 hover:bg-emerald-100' }} transition-all duration-200">
                            <span class="material-symbols-outlined text-[22px]">person</span>
                            <span class="sidebar-text text-sm font-medium">Profil Saya</span>
                        </a>
                    </nav>
                </div>
                
                <a href="{{ route('admin.profile.index') }}" class="user-profile flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-emerald-100 cursor-pointer transition-colors block text-left">
                    <div class="h-9 w-9 rounded-full bg-emerald-200 flex items-center justify-center shrink-0">
                        <span class="text-emerald-800 font-bold text-sm">{{ substr($user->nama ?? 'A', 0, 1) }}</span>
                    </div>
                    <div class="user-info flex-1 min-w-0">
                        <p class="text-emerald-900 text-sm font-medium truncate">{{ $user->nama ?? 'Admin' }}</p>
                        <p class="text-emerald-600 text-xs">Administrator</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="logout-btn shrink-0">
                        @csrf
                        <button type="submit" class="text-emerald-600 hover:text-red-500 transition-colors">
                            <span class="material-symbols-outlined text-[20px]">logout</span>
                        </button>
                    </form>
                </a>
            </div>
        </aside>

        <div class="flex-1 flex flex-col h-full overflow-hidden bg-white">
            <header class="flex items-center justify-between border-b border-emerald-100 bg-white px-4 md:px-6 py-4 shrink-0">
                <div class="flex items-center gap-3 md:gap-4">
                    <button onclick="toggleSidebar()" class="text-emerald-700 hover:text-emerald-900 transition-colors p-1">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <h2 class="text-emerald-900 text-lg md:text-xl font-bold truncate">{{ $title ?? 'Dashboard' }}</h2>
                </div>
                <div class="flex items-center gap-2 md:gap-4">
                    <div class="hidden lg:flex items-center bg-emerald-50 rounded-lg px-3 py-2 w-64 border border-emerald-100">
                        <span class="material-symbols-outlined text-emerald-500 text-[20px]">search</span>
                        <input type="text" placeholder="Cari..." class="bg-transparent border-none text-sm text-emerald-900 placeholder-emerald-400 focus:ring-0 w-full ml-2">
                    </div>
                    <button class="lg:hidden flex items-center justify-center h-10 w-10 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 transition-colors">
                        <span class="material-symbols-outlined text-[20px]">search</span>
                    </button>
                    <button class="relative flex items-center justify-center h-10 w-10 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 transition-colors">
                        <span class="material-symbols-outlined text-[20px]">notifications</span>
                        <span class="absolute top-2 right-2 h-2 w-2 rounded-full bg-red-500"></span>
                    </button>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto bg-white">
                {{ $slot }}
            </main>
        </div>

        <div id="slideOverBackdrop" class="slide-over-backdrop fixed inset-0 bg-black/40 z-40 hidden" onclick="closeSlideOver()"></div>
        
        @if(isset($slideOver))
            <aside id="slideOverPanel" class="slide-over-panel fixed right-0 top-0 h-full w-full sm:w-[420px] bg-white flex-col shrink-0 shadow-2xl z-50 overflow-y-auto hidden">
                {{ $slideOver }}
            </aside>
        @endif
    </div>

    <script>
        // Load sidebar state on page load
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (sidebarCollapsed) {
                document.getElementById('app').classList.add('sidebar-collapsed');
            }
        });

        function toggleSidebar() {
            const app = document.getElementById('app');
            
            // On mobile, toggle mobile sidebar
            if (window.innerWidth < 768) {
                app.classList.toggle('mobile-sidebar-open');
            } else {
                // On desktop, toggle collapsed state
                app.classList.toggle('sidebar-collapsed');
                const isCollapsed = app.classList.contains('sidebar-collapsed');
                localStorage.setItem('sidebarCollapsed', isCollapsed);
            }
        }

        function closeMobileSidebar() {
            document.getElementById('app').classList.remove('mobile-sidebar-open');
        }

        function openSlideOver() {
            const backdrop = document.getElementById('slideOverBackdrop');
            const panel = document.getElementById('slideOverPanel');
            
            backdrop.classList.remove('hidden');
            panel.classList.remove('hidden');
            panel.classList.add('flex');
            
            // Trigger animation
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
            
            // Wait for animation to finish
            setTimeout(() => {
                backdrop.classList.add('hidden');
                panel.classList.add('hidden');
                panel.classList.remove('flex');
            }, 300);
        }

        // Close mobile sidebar on window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                document.getElementById('app').classList.remove('mobile-sidebar-open');
            }
        });
    </script>
</body>
</html>
