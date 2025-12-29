<x-layouts.petugas title="Saldo">
    <div class="px-4 py-5 flex flex-col gap-5 pb-24">
        <div class="flex flex-wrap gap-2 items-center">
            <a class="text-slate-500 text-sm font-medium hover:text-orange-600 hover:underline"
                href="{{ route('petugas.home') }}">Home</a>
            <span class="text-slate-400 text-sm">/</span>
            <span class="text-slate-800 text-sm font-medium">Saldo</span>
        </div>

        <section
            class="bg-orange-600 rounded-2xl p-5 text-white shadow-lg shadow-orange-600/30 relative overflow-hidden">
            <div class="absolute top-0 right-0 opacity-10">
                <span class="material-symbols-outlined text-[100px] -rotate-12">account_balance_wallet</span>
            </div>

            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-white/20 rounded-xl">
                        <span class="material-symbols-outlined filled text-2xl">account_balance_wallet</span>
                    </div>
                    <div>
                        <p class="text-sm text-orange-100 font-medium">Uang di Tangan</p>
                        <p class="text-xs text-orange-200">Siap untuk disetor ke Admin</p>
                    </div>
                </div>

                <p class="text-4xl font-bold mb-1">Rp {{ number_format($totalSaldo ?? 0, 0, ',', '.') }}</p>

                <div class="flex items-center gap-2 text-sm text-orange-200 mb-5">
                    <span class="material-symbols-outlined text-[16px]">receipt_long</span>
                    <span>{{ $totalTransaksi ?? 0 }} transaksi terverifikasi</span>
                </div>

                <button type="button" onclick="konfirmasiSetor()" {{ ($totalSaldo ?? 0) <= 0 ? 'disabled' : '' }}
                    class="flex items-center justify-center gap-2 w-full py-3.5 bg-white text-orange-600 font-bold rounded-xl hover:bg-orange-50 transition-colors disabled:opacity-50 disabled:cursor-not-allowed shadow-lg">
                    <span class="material-symbols-outlined text-xl">publish</span>
                    Setor ke Admin
                </button>
            </div>
        </section>

        <section class="grid grid-cols-2 gap-3">
            <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-sm">
                <div class="flex items-center gap-2 text-slate-500 mb-2">
                    <span class="material-symbols-outlined text-lg text-green-500">verified</span>
                    <p class="text-xs font-medium">Sudah Disetor</p>
                </div>
                <p class="text-lg font-bold text-slate-800">Rp {{ number_format($sudahDisetor ?? 0, 0, ',', '.') }}</p>
                <p class="text-xs text-slate-400 mt-1">Bulan ini</p>
            </div>
            <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-sm">
                <div class="flex items-center gap-2 text-slate-500 mb-2">
                    <span class="material-symbols-outlined text-lg text-amber-500">pending_actions</span>
                    <p class="text-xs font-medium">Menunggu Verifikasi</p>
                </div>
                <p class="text-lg font-bold text-slate-800">{{ $pending ?? 0 }}</p>
                <p class="text-xs text-slate-400 mt-1">Transaksi</p>
            </div>
        </section>

        <section>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-slate-800">Transaksi Belum Disetor</h2>
                <a href="{{ route('petugas.riwayat') }}"
                    class="text-sm text-orange-600 font-medium hover:underline flex items-center gap-1">
                    Lihat Riwayat
                    <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </a>
            </div>

            <div class="flex flex-col gap-3">
                @forelse($transaksi ?? [] as $item)
                    @php
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

                    <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full {{ $colorClass }} flex items-center justify-center text-xs font-bold shrink-0">
                                {{ $initials }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="min-w-0">
                                        <h3 class="font-semibold text-slate-800 truncate">
                                            {{ $item->tagihan->pelanggan->nama ?? '-' }}</h3>
                                        <p class="text-xs text-slate-500">{{ $item->created_at->format('d M Y, H:i') }}
                                        </p>
                                    </div>
                                    <p class="text-base font-bold text-green-600 shrink-0">
                                        +Rp {{ number_format($item->jumlah_bayar ?? 0, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-3 pt-3 border-t border-slate-100">
                            <div class="flex items-center gap-3 text-xs text-slate-500">
                                <span class="flex items-center gap-1">
                                    <span
                                        class="material-symbols-outlined text-[14px]">{{ $item->metode === 'tunai' ? 'payments' : 'credit_card' }}</span>
                                    <span class="capitalize">{{ $item->metode }}</span>
                                </span>
                                <span
                                    class="font-mono text-slate-400">TXN-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <span
                                class="inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-[10px] font-bold text-green-700">
                                VERIFIED
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl p-8 border border-slate-100 text-center">
                        <div class="w-16 h-16 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span
                                class="material-symbols-outlined text-3xl text-orange-400">account_balance_wallet</span>
                        </div>
                        <h3 class="font-semibold text-slate-800 mb-1">Belum ada saldo</h3>
                        <p class="text-sm text-slate-500 mb-4">Transaksi yang terverifikasi akan muncul di sini.</p>
                        <a href="{{ route('petugas.tagihan') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-lg hover:bg-orange-700 transition-colors">
                            <span class="material-symbols-outlined text-lg">add</span>
                            Input Pembayaran
                        </a>
                    </div>
                @endforelse
            </div>
        </section>

        @if (($totalTransaksi ?? 0) > 5)
            <div class="text-center">
                <a href="{{ route('petugas.riwayat') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-orange-600 text-sm font-medium hover:underline">
                    Lihat semua transaksi
                    <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </a>
            </div>
        @endif
    </div>

    <script>
        function konfirmasiSetor() {
            Swal.fire({
                title: 'Setor ke Admin?',
                html: `
                    <div class="text-left">
                        <p class="text-slate-600 mb-4">Pastikan jumlah uang tunai sudah sesuai sebelum menyetor.</p>
                        <div class="bg-orange-50 rounded-lg p-4 border border-orange-200">
                            <p class="text-sm text-orange-700">Total yang akan disetor:</p>
                            <p class="text-2xl font-bold text-orange-600">Rp {{ number_format($totalSaldo ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#EA580C',
                cancelButtonColor: '#64748B',
                confirmButtonText: '<span class="flex items-center gap-2"><span class="material-symbols-outlined">check</span>Ya, Setor Sekarang</span>',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'swal2-confirm',
                    cancelButton: 'swal2-cancel'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Hubungi Admin',
                        html: `
                            <div class="text-left">
                                <p class="text-slate-600 mb-4">Silakan temui admin untuk proses setor tunai.</p>
                                <div class="space-y-2 text-sm">
                                    <div class="flex items-center gap-2 text-slate-500">
                                        <span class="material-symbols-outlined text-orange-500">location_on</span>
                                        <span>Kantor Pusat BangJaki</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-slate-500">
                                        <span class="material-symbols-outlined text-orange-500">schedule</span>
                                        <span>Senin - Jumat, 08:00 - 17:00</span>
                                    </div>
                                </div>
                            </div>
                        `,
                        icon: 'info',
                        confirmButtonColor: '#EA580C',
                        confirmButtonText: 'Mengerti'
                    });
                }
            });
        }
    </script>
</x-layouts.petugas>
