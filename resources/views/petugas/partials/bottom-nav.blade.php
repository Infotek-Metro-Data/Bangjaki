<nav class="bottom-nav sticky bottom-0 left-0 right-0 bg-white border-t border-slate-200 z-40">
    <div class="flex items-center justify-around h-16 relative">
        <a href="{{ route('petugas.home') }}"
            class="flex flex-col items-center justify-center gap-0.5 px-3 py-2 {{ request()->routeIs('petugas.home') ? 'text-orange-600' : 'text-slate-400' }} transition-colors">
            <span
                class="material-symbols-outlined text-[24px] {{ request()->routeIs('petugas.home') ? 'filled' : '' }}">home</span>
            <span class="text-[10px] font-medium">Home</span>
        </a>

        <a href="{{ route('petugas.tagihan') }}"
            class="flex flex-col items-center justify-center gap-0.5 px-3 py-2 {{ request()->routeIs('petugas.tagihan*') ? 'text-orange-600' : 'text-slate-400' }} transition-colors">
            <span
                class="material-symbols-outlined text-[24px] {{ request()->routeIs('petugas.tagihan*') ? 'filled' : '' }}">receipt_long</span>
            <span class="text-[10px] font-medium">Tagihan</span>
        </a>

        <a href="{{ route('petugas.input') }}"
            class="fab-button absolute left-1/2 -translate-x-1/2 flex items-center justify-center w-14 h-14 bg-orange-600 rounded-full text-white hover:bg-orange-700 active:scale-95 transition-all">
            <span class="material-symbols-outlined text-[28px]">add</span>
        </a>

        <a href="{{ route('petugas.saldo') }}"
            class="flex flex-col items-center justify-center gap-0.5 px-3 py-2 {{ request()->routeIs('petugas.saldo*') ? 'text-orange-600' : 'text-slate-400' }} transition-colors">
            <span
                class="material-symbols-outlined text-[24px] {{ request()->routeIs('petugas.saldo*') ? 'filled' : '' }}">account_balance_wallet</span>
            <span class="text-[10px] font-medium">Saldo</span>
        </a>

        <a href="{{ route('petugas.profile') }}"
            class="flex flex-col items-center justify-center gap-0.5 px-3 py-2 {{ request()->routeIs('petugas.profile*') ? 'text-orange-600' : 'text-slate-400' }} transition-colors">
            <span
                class="material-symbols-outlined text-[24px] {{ request()->routeIs('petugas.profile*') ? 'filled' : '' }}">person</span>
            <span class="text-[10px] font-medium">Profil</span>
        </a>
    </div>
</nav>
