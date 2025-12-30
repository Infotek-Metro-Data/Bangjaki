<x-layouts.pelanggan title="Dashboard">
    <div class="max-w-6xl mx-auto space-y-6">
        <div class="bg-gradient-to-br from-sky-500 to-sky-600 rounded-2xl p-6 text-white">
            <div class="flex items-center gap-4">
                <div
                    class="h-16 w-16 rounded-full bg-white/20 flex items-center justify-center border-4 border-white/30">
                    <span class="text-white font-bold text-2xl">{{ strtoupper(substr($pelanggan->nama, 0, 2)) }}</span>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">Selamat Datang, {{ $pelanggan->nama }}!</h1>
                    <p class="text-sky-100 mt-1">ID Pelanggan: #PLG-{{ str_pad($pelanggan->id, 4, '0', STR_PAD_LEFT) }}
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-center gap-2 mb-3">
                    <span class="material-symbols-outlined text-blue-500 text-[24px]">receipt_long</span>
                    <span class="text-sm text-gray-500 font-medium">Total Tagihan</span>
                </div>
                <p class="text-3xl font-bold text-slate-900">{{ $totalTagihan }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-center gap-2 mb-3">
                    <span class="material-symbols-outlined text-green-500 text-[24px]">check_circle</span>
                    <span class="text-sm text-gray-500 font-medium">Lunas</span>
                </div>
                <p class="text-3xl font-bold text-green-600">{{ $tagihanLunas }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-center gap-2 mb-3">
                    <span class="material-symbols-outlined text-amber-500 text-[24px]">pending</span>
                    <span class="text-sm text-gray-500 font-medium">Belum Bayar</span>
                </div>
                <p class="text-3xl font-bold text-amber-600">{{ $tagihanBelumBayar }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-center gap-2 mb-3">
                    <span class="material-symbols-outlined text-sky-500 text-[24px]">hourglass_top</span>
                    <span class="text-sm text-gray-500 font-medium">Menunggu</span>
                </div>
                <p class="text-3xl font-bold text-sky-600">{{ $tagihanMenunggu }}</p>
            </div>
        </div>

        @if ($totalTunggakan > 0)
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-center gap-4">
                <span class="material-symbols-outlined text-amber-500 text-[32px]">warning</span>
                <div>
                    <p class="font-semibold text-amber-800">Anda memiliki tunggakan</p>
                    <p class="text-amber-700">Total: <span class="font-bold">Rp
                            {{ number_format($totalTunggakan, 0, ',', '.') }}</span></p>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-slate-900 flex items-center gap-2">
                    <span class="material-symbols-outlined text-gray-400 text-[20px]">receipt_long</span>
                    Tagihan Terbaru
                </h3>
                <a href="{{ route('pelanggan.tagihan') }}" class="text-sky-600 text-sm font-medium hover:underline">
                    Lihat Semua →
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Periode</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase text-right">Tagihan</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Jatuh Tempo</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($tagihanTerbaru as $t)
                            <tr class="hover:bg-gray-50/50">
                                <td class="px-4 py-3">
                                    <p class="text-sm font-medium text-slate-900">{{ $t->periode_mulai->format('M Y') }}
                                    </p>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <p class="text-sm font-mono font-medium text-slate-900">
                                        Rp {{ number_format($t->jumlah_tagihan, 0, ',', '.') }}
                                    </p>
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusConfig = match ($t->status) {
                                            'lunas' => [
                                                'bg' => 'bg-green-100',
                                                'text' => 'text-green-700',
                                                'label' => 'Lunas',
                                            ],
                                            'belum_bayar' => [
                                                'bg' => 'bg-amber-100',
                                                'text' => 'text-amber-700',
                                                'label' => 'Belum Bayar',
                                            ],
                                            'menunggu_verifikasi' => [
                                                'bg' => 'bg-blue-100',
                                                'text' => 'text-blue-700',
                                                'label' => 'Menunggu',
                                            ],
                                            default => [
                                                'bg' => 'bg-gray-100',
                                                'text' => 'text-gray-700',
                                                'label' => ucfirst($t->status),
                                            ],
                                        };
                                    @endphp
                                    <span
                                        class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                                        {{ $statusConfig['label'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-sm text-slate-600">{{ $t->jatuh_tempo->format('d M Y') }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center">
                                    <span
                                        class="material-symbols-outlined text-gray-300 text-[48px]">receipt_long</span>
                                    <p class="text-gray-500 mt-2">Belum ada tagihan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-gray-400 text-[20px]">info</span>
                Informasi Langganan
            </h3>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-gray-400 text-[20px]">payments</span>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Paket</p>
                        <p class="text-slate-900 font-medium">{{ $pelanggan->jenisPelanggan->nama_paket ?? '-' }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-gray-400 text-[20px]">attach_money</span>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Iuran Bulanan</p>
                        <p class="text-sky-600 font-bold text-lg">Rp
                            {{ number_format($pelanggan->iuran_khusus ?? ($pelanggan->jenisPelanggan->harga_dasar ?? 0), 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-gray-400 text-[20px]">location_on</span>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Wilayah</p>
                        <p class="text-slate-900">{{ $pelanggan->wilayah }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-gray-400 text-[20px]">event</span>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Terdaftar Sejak</p>
                        <p class="text-slate-900">{{ $pelanggan->tanggal_registrasi?->format('d F Y') ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.pelanggan>
