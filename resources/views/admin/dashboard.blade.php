<x-layouts.admin title="Dashboard Overview">
    <div class="p-4 md:p-6 lg:p-8">
        <div class="max-w-[1400px] mx-auto flex flex-col gap-6">

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4">
                <div class="flex flex-col gap-2 rounded-xl p-4 md:p-6 bg-white border border-gray-100 shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-gray-500 text-xs md:text-sm font-medium">Total Pelanggan</p>
                        <span
                            class="hidden md:inline-flex bg-orange-100 text-orange-700 px-2 py-0.5 rounded text-xs font-bold">Aktif</span>
                    </div>
                    <p class="text-slate-900 text-2xl md:text-3xl font-bold tracking-tight">
                        {{ number_format($totalPelanggan ?? 0) }}</p>
                </div>
                <div class="flex flex-col gap-2 rounded-xl p-4 md:p-6 bg-white border border-gray-100 shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-gray-500 text-xs md:text-sm font-medium">Jatuh Tempo</p>
                        <span
                            class="hidden md:inline-flex bg-amber-100 text-amber-700 px-2 py-0.5 rounded text-xs font-bold">Hari
                            Ini</span>
                    </div>
                    <p class="text-slate-900 text-2xl md:text-3xl font-bold tracking-tight">
                        {{ number_format($tagihanHariIni ?? 0) }}</p>
                </div>
                <div class="flex flex-col gap-2 rounded-xl p-4 md:p-6 bg-white border border-gray-100 shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-gray-500 text-xs md:text-sm font-medium">Verifikasi</p>
                        <span
                            class="hidden md:inline-flex bg-blue-100 text-blue-700 px-2 py-0.5 rounded text-xs font-bold">Pending</span>
                    </div>
                    <p class="text-slate-900 text-2xl md:text-3xl font-bold tracking-tight">
                        {{ number_format($pendingVerifikasi ?? 0) }}</p>
                </div>
                <div class="flex flex-col gap-2 rounded-xl p-4 md:p-6 bg-white border border-gray-100 shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-gray-500 text-xs md:text-sm font-medium">Uang Petugas</p>
                        <span
                            class="hidden md:inline-flex bg-red-100 text-red-700 px-2 py-0.5 rounded text-xs font-bold">Setor</span>
                    </div>
                    <p class="text-slate-900 text-xl md:text-2xl lg:text-3xl font-bold tracking-tight">Rp
                        {{ number_format($uangPetugas ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1 flex flex-col">
                    <div class="rounded-xl border border-gray-100 bg-white shadow-sm flex flex-col flex-1">
                        <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-slate-900 text-base font-bold">Perlu Tindakan</h3>
                            <span
                                class="bg-orange-100 text-orange-700 px-2 py-0.5 rounded text-xs font-bold">{{ $recentPending->count() ?? 0 }}
                                Pending</span>
                        </div>
                        <div class="flex flex-col p-2 gap-2 flex-1 max-h-[400px] overflow-y-auto">
                            @forelse($recentPending ?? [] as $payment)
                                <div
                                    class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                                    <div
                                        class="h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-700 font-bold text-sm shrink-0">
                                        {{ strtoupper(substr($payment->tagihan->pelanggan->nama ?? 'N', 0, 2)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-slate-900 text-sm font-semibold truncate">
                                            {{ $payment->tagihan->pelanggan->nama ?? 'N/A' }}</p>
                                        <p class="text-gray-500 text-xs truncate">
                                            {{ $payment->petugas->nama ?? 'Petugas' }} • Rp
                                            {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="flex gap-1">
                                        <form method="POST"
                                            action="{{ route('admin.verifikasi.approve', $payment->id) }}">
                                            @csrf
                                            <button type="submit"
                                                class="h-8 w-8 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center hover:bg-orange-500 hover:text-white transition-all">
                                                <span class="material-symbols-outlined text-[18px]">check</span>
                                            </button>
                                        </form>
                                        <button
                                            class="h-8 w-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all">
                                            <span class="material-symbols-outlined text-[18px]">close</span>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="flex-1 flex flex-col items-center justify-center py-8 text-center">
                                    <span class="material-symbols-outlined text-[48px] text-gray-300">task_alt</span>
                                    <p class="text-gray-500 text-sm mt-2">Tidak ada yang perlu diverifikasi</p>
                                </div>
                            @endforelse
                        </div>
                        <div class="p-4 border-t border-gray-100">
                            <a href="{{ route('admin.verifikasi.index') }}"
                                class="block w-full py-2 text-sm font-semibold text-orange-600 hover:text-orange-700 text-center transition-colors">
                                Lihat Semua Pending →
                            </a>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-2">
                    <div class="rounded-xl border border-gray-100 bg-white overflow-hidden shadow-sm">
                        <div
                            class="p-4 md:p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <h3 class="text-slate-900 text-base md:text-lg font-bold">Transaksi Terbaru</h3>
                            <a href="{{ route('admin.verifikasi.index') }}"
                                class="px-3 py-1.5 bg-orange-100 hover:bg-orange-200 text-orange-700 text-xs font-bold rounded-lg transition-colors">
                                Lihat Semua
                            </a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="bg-gray-50/50">
                                        <th
                                            class="px-4 md:px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Pelanggan</th>
                                        <th
                                            class="hidden md:table-cell px-4 md:px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Petugas</th>
                                        <th
                                            class="px-4 md:px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Nominal</th>
                                        <th
                                            class="hidden sm:table-cell px-4 md:px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($recentTransactions ?? $recentPending ?? [] as $tx)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="px-4 md:px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="hidden sm:flex w-8 h-8 rounded-full bg-orange-100 items-center justify-center text-orange-700 font-bold text-xs shrink-0">
                                                        {{ strtoupper(substr($tx->tagihan->pelanggan->nama ?? 'N', 0, 2)) }}
                                                    </div>
                                                    <span
                                                        class="text-slate-900 text-sm font-medium truncate">{{ $tx->tagihan->pelanggan->nama ?? 'N/A' }}</span>
                                                </div>
                                            </td>
                                            <td class="hidden md:table-cell px-4 md:px-6 py-4 text-gray-500 text-sm">
                                                {{ $tx->petugas->nama ?? '-' }}</td>
                                            <td class="px-4 md:px-6 py-4 text-slate-900 text-sm font-semibold">Rp
                                                {{ number_format($tx->jumlah_bayar, 0, ',', '.') }}</td>
                                            <td class="hidden sm:table-cell px-4 md:px-6 py-4">
                                                @php
                                                    $statusColor = match ($tx->status) {
                                                        'disetujui' => 'bg-green-100 text-green-700 border-green-200',
                                                        'ditolak' => 'bg-red-100 text-red-700 border-red-200',
                                                        'disetor' => 'bg-blue-100 text-blue-700 border-blue-200',
                                                        default => 'bg-amber-100 text-amber-700 border-amber-200',
                                                    };
                                                    $statusLabel = match ($tx->status) {
                                                        'disetujui' => 'Disetujui',
                                                        'ditolak' => 'Ditolak',
                                                        'disetor' => 'Disetor',
                                                        'menunggu_admin' => 'Pending',
                                                        default => ucfirst($tx->status),
                                                    };
                                                @endphp
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium border {{ $statusColor }}">
                                                    {{ $statusLabel }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-12 text-center">
                                                <span
                                                    class="material-symbols-outlined text-[48px] text-gray-300">receipt_long</span>
                                                <p class="text-gray-500 text-sm mt-2">Belum ada transaksi</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
                <a href="{{ route('admin.pelanggan.index') }}"
                    class="flex items-center gap-3 p-3 md:p-4 rounded-xl border border-gray-100 bg-white hover:border-orange-300 hover:shadow-md transition-all group">
                    <div
                        class="h-10 w-10 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center group-hover:bg-orange-500 group-hover:text-white transition-colors shrink-0">
                        <span class="material-symbols-outlined text-[22px]">person_add</span>
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-slate-900 text-sm font-semibold group-hover:text-orange-600 transition-colors">
                            Tambah Pelanggan</p>
                        <p class="text-gray-500 text-xs">Daftarkan baru</p>
                    </div>
                </a>

                <a href="{{ route('admin.verifikasi.index') }}"
                    class="flex items-center gap-3 p-3 md:p-4 rounded-xl border border-gray-100 bg-white hover:border-orange-300 hover:shadow-md transition-all group">
                    <div
                        class="h-10 w-10 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-colors shrink-0">
                        <span class="material-symbols-outlined text-[22px]">fact_check</span>
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-slate-900 text-sm font-semibold group-hover:text-orange-600 transition-colors">
                            Verifikasi</p>
                        <p class="text-gray-500 text-xs">{{ $pendingVerifikasi ?? 0 }} menunggu</p>
                    </div>
                </a>

                <a href="{{ route('admin.settlement.index') }}"
                    class="flex items-center gap-3 p-3 md:p-4 rounded-xl border border-gray-100 bg-white hover:border-orange-300 hover:shadow-md transition-all group">
                    <div
                        class="h-10 w-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-colors shrink-0">
                        <span class="material-symbols-outlined text-[22px]">payments</span>
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-slate-900 text-sm font-semibold group-hover:text-orange-600 transition-colors">
                            Settlement</p>
                        <p class="text-gray-500 text-xs">Rekonsiliasi</p>
                    </div>
                </a>

                <a href="{{ route('admin.petugas.index') }}"
                    class="flex items-center gap-3 p-3 md:p-4 rounded-xl border border-gray-100 bg-white hover:border-orange-300 hover:shadow-md transition-all group">
                    <div
                        class="h-10 w-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-500 group-hover:text-white transition-colors shrink-0">
                        <span class="material-symbols-outlined text-[22px]">manage_accounts</span>
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-slate-900 text-sm font-semibold group-hover:text-orange-600 transition-colors">
                            Kelola Petugas</p>
                        <p class="text-gray-500 text-xs">Tim lapangan</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-layouts.admin>
