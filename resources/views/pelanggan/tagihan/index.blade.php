<x-layouts.pelanggan title="Tagihan">
    <div class="max-w-6xl mx-auto space-y-6">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('pelanggan.tagihan') }}"
                class="bg-white rounded-xl border-2 {{ !request('status') ? 'border-sky-500 bg-sky-50' : 'border-gray-100' }} shadow-sm p-4 hover:border-sky-300 transition-colors">
                <p class="text-2xl font-bold text-slate-900">{{ $stats['total'] }}</p>
                <p class="text-sm text-gray-500">Semua</p>
            </a>
            <a href="{{ route('pelanggan.tagihan', ['status' => 'lunas']) }}"
                class="bg-white rounded-xl border-2 {{ request('status') === 'lunas' ? 'border-green-500 bg-green-50' : 'border-gray-100' }} shadow-sm p-4 hover:border-green-300 transition-colors">
                <p class="text-2xl font-bold text-green-600">{{ $stats['lunas'] }}</p>
                <p class="text-sm text-gray-500">Lunas</p>
            </a>
            <a href="{{ route('pelanggan.tagihan', ['status' => 'belum_bayar']) }}"
                class="bg-white rounded-xl border-2 {{ request('status') === 'belum_bayar' ? 'border-amber-500 bg-amber-50' : 'border-gray-100' }} shadow-sm p-4 hover:border-amber-300 transition-colors">
                <p class="text-2xl font-bold text-amber-600">{{ $stats['belum_bayar'] }}</p>
                <p class="text-sm text-gray-500">Belum Bayar</p>
            </a>
            <a href="{{ route('pelanggan.tagihan', ['status' => 'menunggu_verifikasi']) }}"
                class="bg-white rounded-xl border-2 {{ request('status') === 'menunggu_verifikasi' ? 'border-blue-500 bg-blue-50' : 'border-gray-100' }} shadow-sm p-4 hover:border-blue-300 transition-colors">
                <p class="text-2xl font-bold text-blue-600">{{ $stats['menunggu'] }}</p>
                <p class="text-sm text-gray-500">Menunggu</p>
            </a>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-slate-900 flex items-center gap-2">
                    <span class="material-symbols-outlined text-gray-400 text-[20px]">receipt_long</span>
                    Daftar Tagihan
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">ID</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Periode</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase text-right">Tagihan</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Jatuh Tempo</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($tagihan as $t)
                            <tr class="hover:bg-gray-50/50">
                                <td class="px-4 py-3">
                                    <p class="text-sm font-mono text-slate-600">
                                        #TGH-{{ str_pad($t->id, 5, '0', STR_PAD_LEFT) }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-sm font-medium text-slate-900">
                                        {{ $t->periode_mulai->format('M Y') }}</p>
                                    <p class="text-xs text-gray-500">{{ $t->periode_mulai->format('d M') }} -
                                        {{ $t->periode_selesai->format('d M Y') }}</p>
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
                                    @php $isOverdue = $t->jatuh_tempo < now() && $t->status === 'belum_bayar'; @endphp
                                    <p
                                        class="text-sm {{ $isOverdue ? 'text-red-600 font-medium' : 'text-slate-600' }}">
                                        {{ $t->jatuh_tempo->format('d M Y') }}
                                        @if ($isOverdue)
                                            <span class="text-xs">(Terlambat)</span>
                                        @endif
                                    </p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center">
                                    <span
                                        class="material-symbols-outlined text-gray-300 text-[48px]">receipt_long</span>
                                    <p class="text-gray-500 mt-2">Belum ada tagihan</p>
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
</x-layouts.pelanggan>
