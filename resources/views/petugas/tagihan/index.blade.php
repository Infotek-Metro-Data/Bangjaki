<x-layouts.petugas title="Daftar Tagihan">
    <div class="px-4 py-5">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-xl font-bold text-slate-800">Daftar Tagihan</h1>
                @if ($wilayahPetugas ?? false)
                    <p class="text-sm text-orange-600 font-medium flex items-center gap-1 mt-1">
                        <span class="material-symbols-outlined text-[16px]">location_on</span>
                        Wilayah: {{ $wilayahPetugas }}
                    </p>
                @else
                    <p class="text-sm text-slate-500 mt-1">Semua Wilayah</p>
                @endif
            </div>
        </div>


        <form method="GET" action="{{ route('petugas.tagihan') }}" class="mb-4">
            <div class="relative">
                <span
                    class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-xl">search</span>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama, alamat, atau telepon..."
                    class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                @if (request('filter'))
                    <input type="hidden" name="filter" value="{{ request('filter') }}">
                @endif
            </div>
        </form>


        <div class="flex gap-2 mb-4 overflow-x-auto hide-scrollbar pb-1">
            <a href="{{ route('petugas.tagihan', ['search' => request('search')]) }}"
                class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition-colors {{ !request('filter') ? 'bg-orange-600 text-white' : 'bg-white text-slate-600 border border-slate-200' }}">
                Semua
            </a>
            <a href="{{ route('petugas.tagihan', ['filter' => 'jatuh_tempo', 'search' => request('search')]) }}"
                class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition-colors {{ request('filter') === 'jatuh_tempo' ? 'bg-orange-600 text-white' : 'bg-white text-slate-600 border border-slate-200' }}">
                Jatuh Tempo
            </a>
            <a href="{{ route('petugas.tagihan', ['filter' => 'menunggak', 'search' => request('search')]) }}"
                class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition-colors {{ request('filter') === 'menunggak' ? 'bg-orange-600 text-white' : 'bg-white text-slate-600 border border-slate-200' }}">
                Menunggak
            </a>
        </div>

        @if (request('search'))
            <div class="mb-4 flex items-center justify-between bg-orange-50 rounded-lg px-3 py-2">
                <span class="text-sm text-orange-800">Hasil pencarian: "{{ request('search') }}"</span>
                <a href="{{ route('petugas.tagihan', ['filter' => request('filter')]) }}"
                    class="text-orange-600 hover:text-orange-700 text-sm font-medium">
                    Hapus
                </a>
            </div>
        @endif

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
                            <div class="flex items-center gap-1 text-slate-400 text-xs mt-1">
                                <span class="material-symbols-outlined text-[14px]">call</span>
                                <span>{{ $item->pelanggan->telepon ?? '-' }}</span>
                            </div>
                        </div>

                        @php
                            $isOverdue = $item->jatuh_tempo < now() && $item->status === 'belum_bayar';
                        @endphp
                        @if ($isOverdue)
                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                Menunggak
                            </span>
                        @endif
                    </div>

                    <div class="flex items-end justify-between pt-3 border-t border-slate-100">
                        <div>
                            <p class="text-xs text-slate-500 uppercase font-medium">Total Tagihan</p>
                            <p class="text-lg font-bold text-slate-800">Rp
                                {{ number_format($item->jumlah_tagihan ?? 0, 0, ',', '.') }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">
                                Jatuh tempo: {{ $item->jatuh_tempo?->format('d M Y') }}
                            </p>
                        </div>

                        <a href="{{ route('petugas.input', ['tagihan_id' => $item->id]) }}"
                            class="px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-lg hover:bg-orange-700 transition-colors flex items-center gap-1">
                            <span class="material-symbols-outlined text-[18px]">payments</span>
                            Tagih
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl p-8 border border-slate-100 text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-3xl text-slate-400">receipt_long</span>
                    </div>
                    <h3 class="font-semibold text-slate-800 mb-1">Tidak ada tagihan</h3>
                    <p class="text-sm text-slate-500">
                        @if (request('search'))
                            Tidak ditemukan tagihan dengan kata kunci tersebut.
                        @else
                            Belum ada tagihan untuk ditampilkan.
                        @endif
                    </p>
                </div>
            @endforelse
        </div>

        @if (isset($tagihan) && $tagihan->hasPages())
            <div class="mt-6">
                {{ $tagihan->links() }}
            </div>
        @endif
    </div>
</x-layouts.petugas>
