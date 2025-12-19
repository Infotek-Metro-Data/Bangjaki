<x-layouts.admin title="Dashboard Petugas">
    <div class="h-full flex flex-col">
        <div class="flex-1 p-4 md:p-6 lg:p-8 overflow-y-auto">
            <div class="max-w-[1400px] mx-auto flex flex-col gap-6">
                <div class="flex flex-col gap-1 border-b border-emerald-100 pb-6">
                    <h1 class="text-emerald-900 text-xl md:text-2xl font-bold leading-tight">
                        Selamat Datang, {{ auth()->user()->nama }}!
                    </h1>
                    <p class="text-emerald-600 text-sm">Dashboard petugas lapangan BangJaki</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white p-5 rounded-xl border border-emerald-100 shadow-sm flex flex-col">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 rounded-lg bg-blue-50 text-blue-600">
                                <span class="material-symbols-outlined">receipt_long</span>
                            </div>
                            <span class="text-sm font-medium text-emerald-600">Tagihan Hari Ini</span>
                        </div>
                        <p class="text-3xl font-bold text-emerald-900">0</p>
                    </div>
                    <div class="bg-white p-5 rounded-xl border border-emerald-100 shadow-sm flex flex-col">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 rounded-lg bg-emerald-50 text-emerald-600">
                                <span class="material-symbols-outlined">payments</span>
                            </div>
                            <span class="text-sm font-medium text-emerald-600">Pembayaran</span>
                        </div>
                        <p class="text-3xl font-bold text-emerald-900">0</p>
                    </div>
                    <div class="bg-white p-5 rounded-xl border border-emerald-100 shadow-sm flex flex-col">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 rounded-lg bg-amber-50 text-amber-600">
                                <span class="material-symbols-outlined">account_balance_wallet</span>
                            </div>
                            <span class="text-sm font-medium text-emerald-600">Saldo di Tangan</span>
                        </div>
                        <p class="text-3xl font-bold text-emerald-900">Rp 0</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-emerald-100 p-6">
                    <h2 class="text-lg font-bold text-emerald-900 mb-4">Menu Cepat</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="#"
                            class="flex flex-col items-center gap-2 p-4 rounded-lg bg-emerald-50 hover:bg-emerald-100 transition-colors">
                            <span class="material-symbols-outlined text-emerald-600 text-[32px]">receipt_long</span>
                            <span class="text-sm font-medium text-emerald-700">Tagihan</span>
                        </a>
                        <a href="#"
                            class="flex flex-col items-center gap-2 p-4 rounded-lg bg-emerald-50 hover:bg-emerald-100 transition-colors">
                            <span class="material-symbols-outlined text-emerald-600 text-[32px]">payments</span>
                            <span class="text-sm font-medium text-emerald-700">Input Bayar</span>
                        </a>
                        <a href="#"
                            class="flex flex-col items-center gap-2 p-4 rounded-lg bg-emerald-50 hover:bg-emerald-100 transition-colors">
                            <span
                                class="material-symbols-outlined text-emerald-600 text-[32px]">account_balance_wallet</span>
                            <span class="text-sm font-medium text-emerald-700">Saldo</span>
                        </a>
                        <a href="#"
                            class="flex flex-col items-center gap-2 p-4 rounded-lg bg-emerald-50 hover:bg-emerald-100 transition-colors">
                            <span class="material-symbols-outlined text-emerald-600 text-[32px]">person</span>
                            <span class="text-sm font-medium text-emerald-700">Profil</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
