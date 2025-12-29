<x-layouts.admin title="Cash Settlement">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="h-full flex flex-col overflow-hidden">
        <div class="flex-1 p-4 md:p-6 lg:p-8 overflow-y-auto w-full">
            <div class="max-w-[1600px] mx-auto flex flex-col gap-6">

                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-2 text-sm">
                        <span class="text-gray-500">Dashboard</span>
                        <span class="text-gray-300">/</span>
                        <span class="text-slate-900 font-medium">Cash Settlements</span>
                    </div>
                    <div class="flex justify-between items-end flex-wrap gap-4">
                        <div>
                            <h2 class="text-3xl md:text-4xl font-black tracking-tight text-slate-900 mb-2">Cash
                                Settlement</h2>
                            <p class="text-gray-500">Rekonsiliasi dan setujui setoran tunai dari petugas lapangan.
                            </p>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('admin.settlement.history') }}"
                                class="flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors text-sm font-medium text-gray-700 hover:border-gray-300">
                                <span class="material-symbols-outlined text-[20px]">history</span>
                                Riwayat
                            </a>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div
                        class="p-5 rounded-xl bg-white shadow-sm border border-gray-100 flex flex-col gap-1 hover:border-gray-300 transition-colors group">
                        <div class="flex justify-between items-start">
                            <p class="text-gray-500 text-sm font-medium">Total Cash Pending</p>
                            <span
                                class="material-symbols-outlined text-amber-500 bg-amber-50 p-1 rounded-md text-[20px] group-hover:scale-110 transition-transform">pending</span>
                        </div>
                        <p class="text-2xl font-bold text-slate-900 mt-2">Rp
                            {{ number_format($totalPending ?? 0, 0, ',', '.') }}</p>
                        <p class="text-xs text-amber-500 mt-1 font-medium">Perlu verifikasi</p>
                    </div>
                    <div
                        class="p-5 rounded-xl bg-white shadow-sm border border-gray-100 flex flex-col gap-1 hover:border-gray-300 transition-colors group">
                        <div class="flex justify-between items-start">
                            <p class="text-gray-500 text-sm font-medium">Disetor Hari Ini</p>
                            <span
                                class="material-symbols-outlined text-green-500 bg-green-50 p-1 rounded-md text-[20px] group-hover:scale-110 transition-transform">check_circle</span>
                        </div>
                        <p class="text-2xl font-bold text-slate-900 mt-2">Rp
                            {{ number_format($settledToday ?? 0, 0, ',', '.') }}</p>
                        <p class="text-xs text-green-500 mt-1 font-medium">Total tervalidasi</p>
                    </div>
                    <div
                        class="p-5 rounded-xl bg-white shadow-sm border border-gray-100 flex flex-col gap-1 hover:border-gray-300 transition-colors group">
                        <div class="flex justify-between items-start">
                            <p class="text-gray-500 text-sm font-medium">Petugas Aktif</p>
                            <span
                                class="material-symbols-outlined text-blue-500 bg-blue-50 p-1 rounded-md text-[20px] group-hover:scale-110 transition-transform">group</span>
                        </div>
                        <p class="text-2xl font-bold text-slate-900 mt-2">{{ $activeAgents ?? 0 }}</p>
                        <p class="text-xs text-blue-500 mt-1">Membawa uang cash</p>
                    </div>
                </div>

                <div class="flex flex-col lg:flex-row gap-6 h-full min-h-[600px]">
                    <div class="w-full lg:w-4/12 flex flex-col gap-4">
                        <div class="flex gap-2">
                            <div class="relative flex-1 group">
                                <span
                                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-orange-500 transition-colors text-[20px]">search</span>
                                <input
                                    class="w-full pl-10 pr-4 py-2.5 rounded-lg bg-white border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 text-slate-900 placeholder:text-gray-400"
                                    placeholder="Cari petugas..." type="text" />
                            </div>
                            <button
                                class="px-3 rounded-lg bg-white border border-gray-200 text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-colors">
                                <span class="material-symbols-outlined text-[20px]">filter_list</span>
                            </button>
                        </div>

                        <div class="flex flex-col gap-3 overflow-y-auto pr-1 pb-4 max-h-[600px]">
                            @forelse($petugasList as $petugas)
                                <a href="{{ route('admin.settlement.show', $petugas->id) }}" class="block">
                                    <div
                                        class="p-4 rounded-xl {{ isset($selectedPetugas) && $selectedPetugas->id == $petugas->id ? 'bg-orange-50 border-2 border-orange-500 shadow-md' : 'bg-white border border-gray-100 hover:border-gray-300 hover:shadow-sm' }} cursor-pointer relative transition-all group">
                                        <div class="absolute top-4 right-4 flex flex-col items-end">
                                            <span class="text-sm font-bold text-slate-900">Rp
                                                {{ number_format($petugas->pending_amount, 0, ',', '.') }}</span>
                                            @if ($petugas->pending_amount > 0)
                                                <span
                                                    class="text-[10px] font-bold uppercase tracking-wider text-amber-600 bg-amber-100 px-2 py-0.5 rounded-full mt-1">Pending</span>
                                            @else
                                                <span
                                                    class="text-[10px] font-bold uppercase tracking-wider text-green-600 bg-green-100 px-2 py-0.5 rounded-full mt-1">Settled</span>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-bold text-sm border border-orange-200">
                                                {{ strtoupper(substr($petugas->nama, 0, 2)) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-slate-900">{{ $petugas->nama }}</p>
                                                <p class="text-xs text-gray-500">ID:
                                                    #PTG-{{ str_pad($petugas->id, 3, '0', STR_PAD_LEFT) }}</p>
                                            </div>
                                        </div>
                                        @if (isset($selectedPetugas) && $selectedPetugas->id == $petugas->id)
                                            <div
                                                class="mt-3 pt-3 border-t border-orange-200 flex justify-between items-center text-xs text-orange-600">
                                                <span>{{ $petugas->email }}</span>
                                                <span class="font-medium text-orange-700 flex items-center gap-1">
                                                    <span
                                                        class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                                                    Sedang dilihat
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                            @empty
                                <div class="p-8 text-center text-emerald-400">
                                    <span class="material-symbols-outlined text-[48px]">person_off</span>
                                    <p class="mt-2 text-sm">Tidak ada petugas</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div
                        class="flex-1 bg-white rounded-xl border border-gray-100 flex flex-col shadow-sm overflow-hidden h-fit min-h-[500px]">
                        @if (isset($selectedPetugas))
                            <div class="p-6 border-b border-gray-100 flex justify-between items-start bg-gray-50/50">
                                <div class="flex gap-4">
                                    <div
                                        class="w-14 h-14 rounded-full bg-orange-500 text-white flex items-center justify-center text-xl font-bold shadow-lg shadow-orange-500/30">
                                        {{ strtoupper(substr($selectedPetugas->nama, 0, 2)) }}
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-slate-900">{{ $selectedPetugas->nama }}
                                        </h3>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span
                                                class="text-xs font-medium px-2 py-0.5 rounded bg-gray-100 text-gray-600">ID:
                                                #PTG-{{ str_pad($selectedPetugas->id, 3, '0', STR_PAD_LEFT) }}</span>
                                            <span
                                                class="text-xs font-medium px-2 py-0.5 rounded bg-gray-100 text-gray-600">{{ $selectedPetugas->telepon }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-500 mb-1">Total Sistem</p>
                                    <p id="systemTotal" class="text-3xl font-black text-slate-900 tracking-tight"
                                        data-value="{{ $selectedPetugas->pending_amount }}">Rp
                                        {{ number_format($selectedPetugas->pending_amount, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <div class="flex-1 flex flex-col min-h-0">
                                <div class="flex-1 p-0 overflow-hidden flex flex-col">
                                    <div
                                        class="px-6 py-3 bg-gray-50/80 border-b border-gray-100 flex items-center justify-between">
                                        <h4 class="text-sm font-bold text-slate-700">Transaksi
                                            ({{ $transactions->count() }})</h4>
                                        <button
                                            class="text-xs text-orange-500 font-medium hover:underline hover:text-orange-600 transition-colors">Download
                                            Log</button>
                                    </div>
                                    <div class="overflow-y-auto max-h-[300px]">
                                        <table class="w-full text-left border-collapse">
                                            <thead class="sticky top-0 bg-white z-10 shadow-sm">
                                                <tr class="text-xs text-gray-400 border-b border-gray-100">
                                                    <th class="px-6 py-3 font-medium">Waktu</th>
                                                    <th class="px-6 py-3 font-medium">Pelanggan</th>
                                                    <th class="px-6 py-3 font-medium">Ref ID</th>
                                                    <th class="px-6 py-3 font-medium text-right">Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-sm">
                                                @forelse($transactions as $trx)
                                                    <tr
                                                        class="border-b border-gray-50 hover:bg-gray-50 transition-colors group">
                                                        <td class="px-6 py-3 text-gray-500">
                                                            {{ $trx->created_at->format('H:i') }}</td>
                                                        <td class="px-6 py-3 text-slate-900 font-medium">
                                                            {{ $trx->tagihan->pelanggan->nama ?? 'N/A' }}</td>
                                                        <td class="px-6 py-3 text-gray-400 font-mono text-xs">
                                                            #TRX-{{ $trx->id }}</td>
                                                        <td
                                                            class="px-6 py-3 text-right text-slate-900 font-mono font-medium">
                                                            Rp {{ number_format($trx->jumlah_bayar, 0, ',', '.') }}
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4"
                                                            class="px-6 py-8 text-center text-gray-400 text-sm">Tidak
                                                            ada transaksi pending</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="p-6 bg-gray-50 border-t border-gray-100 mt-auto">
                                    <form id="settlementForm"
                                        action="{{ route('admin.settlement.confirm', $selectedPetugas->id) }}"
                                        method="POST">
                                        @csrf
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                            <div>
                                                <label
                                                    class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Uang
                                                    Fisik Diterima</label>
                                                <div class="relative group">
                                                    <span
                                                        class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-bold group-focus-within:text-orange-500">Rp</span>
                                                    <input id="inputNominal" name="nominal_diterima"
                                                        class="w-full pl-10 pr-4 py-3 rounded-lg bg-white border border-gray-300 text-lg font-bold text-slate-900 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all shadow-sm group-hover:border-orange-500"
                                                        type="text" placeholder="0" required
                                                        onkeyup="calculateVariance()" />
                                                </div>
                                                <p class="text-xs text-gray-500 mt-2">Masukkan total uang fisik yang
                                                    diterima dari petugas.</p>
                                            </div>
                                            <div
                                                class="flex flex-col justify-center bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                                <div class="flex justify-between items-center mb-2">
                                                    <span class="text-sm font-medium text-gray-600">Total
                                                        Sistem</span>
                                                    <span class="text-sm font-mono font-bold text-slate-900">Rp
                                                        {{ number_format($selectedPetugas->pending_amount, 0, ',', '.') }}</span>
                                                </div>
                                                <div class="flex justify-between items-center mb-3">
                                                    <span class="text-sm font-medium text-gray-600">Dihitung</span>
                                                    <span id="displayCounted"
                                                        class="text-sm font-mono font-bold text-slate-900">Rp
                                                        0</span>
                                                </div>
                                                <div
                                                    class="border-t border-gray-100 pt-3 flex justify-between items-center">
                                                    <span class="text-sm font-bold text-slate-900">Selisih</span>
                                                    <span id="varianceDisplay"
                                                        class="text-lg font-mono font-bold text-green-500 flex items-center gap-1 transition-colors">
                                                        <span
                                                            class="material-symbols-outlined text-[18px]">check_circle</span>
                                                        Rp 0
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-6 flex gap-3 justify-end">
                                            <button type="button"
                                                class="px-6 py-2.5 rounded-lg border border-red-200 text-red-600 font-medium hover:bg-red-50 transition-colors">
                                                Lapor Selisih
                                            </button>
                                            <button type="button" onclick="confirmSettlement()"
                                                class="px-6 py-2.5 rounded-lg bg-orange-500 hover:bg-orange-600 text-white font-bold shadow-lg shadow-orange-500/20 transition-all flex items-center gap-2 transform hover:-translate-y-0.5">
                                                <span class="material-symbols-outlined text-[20px]">verified</span>
                                                Konfirmasi Setoran
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div
                                class="flex-1 flex flex-col items-center justify-center text-center p-8 text-gray-400">
                                <div class="bg-gray-50 p-6 rounded-full mb-4">
                                    <span class="material-symbols-outlined text-[64px]">payments</span>
                                </div>
                                <h3 class="text-xl font-bold text-slate-900">Pilih Petugas</h3>
                                <p class="text-gray-500 max-w-sm mt-2">Pilih petugas dari daftar di sebelah kiri
                                    untuk melihat detail transaksi dan melakukan settlement.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const systemTotal = {{ $selectedPetugas->pending_amount ?? 0 }};

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID').format(angka);
        }

        function calculateVariance() {
            const input = document.getElementById('inputNominal');
            let value = input.value.replace(/\D/g, '');


            if (value) {
                input.value = formatRupiah(value);
            }

            const counted = parseInt(value || 0);
            const variance = counted - systemTotal;


            document.getElementById('displayCounted').innerText = 'Rp ' + formatRupiah(counted);

            const varianceEl = document.getElementById('varianceDisplay');
            varianceEl.innerHTML = (variance === 0 ?
                `<span class="material-symbols-outlined text-[18px]">check_circle</span> Rp 0` :
                (variance > 0 ? '+' : '') + 'Rp ' + formatRupiah(variance));

            if (variance === 0) {
                varianceEl.className =
                    'text-lg font-mono font-bold text-green-500 flex items-center gap-1 transition-colors';
            } else if (variance < 0) {
                varianceEl.className = 'text-lg font-mono font-bold text-red-500 flex items-center gap-1 transition-colors';
            } else {
                varianceEl.className =
                    'text-lg font-mono font-bold text-blue-500 flex items-center gap-1 transition-colors';
            }
        }

        function confirmSettlement() {
            const input = document.getElementById('inputNominal');
            const value = parseInt(input.value.replace(/\D/g, '') || 0);

            if (value <= 0) {
                Swal.fire({
                    title: 'Verifikasi Nominal',
                    text: 'Masukkan jumlah uang fisik yang diterima.',
                    icon: 'warning',
                    confirmButtonColor: '#f97316'
                });
                return;
            }

            const variance = value - systemTotal;

            let warningText = 'Konfirmasi setoran ini?';
            let icon = 'question';

            if (variance !== 0) {
                warningText = `Terdapat selisih Rp ${formatRupiah(variance)}. Tetap lanjutkan?`;
                icon = 'warning';
            }

            Swal.fire({
                title: 'Konfirmasi Settlement',
                text: warningText,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: '#f97316',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Konfirmasi',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {

                    const form = document.getElementById('settlementForm');
                    const formData = new FormData(form);

                    fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Settlement telah dikonfirmasi.',
                                    icon: 'success',
                                    confirmButtonColor: '#f97316'
                                }).then(() => {
                                    window.location.href = data.redirect;
                                });
                            } else {
                                Swal.fire('Error', data.message || 'Terjadi kesalahan.', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            form.submit();
                        });
                }
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
    </script>
</x-layouts.admin>
