<x-layouts.pelanggan title="Riwayat Pembayaran">
    <div class="max-w-6xl mx-auto space-y-6">
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white">
            <div class="flex items-center gap-4">
                <div class="h-14 w-14 rounded-full bg-white/20 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[28px]">payments</span>
                </div>
                <div>
                    <p class="text-green-100 text-sm">Total Pembayaran Disetujui</p>
                    <p class="text-3xl font-bold">Rp {{ number_format($totalDibayar, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-slate-900 flex items-center gap-2">
                    <span class="material-symbols-outlined text-gray-400 text-[20px]">history</span>
                    Riwayat Pembayaran
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Periode Tagihan</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase text-right">Jumlah</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Metode</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Petugas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($pembayaran as $p)
                            <tr class="hover:bg-gray-50/50">
                                <td class="px-4 py-3">
                                    <p class="text-sm font-medium text-slate-900">{{ $p->created_at->format('d M Y') }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $p->created_at->format('H:i') }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-sm text-slate-700">{{ $p->tagihan->periode_mulai->format('M Y') }}
                                    </p>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <p class="text-sm font-mono font-bold text-slate-900">
                                        Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}
                                    </p>
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium {{ $p->metode === 'tunai' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                        <span
                                            class="material-symbols-outlined text-[14px]">{{ $p->metode === 'tunai' ? 'wallet' : 'account_balance' }}</span>
                                        {{ ucfirst($p->metode) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusConfig = match ($p->status) {
                                            'disetujui' => [
                                                'bg' => 'bg-green-100',
                                                'text' => 'text-green-700',
                                                'label' => 'Disetujui',
                                            ],
                                            'menunggu_admin' => [
                                                'bg' => 'bg-amber-100',
                                                'text' => 'text-amber-700',
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
                                                'label' => ucfirst($p->status),
                                            ],
                                        };
                                    @endphp
                                    <span
                                        class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                                        {{ $statusConfig['label'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-sm text-slate-600">{{ $p->petugas->nama ?? '-' }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center">
                                    <span class="material-symbols-outlined text-gray-300 text-[48px]">history</span>
                                    <p class="text-gray-500 mt-2">Belum ada riwayat pembayaran</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($pembayaran->hasPages())
                <div class="px-4 py-3 border-t border-gray-100 bg-gray-50/50">
                    {{ $pembayaran->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.pelanggan>
