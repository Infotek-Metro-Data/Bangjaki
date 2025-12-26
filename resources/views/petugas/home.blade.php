<x-layouts.petugas title="Dashboard">
    <div class="px-4 py-5 flex flex-col gap-5">
        <section class="bg-orange-600 rounded-2xl p-5 text-white shadow-lg shadow-orange-600/30">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-2 bg-white/20 rounded-xl">
                    <span class="material-symbols-outlined filled text-2xl">account_balance_wallet</span>
                </div>
                <div>
                    <p class="text-sm text-orange-100 font-medium">Uang di Tangan</p>
                    <p class="text-xs text-orange-200">Hari ini, {{ now()->locale('id')->translatedFormat('d F Y') }}</p>
                </div>
            </div>

            <p class="text-3xl font-bold mb-4">Rp {{ number_format($totalSaldo ?? 0, 0, ',', '.') }}</p>

            <div class="flex items-center gap-2 text-xs text-orange-200 mb-4">
                <span class="material-symbols-outlined text-[16px]">info</span>
                <span>Total dari {{ $totalTransaksi ?? 0 }} transaksi hari ini</span>
            </div>

            <a href="{{ route('petugas.saldo') }}"
                class="flex items-center justify-center gap-2 w-full py-3 bg-white text-orange-600 font-semibold rounded-xl hover:bg-orange-50 transition-colors">
                <span class="material-symbols-outlined text-xl">publish</span>
                Setor ke Admin
            </a>
        </section>

        <section class="grid grid-cols-3 gap-3">
            <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-sm">
                <div class="flex items-center justify-center w-10 h-10 bg-amber-50 rounded-xl mb-2 mx-auto">
                    <span class="material-symbols-outlined text-amber-600">schedule</span>
                </div>
                <p class="text-2xl font-bold text-slate-800 text-center">{{ $jatuhTempo ?? 0 }}</p>
                <p class="text-xs text-slate-500 text-center">Jatuh Tempo</p>
            </div>

            <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-sm">
                <div class="flex items-center justify-center w-10 h-10 bg-green-50 rounded-xl mb-2 mx-auto">
                    <span class="material-symbols-outlined text-green-600">check_circle</span>
                </div>
                <p class="text-2xl font-bold text-slate-800 text-center">{{ $sudahBayar ?? 0 }}</p>
                <p class="text-xs text-slate-500 text-center">Sudah Bayar</p>
            </div>

            <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-sm">
                <div class="flex items-center justify-center w-10 h-10 bg-red-50 rounded-xl mb-2 mx-auto">
                    <span class="material-symbols-outlined text-red-600">warning</span>
                </div>
                <p class="text-2xl font-bold text-slate-800 text-center">{{ $menunggak ?? 0 }}</p>
                <p class="text-xs text-slate-500 text-center">Menunggak</p>
            </div>
        </section>

        <section>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-slate-800">Tugas Hari Ini</h2>
                <a href="{{ route('petugas.tagihan') }}" class="text-sm text-orange-600 font-medium hover:underline">
                    Lihat Semua
                </a>
            </div>

            <div class="flex gap-2 mb-4 overflow-x-auto hide-scrollbar pb-1" x-data="{ filter: '{{ request('filter', 'semua') }}' }">
                <a href="{{ route('petugas.home', ['filter' => 'semua']) }}"
                    class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition-colors {{ request('filter', 'semua') === 'semua' ? 'bg-orange-600 text-white' : 'bg-white text-slate-600 border border-slate-200' }}">
                    Semua
                </a>
                <a href="{{ route('petugas.home', ['filter' => 'jatuh_tempo']) }}"
                    class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition-colors {{ request('filter') === 'jatuh_tempo' ? 'bg-orange-600 text-white' : 'bg-white text-slate-600 border border-slate-200' }}">
                    Jatuh Tempo
                </a>
                <a href="{{ route('petugas.home', ['filter' => 'menunggak']) }}"
                    class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition-colors {{ request('filter') === 'menunggak' ? 'bg-orange-600 text-white' : 'bg-white text-slate-600 border border-slate-200' }}">
                    Menunggak
                </a>
            </div>

            <div class="flex flex-col gap-3">
                @forelse($tagihan ?? [] as $item)
                    <div
                        class="bg-white rounded-xl p-4 border border-slate-100 shadow-sm hover:border-orange-200 transition-colors">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <h3 class="font-semibold text-slate-800">{{ $item->pelanggan->nama ?? '-' }}</h3>
                                <div class="flex items-center gap-1 text-slate-500 text-sm mt-0.5">
                                    <span class="material-symbols-outlined text-[16px]">location_on</span>
                                    <span class="truncate">{{ $item->pelanggan->alamat_lengkap ?? '-' }}</span>
                                </div>
                            </div>

                            @php
                                $status = $item->status ?? 'belum_bayar';
                                $statusConfig = match ($status) {
                                    'lunas' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'label' => 'Lunas'],
                                    'menunggu_verifikasi' => [
                                        'bg' => 'bg-amber-100',
                                        'text' => 'text-amber-700',
                                        'label' => 'Menunggu Admin',
                                    ],
                                    'menunggak' => [
                                        'bg' => 'bg-red-100',
                                        'text' => 'text-red-700',
                                        'label' => 'Menunggak',
                                    ],
                                    default => [
                                        'bg' => 'bg-slate-100',
                                        'text' => 'text-slate-700',
                                        'label' => 'Belum Bayar',
                                    ],
                                };
                            @endphp

                            <span
                                class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                                {{ $statusConfig['label'] }}
                            </span>
                        </div>

                        <div class="flex items-end justify-between pt-3 border-t border-slate-100">
                            <div>
                                <p class="text-xs text-slate-500 uppercase font-medium">Total Tagihan</p>
                                <p class="text-lg font-bold text-slate-800">Rp
                                    {{ number_format($item->total_tagihan ?? 0, 0, ',', '.') }}</p>
                                @if ($status === 'menunggak' && $item->tanggal_jatuh_tempo)
                                    @php
                                        $daysLate = now()->diffInDays($item->tanggal_jatuh_tempo);
                                    @endphp
                                    <p class="text-xs text-red-500 font-medium mt-0.5">Telat {{ $daysLate }} hari
                                    </p>
                                @endif
                            </div>

                            @if ($status !== 'lunas' && $status !== 'menunggu_verifikasi')
                                <a href="{{ route('petugas.input', ['tagihan_id' => $item->id]) }}"
                                    class="px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-lg hover:bg-orange-700 transition-colors">
                                    Tagih
                                </a>
                            @else
                                <div
                                    class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                                    <span class="material-symbols-outlined text-lg">arrow_forward</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl p-8 border border-slate-100 text-center">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="material-symbols-outlined text-3xl text-slate-400">receipt_long</span>
                        </div>
                        <h3 class="font-semibold text-slate-800 mb-1">Tidak ada tagihan</h3>
                        <p class="text-sm text-slate-500">Belum ada tagihan untuk ditampilkan.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</x-layouts.petugas>
