<x-layouts.petugas title="Riwayat Pembayaran">
    <div class="px-4 py-5 flex flex-col gap-5 pb-24">
        <div class="flex flex-wrap gap-2 items-center">
            <a class="text-slate-500 text-sm font-medium hover:text-orange-600 hover:underline"
                href="{{ route('petugas.home') }}">Home</a>
            <span class="text-slate-400 text-sm">/</span>
            <span class="text-slate-800 text-sm font-medium">Riwayat</span>
        </div>

        <div>
            <h1 class="text-slate-800 text-2xl font-bold tracking-tight">Riwayat Pembayaran</h1>
            <p class="text-slate-500 text-sm mt-1">Lacak dan kelola transaksi harian Anda.</p>
        </div>

        <div class="grid grid-cols-1 gap-3">
            <div
                class="flex flex-col gap-1 rounded-xl p-4 bg-gradient-to-br from-orange-500 to-orange-600 text-white shadow-lg shadow-orange-600/30">
                <div class="flex items-center gap-2 text-orange-100">
                    <span class="material-symbols-outlined text-lg">payments</span>
                    <p class="text-sm font-medium">Total Bulan Ini</p>
                </div>
                <p class="text-2xl font-bold tracking-tight">Rp {{ number_format($totalBulanIni ?? 0, 0, ',', '.') }}
                </p>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1 rounded-xl p-4 bg-white shadow-sm border border-slate-100">
                    <div class="flex items-center gap-2 text-slate-500">
                        <span class="material-symbols-outlined text-lg text-amber-500">pending_actions</span>
                        <p class="text-xs font-medium">Pending</p>
                    </div>
                    <p class="text-xl font-bold text-slate-800">{{ $pending ?? 0 }}</p>
                </div>
                <div class="flex flex-col gap-1 rounded-xl p-4 bg-white shadow-sm border border-slate-100">
                    <div class="flex items-center gap-2 text-slate-500">
                        <span class="material-symbols-outlined text-lg text-green-500">verified</span>
                        <p class="text-xs font-medium">Selesai</p>
                    </div>
                    <p class="text-xl font-bold text-slate-800">{{ $settled ?? 0 }}</p>
                </div>
            </div>
        </div>

        <form method="GET" class="flex flex-col gap-3 rounded-xl bg-white p-4 shadow-sm border border-slate-100">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <span class="material-symbols-outlined text-xl">search</span>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="w-full rounded-xl border-slate-200 bg-slate-50 placeholder:text-slate-400 focus:border-orange-500 focus:ring-orange-500 py-2.5 pl-10 pr-4 text-sm"
                    placeholder="Cari nama pelanggan...">
            </div>

            <div class="flex flex-wrap gap-2">
                <select name="status" onchange="this.form.submit()"
                    class="text-sm rounded-lg border-slate-200 bg-slate-50 py-2 pl-3 pr-8 focus:border-orange-500 focus:ring-orange-500">
                    <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="menunggu_admin" {{ request('status') === 'menunggu_admin' ? 'selected' : '' }}>
                        Pending</option>
                    <option value="disetujui" {{ request('status') === 'disetujui' ? 'selected' : '' }}>Disetujui
                    </option>
                    <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>

                <select name="metode" onchange="this.form.submit()"
                    class="text-sm rounded-lg border-slate-200 bg-slate-50 py-2 pl-3 pr-8 focus:border-orange-500 focus:ring-orange-500">
                    <option value="all" {{ request('metode') === 'all' ? 'selected' : '' }}>Semua Metode</option>
                    <option value="tunai" {{ request('metode') === 'tunai' ? 'selected' : '' }}>Tunai</option>
                    <option value="transfer" {{ request('metode') === 'transfer' ? 'selected' : '' }}>Transfer</option>
                </select>

                <select name="periode" onchange="this.form.submit()"
                    class="text-sm rounded-lg border-slate-200 bg-slate-50 py-2 pl-3 pr-8 focus:border-orange-500 focus:ring-orange-500">
                    <option value="" {{ !request('periode') ? 'selected' : '' }}>Semua Waktu</option>
                    <option value="7days" {{ request('periode') === '7days' ? 'selected' : '' }}>7 Hari</option>
                    <option value="30days" {{ request('periode') === '30days' ? 'selected' : '' }}>30 Hari</option>
                    <option value="thismonth" {{ request('periode') === 'thismonth' ? 'selected' : '' }}>Bulan Ini
                    </option>
                </select>
            </div>

            @if (request('search') || request('status') || request('metode') || request('periode'))
                <a href="{{ route('petugas.riwayat') }}" class="text-sm text-orange-600 font-medium hover:underline">
                    Hapus Filter
                </a>
            @endif
        </form>

        <div class="flex flex-col gap-3">
            @forelse($pembayaran ?? [] as $item)
                @php
                    $statusConfig = match ($item->status) {
                        'disetujui' => [
                            'bg' => 'bg-green-100',
                            'text' => 'text-green-700',
                            'label' => 'SELESAI',
                            'ring' => 'ring-green-600/20',
                        ],
                        'menunggu_admin' => [
                            'bg' => 'bg-amber-100',
                            'text' => 'text-amber-700',
                            'label' => 'PENDING',
                            'ring' => 'ring-amber-600/20',
                        ],
                        'ditolak' => [
                            'bg' => 'bg-red-100',
                            'text' => 'text-red-700',
                            'label' => 'DITOLAK',
                            'ring' => 'ring-red-600/20',
                        ],
                        default => [
                            'bg' => 'bg-slate-100',
                            'text' => 'text-slate-700',
                            'label' => 'UNKNOWN',
                            'ring' => 'ring-slate-600/20',
                        ],
                    };
                    $initials = collect(explode(' ', $item->tagihan->pelanggan->nama ?? 'NA'))
                        ->map(fn($word) => substr($word, 0, 1))
                        ->take(2)
                        ->implode('');
                    $colors = [
                        'bg-blue-100 text-blue-600',
                        'bg-purple-100 text-purple-600',
                        'bg-indigo-100 text-indigo-600',
                        'bg-teal-100 text-teal-600',
                        'bg-orange-100 text-orange-600',
                    ];
                    $colorClass = $colors[($item->id ?? 0) % count($colors)];
                @endphp

                <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="p-4">
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full {{ $colorClass }} flex items-center justify-center text-xs font-bold shrink-0">
                                    {{ $initials }}
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-semibold text-slate-800 truncate">
                                        {{ $item->tagihan->pelanggan->nama ?? '-' }}</h4>
                                    <p class="text-xs text-slate-500">{{ $item->created_at->format('d M Y') }} <span
                                            class="text-slate-300 mx-1">•</span> {{ $item->created_at->format('H:i') }}
                                    </p>
                                </div>
                            </div>
                            <span
                                class="inline-flex items-center rounded-full {{ $statusConfig['bg'] }} px-2 py-0.5 text-[10px] font-bold {{ $statusConfig['text'] }} ring-1 ring-inset {{ $statusConfig['ring'] }} shrink-0">
                                {{ $statusConfig['label'] }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-1.5 text-slate-500 text-sm">
                                    <span
                                        class="material-symbols-outlined text-[16px]">{{ $item->metode === 'tunai' ? 'payments' : 'credit_card' }}</span>
                                    <span class="capitalize">{{ $item->metode }}</span>
                                </div>
                                <p class="text-xs font-mono text-slate-400">
                                    TXN-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</p>
                            </div>
                            <p
                                class="text-base font-bold {{ $item->status === 'ditolak' ? 'text-slate-400 line-through' : 'text-slate-800' }}">
                                Rp {{ number_format($item->jumlah_bayar ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl p-8 border border-slate-100 text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-3xl text-slate-400">receipt_long</span>
                    </div>
                    <h3 class="font-semibold text-slate-800 mb-1">Tidak ada riwayat</h3>
                    <p class="text-sm text-slate-500">Belum ada transaksi yang tercatat.</p>
                </div>
            @endforelse
        </div>

        @if (isset($pembayaran) && $pembayaran->hasPages())
            <div class="flex items-center justify-between bg-white rounded-xl p-3 border border-slate-100">
                <p class="text-sm text-slate-500">
                    <span class="font-semibold text-slate-800">{{ $pembayaran->firstItem() }}</span> -
                    <span class="font-semibold text-slate-800">{{ $pembayaran->lastItem() }}</span> dari
                    <span class="font-semibold text-slate-800">{{ $pembayaran->total() }}</span>
                </p>
                <div class="flex gap-1">
                    @if ($pembayaran->onFirstPage())
                        <span class="px-3 py-2 rounded-lg text-slate-300 bg-slate-50">
                            <span class="material-symbols-outlined text-lg">chevron_left</span>
                        </span>
                    @else
                        <a href="{{ $pembayaran->previousPageUrl() }}"
                            class="px-3 py-2 rounded-lg text-slate-600 hover:bg-slate-100 transition-colors">
                            <span class="material-symbols-outlined text-lg">chevron_left</span>
                        </a>
                    @endif

                    @if ($pembayaran->hasMorePages())
                        <a href="{{ $pembayaran->nextPageUrl() }}"
                            class="px-3 py-2 rounded-lg text-slate-600 hover:bg-slate-100 transition-colors">
                            <span class="material-symbols-outlined text-lg">chevron_right</span>
                        </a>
                    @else
                        <span class="px-3 py-2 rounded-lg text-slate-300 bg-slate-50">
                            <span class="material-symbols-outlined text-lg">chevron_right</span>
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</x-layouts.petugas>
