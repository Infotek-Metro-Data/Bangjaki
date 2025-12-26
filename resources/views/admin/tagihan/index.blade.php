<x-layouts.admin title="Manajemen Tagihan">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="h-full flex flex-col overflow-hidden">
        <div class="flex-1 p-4 md:p-6 lg:p-8 overflow-y-auto w-full">
            <div class="max-w-[1600px] mx-auto flex flex-col gap-6">

                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-2 text-sm">
                        <span class="text-gray-500">Dashboard</span>
                        <span class="text-gray-300">/</span>
                        <span class="text-slate-900 font-medium">Tagihan</span>
                    </div>
                    <div class="flex justify-between items-end flex-wrap gap-4">
                        <div>
                            <h2 class="text-3xl md:text-4xl font-black tracking-tight text-slate-900 mb-2">Manajemen
                                Tagihan</h2>
                            <p class="text-gray-500">Kelola tagihan bulanan dan generate invoice untuk pelanggan.</p>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('admin.export.tagihan', request()->query()) }}"
                                class="flex items-center gap-2 px-5 py-2.5 rounded-lg bg-green-500 hover:bg-green-600 text-white font-bold shadow-lg shadow-green-500/25 transition-all transform hover:-translate-y-0.5">
                                <span class="material-symbols-outlined text-[20px]">download</span>
                                Export
                            </a>
                            <button onclick="confirmGenerate()"
                                class="flex items-center gap-2 px-5 py-2.5 rounded-lg bg-orange-500 hover:bg-orange-600 text-white font-bold shadow-lg shadow-orange-500/25 transition-all transform hover:-translate-y-0.5">
                                <span class="material-symbols-outlined text-[20px]">add_circle</span>
                                Generate Tagihan
                            </button>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div
                        class="p-5 rounded-xl bg-white shadow-sm border border-gray-100 flex flex-col gap-1 hover:border-gray-300 transition-colors group">
                        <div class="flex justify-between items-start">
                            <p class="text-gray-500 text-sm font-medium">Total Tagihan</p>
                            <span
                                class="material-symbols-outlined text-blue-500 bg-blue-50 p-1 rounded-md text-[20px] group-hover:scale-110 transition-transform">receipt_long</span>
                        </div>
                        <p class="text-2xl font-bold text-slate-900 mt-2">{{ number_format($totalTagihan ?? 0) }}</p>
                        <p class="text-xs text-blue-500 mt-1 font-medium">Bulan {{ $currentMonth ?? 'ini' }}</p>
                    </div>
                    <div
                        class="p-5 rounded-xl bg-white shadow-sm border border-gray-100 flex flex-col gap-1 hover:border-gray-300 transition-colors group">
                        <div class="flex justify-between items-start">
                            <p class="text-gray-500 text-sm font-medium">Sudah Lunas</p>
                            <span
                                class="material-symbols-outlined text-green-500 bg-green-50 p-1 rounded-md text-[20px] group-hover:scale-110 transition-transform">check_circle</span>
                        </div>
                        <p class="text-2xl font-bold text-slate-900 mt-2">{{ number_format($totalLunas ?? 0) }}</p>
                        <p class="text-xs text-green-500 mt-1 font-medium">Rp
                            {{ number_format($nominalLunas ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div
                        class="p-5 rounded-xl bg-white shadow-sm border border-gray-100 flex flex-col gap-1 hover:border-gray-300 transition-colors group">
                        <div class="flex justify-between items-start">
                            <p class="text-gray-500 text-sm font-medium">Belum Bayar</p>
                            <span
                                class="material-symbols-outlined text-amber-500 bg-amber-50 p-1 rounded-md text-[20px] group-hover:scale-110 transition-transform">pending</span>
                        </div>
                        <p class="text-2xl font-bold text-slate-900 mt-2">{{ number_format($totalBelumBayar ?? 0) }}</p>
                        <p class="text-xs text-amber-500 mt-1 font-medium">Rp
                            {{ number_format($nominalBelumBayar ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div
                        class="p-5 rounded-xl bg-white shadow-sm border border-gray-100 flex flex-col gap-1 hover:border-gray-300 transition-colors group">
                        <div class="flex justify-between items-start">
                            <p class="text-gray-500 text-sm font-medium">Jatuh Tempo</p>
                            <span
                                class="material-symbols-outlined text-red-500 bg-red-50 p-1 rounded-md text-[20px] group-hover:scale-110 transition-transform">warning</span>
                        </div>
                        <p class="text-2xl font-bold text-slate-900 mt-2">{{ number_format($totalJatuhTempo ?? 0) }}</p>
                        <p class="text-xs text-red-500 mt-1 font-medium">Perlu tindakan</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                    <div
                        class="p-4 border-b border-gray-100 flex flex-col md:flex-row gap-3 justify-between items-start md:items-center">
                        <h3 class="font-bold text-slate-900">Daftar Tagihan</h3>
                        <form method="GET" class="flex flex-wrap gap-2 items-center">
                            <div class="relative">
                                <span
                                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]">search</span>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="pl-9 pr-4 py-2 rounded-lg border border-gray-200 text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent w-48"
                                    placeholder="Cari pelanggan...">
                            </div>
                            <select name="bulan"
                                class="px-3 py-2 rounded-lg border border-gray-200 text-sm focus:ring-2 focus:ring-orange-500"
                                onchange="this.form.submit()">
                                <option value="">Semua Bulan</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                            <select name="status"
                                class="px-3 py-2 rounded-lg border border-gray-200 text-sm focus:ring-2 focus:ring-orange-500"
                                onchange="this.form.submit()">
                                <option value="">Semua Status</option>
                                <option value="belum_bayar" {{ request('status') == 'belum_bayar' ? 'selected' : '' }}>
                                    Belum Bayar</option>
                                <option value="menunggu_verifikasi"
                                    {{ request('status') == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu
                                    Verifikasi</option>
                                <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas
                                </option>
                                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak
                                </option>
                            </select>
                            @if (request('search') || request('bulan') || request('status'))
                                <a href="{{ route('admin.tagihan.index') }}"
                                    class="px-3 py-2 text-sm text-red-500 hover:text-red-700">Reset</a>
                            @endif
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 border-b border-gray-100">
                                    <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Pelanggan</th>
                                    <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Periode
                                    </th>
                                    <th
                                        class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">
                                        Nominal</th>
                                    <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status
                                    </th>
                                    <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jatuh
                                        Tempo</th>
                                    <th
                                        class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($tagihan ?? [] as $t)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="p-4 text-sm text-gray-500 font-mono">
                                            #TGH-{{ str_pad($t->id, 5, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="p-4">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="h-9 w-9 rounded-full bg-orange-100 flex items-center justify-center text-orange-700 font-bold text-sm">
                                                    {{ strtoupper(substr($t->pelanggan->nama ?? 'N', 0, 2)) }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-slate-900">
                                                        {{ $t->pelanggan->nama ?? '-' }}</p>
                                                    <p class="text-xs text-gray-500">
                                                        {{ $t->pelanggan->wilayah ?? '-' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-4 text-sm text-gray-600">
                                            {{ $t->periode_mulai->format('d M') }} -
                                            {{ $t->periode_selesai->format('d M Y') }}
                                        </td>
                                        <td class="p-4 text-sm text-slate-900 font-mono font-medium text-right">
                                            Rp {{ number_format($t->jumlah_tagihan, 0, ',', '.') }}
                                        </td>
                                        <td class="p-4">
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
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                                                {{ $statusConfig['label'] }}
                                            </span>
                                        </td>
                                        <td
                                            class="p-4 text-sm {{ $t->jatuh_tempo < now() && $t->status == 'belum_bayar' ? 'text-red-600 font-medium' : 'text-gray-600' }}">
                                            {{ $t->jatuh_tempo->format('d M Y') }}
                                            @if ($t->jatuh_tempo < now() && $t->status == 'belum_bayar')
                                                <span class="block text-xs text-red-500">Terlambat</span>
                                            @endif
                                        </td>
                                        <td class="p-4 text-center">
                                            <button onclick="showDetail({{ json_encode($t) }})"
                                                class="text-gray-400 hover:text-orange-500 transition-colors p-1">
                                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="p-12 text-center">
                                            <span
                                                class="material-symbols-outlined text-[56px] text-gray-300">receipt_long</span>
                                            <p class="text-gray-500 mt-3">Belum ada data tagihan</p>
                                            <button onclick="confirmGenerate()"
                                                class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-orange-500 text-white rounded-lg text-sm font-medium hover:bg-orange-600 transition-colors">
                                                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                                                Generate Tagihan Bulan Ini
                                            </button>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if (isset($tagihan) && $tagihan->hasPages())
                        <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                            {{ $tagihan->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmGenerate() {
            const currentMonth = new Date().toLocaleDateString('id-ID', {
                month: 'long',
                year: 'numeric'
            });

            Swal.fire({
                title: 'Generate Tagihan?',
                html: `Anda akan membuat tagihan untuk <strong>semua pelanggan aktif</strong> periode <strong>${currentMonth}</strong>.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#f97316',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Generate',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Sedang generate tagihan',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch('{{ route('admin.tagihan.generate') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonColor: '#f97316'
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire('Gagal', data.message || 'Terjadi kesalahan', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
                        });
                }
            });
        }

        function showDetail(tagihan) {
            const statusBadge = {
                'lunas': '<span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Lunas</span>',
                'belum_bayar': '<span class="px-2 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">Belum Bayar</span>',
                'menunggu_verifikasi': '<span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Menunggu Verifikasi</span>',
                'ditolak': '<span class="px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Ditolak</span>'
            };

            Swal.fire({
                title: '<strong>Detail Tagihan</strong>',
                html: `
                    <div class="text-left space-y-4">
                        <div class="flex justify-between items-center pb-3 border-b">
                            <span class="text-gray-500">ID Tagihan</span>
                            <span class="font-mono font-medium">#TGH-${String(tagihan.id).padStart(5, '0')}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Pelanggan</span>
                            <span class="font-medium">${tagihan.pelanggan?.nama || '-'}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Periode</span>
                            <span class="font-medium">${new Date(tagihan.periode_mulai).toLocaleDateString('id-ID', {day: 'numeric', month: 'short'})} - ${new Date(tagihan.periode_selesai).toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'})}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Jatuh Tempo</span>
                            <span class="font-medium">${new Date(tagihan.jatuh_tempo).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})}</span>
                        </div>
                        <div class="flex justify-between items-center pt-3 border-t">
                            <span class="text-gray-500">Nominal</span>
                            <span class="text-xl font-bold text-slate-900">Rp ${Number(tagihan.jumlah_tagihan).toLocaleString('id-ID')}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Status</span>
                            ${statusBadge[tagihan.status] || tagihan.status}
                        </div>
                    </div>
                `,
                showCloseButton: true,
                showConfirmButton: false,
                width: 400
            });
        }

        @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonColor: '#f97316',
                draggable: true
            });
        @endif

        @if (session('error'))
            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonColor: '#d33'
            });
        @endif
    </script>
</x-layouts.admin>
