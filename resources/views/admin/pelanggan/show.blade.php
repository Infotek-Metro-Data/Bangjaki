<x-layouts.admin title="Detail Pelanggan">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="h-full flex flex-col overflow-hidden">
        <div class="flex-1 p-4 md:p-6 lg:p-8 overflow-y-auto">
            <div class="max-w-[1400px] mx-auto flex flex-col gap-6">

                <div class="flex flex-wrap gap-2 items-center text-sm">
                    <a href="{{ route('admin.dashboard') }}"
                        class="text-gray-500 hover:text-orange-500 font-medium transition-colors">Dashboard</a>
                    <span class="text-gray-300">/</span>
                    <a href="{{ route('admin.pelanggan.index') }}"
                        class="text-gray-500 hover:text-orange-500 font-medium transition-colors">Pelanggan</a>
                    <span class="text-gray-300">/</span>
                    <span class="text-slate-900 font-medium">{{ $pelanggan->nama }}</span>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                            <div class="bg-gradient-to-br from-orange-500 to-orange-600 px-6 py-8 text-center">
                                <div
                                    class="h-20 w-20 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-4 border-4 border-white/30">
                                    <span class="text-white font-bold text-2xl">
                                        {{ strtoupper(substr($pelanggan->nama, 0, 2)) }}
                                    </span>
                                </div>
                                <h2 class="text-xl font-bold text-white">{{ $pelanggan->nama }}</h2>
                                <p class="text-orange-100 text-sm mt-1">
                                    ID: #PLG-{{ str_pad($pelanggan->id, 4, '0', STR_PAD_LEFT) }}
                                </p>
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium mt-3 {{ $pelanggan->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ ucfirst($pelanggan->status) }}
                                </span>
                            </div>
                            <div class="p-6 space-y-4">
                                <div class="flex items-start gap-3">
                                    <span class="material-symbols-outlined text-gray-400 text-[20px] mt-0.5">call</span>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Telepon
                                        </p>
                                        <p class="text-slate-900 font-medium">{{ $pelanggan->telepon }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <span class="material-symbols-outlined text-gray-400 text-[20px] mt-0.5">mail</span>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Email
                                        </p>
                                        <p class="text-slate-900 font-medium">{{ $pelanggan->email ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <span
                                        class="material-symbols-outlined text-gray-400 text-[20px] mt-0.5">location_on</span>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Alamat
                                        </p>
                                        <p class="text-slate-900">{{ $pelanggan->alamat_lengkap }}</p>
                                        <p class="text-orange-600 text-sm font-medium">{{ $pelanggan->wilayah }}</p>
                                    </div>
                                </div>
                                <div class="border-t border-gray-100 pt-4">
                                    <div class="flex items-start gap-3">
                                        <span
                                            class="material-symbols-outlined text-gray-400 text-[20px] mt-0.5">payments</span>
                                        <div>
                                            <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">
                                                Paket & Iuran</p>
                                            <p class="text-slate-900 font-medium">
                                                {{ $pelanggan->jenisPelanggan->nama_paket ?? '-' }}</p>
                                            <p class="text-orange-600 font-bold text-lg">
                                                Rp
                                                {{ number_format($pelanggan->iuran_khusus ?? ($pelanggan->jenisPelanggan->harga_dasar ?? 0), 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <span
                                        class="material-symbols-outlined text-gray-400 text-[20px] mt-0.5">event</span>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">
                                            Registrasi</p>
                                        <p class="text-slate-900">
                                            {{ $pelanggan->created_at?->format('d F Y') ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="lg:col-span-2 flex flex-col gap-6">

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <span
                                        class="material-symbols-outlined text-blue-500 text-[20px]">receipt_long</span>
                                    <span class="text-xs text-gray-500 font-medium">Total Tagihan</span>
                                </div>
                                <p class="text-2xl font-bold text-slate-900">{{ $totalTagihan }}</p>
                            </div>
                            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <span
                                        class="material-symbols-outlined text-green-500 text-[20px]">check_circle</span>
                                    <span class="text-xs text-gray-500 font-medium">Lunas</span>
                                </div>
                                <p class="text-2xl font-bold text-green-600">{{ $tagihanLunas }}</p>
                            </div>
                            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="material-symbols-outlined text-amber-500 text-[20px]">pending</span>
                                    <span class="text-xs text-gray-500 font-medium">Belum Bayar</span>
                                </div>
                                <p class="text-2xl font-bold text-amber-600">{{ $tagihanBelumBayar }}</p>
                            </div>
                            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="material-symbols-outlined text-orange-500 text-[20px]">payments</span>
                                    <span class="text-xs text-gray-500 font-medium">Total Bayar</span>
                                </div>
                                <p class="text-lg font-bold text-orange-600">Rp
                                    {{ number_format($totalPembayaran, 0, ',', '.') }}</p>
                            </div>
                        </div>


                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden flex-1">
                            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                                <h3 class="font-bold text-slate-900 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-gray-400 text-[20px]">history</span>
                                    Riwayat Tagihan & Pembayaran
                                </h3>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead>
                                        <tr class="bg-gray-50/50 border-b border-gray-100">
                                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Periode
                                            </th>
                                            <th
                                                class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase text-right">
                                                Tagihan</th>
                                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status
                                            </th>
                                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">
                                                Pembayaran</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @forelse($tagihan as $t)
                                            <tr class="hover:bg-gray-50/50">
                                                <td class="px-4 py-3">
                                                    <p class="text-sm font-medium text-slate-900">
                                                        {{ $t->periode_mulai->format('M Y') }}
                                                    </p>
                                                    <p class="text-xs text-gray-500">
                                                        {{ $t->periode_mulai->format('d M') }} -
                                                        {{ $t->periode_selesai->format('d M Y') }}
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
                                                            'ditolak' => [
                                                                'bg' => 'bg-red-100',
                                                                'text' => 'text-red-700',
                                                                'label' => 'Ditolak',
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
                                                    @if ($t->pembayaran->isNotEmpty())
                                                        @php $p = $t->pembayaran->first(); @endphp
                                                        <p class="text-sm text-slate-900">
                                                            {{ $p->tanggal_bayar?->format('d M Y') }}
                                                        </p>
                                                        <p class="text-xs text-gray-500">
                                                            oleh {{ $p->petugas->nama ?? '-' }}
                                                        </p>
                                                    @else
                                                        <span class="text-xs text-gray-400">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-4 py-8 text-center">
                                                    <span
                                                        class="material-symbols-outlined text-gray-300 text-[48px]">receipt_long</span>
                                                    <p class="text-gray-500 mt-2">Belum ada riwayat tagihan</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if ($tagihan->hasPages())
                                <div class="px-4 py-3 border-t border-gray-100 bg-gray-50/50">
                                    {{ $tagihan->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
