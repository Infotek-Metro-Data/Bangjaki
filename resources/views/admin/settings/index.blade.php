<x-layouts.admin title="Pengaturan">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="h-full flex flex-col overflow-hidden">
        <div class="flex-1 p-4 md:p-6 lg:p-8 overflow-y-auto w-full">
            <div class="max-w-[1200px] mx-auto flex flex-col gap-6">

                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-2 text-sm">
                        <span class="text-gray-500">Dashboard</span>
                        <span class="text-gray-300">/</span>
                        <span class="text-slate-900 font-medium">Pengaturan</span>
                    </div>
                    <div>
                        <h2 class="text-3xl md:text-4xl font-black tracking-tight text-slate-900 mb-2">Pengaturan</h2>
                        <p class="text-gray-500">Kelola tarif iuran dan wilayah layanan.</p>
                    </div>
                </div>

                <div x-data="{ activeTab: 'tarif' }"
                    class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="border-b border-gray-100">
                        <nav class="flex gap-0">
                            <button @click="activeTab = 'tarif'"
                                :class="activeTab === 'tarif' ?
                                    'text-orange-600 border-b-2 border-orange-500 bg-orange-50/50' :
                                    'text-gray-500 hover:text-gray-700 hover:bg-gray-50'"
                                class="px-6 py-4 text-sm font-semibold transition-all flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">sell</span>
                                Tarif Iuran
                            </button>
                            <button @click="activeTab = 'wilayah'"
                                :class="activeTab === 'wilayah' ?
                                    'text-orange-600 border-b-2 border-orange-500 bg-orange-50/50' :
                                    'text-gray-500 hover:text-gray-700 hover:bg-gray-50'"
                                class="px-6 py-4 text-sm font-semibold transition-all flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">location_on</span>
                                Wilayah
                            </button>
                        </nav>
                    </div>

                    <div x-show="activeTab === 'tarif'" x-cloak>
                        <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="font-bold text-slate-900">Daftar Tarif</h3>
                            <button onclick="openTarifModal()"
                                class="flex items-center gap-2 px-4 py-2 rounded-lg bg-orange-500 hover:bg-orange-600 text-white font-medium shadow-lg shadow-orange-500/25 transition-all text-sm">
                                <span class="material-symbols-outlined text-[18px]">add</span>
                                Tambah Tarif
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50/50 border-b border-gray-100">
                                        <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Nama Paket</th>
                                        <th
                                            class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">
                                            Harga Dasar</th>
                                        <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Deskripsi</th>
                                        <th
                                            class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">
                                            Pelanggan</th>
                                        <th
                                            class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($tarifList as $tarif)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="p-4">
                                                <span
                                                    class="text-sm font-medium text-slate-900">{{ $tarif->nama_paket }}</span>
                                            </td>
                                            <td class="p-4 text-right">
                                                <span class="text-sm font-mono font-medium text-slate-900">Rp
                                                    {{ number_format($tarif->harga_dasar, 0, ',', '.') }}</span>
                                            </td>
                                            <td class="p-4">
                                                <span
                                                    class="text-sm text-gray-500">{{ $tarif->deskripsi ?? '-' }}</span>
                                            </td>
                                            <td class="p-4 text-center">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                                    {{ $tarif->pelanggan_count }}
                                                </span>
                                            </td>
                                            <td class="p-4 text-center">
                                                <div class="flex items-center justify-center gap-1">
                                                    <button onclick="editTarif({{ json_encode($tarif) }})"
                                                        class="text-gray-400 hover:text-orange-500 transition-colors p-1">
                                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                                    </button>
                                                    <form
                                                        action="{{ route('admin.settings.tarif.destroy', $tarif->id) }}"
                                                        method="POST" class="inline"
                                                        onsubmit="return confirmDeleteTarif(event, '{{ $tarif->nama_paket }}', {{ $tarif->pelanggan_count }})">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-gray-400 hover:text-red-500 transition-colors p-1">
                                                            <span
                                                                class="material-symbols-outlined text-[18px]">delete</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="p-12 text-center">
                                                <span
                                                    class="material-symbols-outlined text-[56px] text-gray-300">sell</span>
                                                <p class="text-gray-500 mt-3">Belum ada tarif</p>
                                                <button onclick="openTarifModal()"
                                                    class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-orange-500 text-white rounded-lg text-sm font-medium hover:bg-orange-600 transition-colors">
                                                    <span class="material-symbols-outlined text-[18px]">add</span>
                                                    Tambah Tarif Pertama
                                                </button>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div x-show="activeTab === 'wilayah'" x-cloak>
                        <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                            <div>
                                <h3 class="font-bold text-slate-900">Daftar Wilayah</h3>
                                <p class="text-sm text-gray-500 mt-1">Kelola wilayah layanan untuk pelanggan.</p>
                            </div>
                            <button onclick="openWilayahModal()"
                                class="flex items-center gap-2 px-4 py-2 rounded-lg bg-orange-500 hover:bg-orange-600 text-white font-medium shadow-lg shadow-orange-500/25 transition-all text-sm">
                                <span class="material-symbols-outlined text-[18px]">add</span>
                                Tambah Wilayah
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50/50 border-b border-gray-100">
                                        <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Nama Wilayah</th>
                                        <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Deskripsi</th>
                                        <th
                                            class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">
                                            Pelanggan</th>
                                        <th
                                            class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($wilayahList as $wilayah)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="p-4">
                                                <div class="flex items-center gap-3">
                                                    <span
                                                        class="material-symbols-outlined text-orange-500 text-[20px]">location_on</span>
                                                    <span
                                                        class="text-sm font-medium text-slate-900">{{ $wilayah->nama }}</span>
                                                </div>
                                            </td>
                                            <td class="p-4">
                                                <span
                                                    class="text-sm text-gray-500">{{ $wilayah->deskripsi ?? '-' }}</span>
                                            </td>
                                            <td class="p-4 text-center">
                                                @php
                                                    $pelangganCount = \App\Models\Pelanggan::where(
                                                        'wilayah',
                                                        $wilayah->nama,
                                                    )->count();
                                                @endphp
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                    {{ $pelangganCount }}
                                                </span>
                                            </td>
                                            <td class="p-4 text-center">
                                                <div class="flex items-center justify-center gap-1">
                                                    <button onclick="editWilayah({{ json_encode($wilayah) }})"
                                                        class="text-gray-400 hover:text-orange-500 transition-colors p-1">
                                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                                    </button>
                                                    <form
                                                        action="{{ route('admin.settings.wilayah.destroy', $wilayah->id) }}"
                                                        method="POST" class="inline"
                                                        onsubmit="return confirmDeleteWilayah(event, '{{ $wilayah->nama }}', {{ $pelangganCount }})">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-gray-400 hover:text-red-500 transition-colors p-1">
                                                            <span
                                                                class="material-symbols-outlined text-[18px]">delete</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="p-12 text-center">
                                                <span
                                                    class="material-symbols-outlined text-[56px] text-gray-300">location_off</span>
                                                <p class="text-gray-500 mt-3">Belum ada wilayah</p>
                                                <button onclick="openWilayahModal()"
                                                    class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-orange-500 text-white rounded-lg text-sm font-medium hover:bg-orange-600 transition-colors">
                                                    <span class="material-symbols-outlined text-[18px]">add</span>
                                                    Tambah Wilayah Pertama
                                                </button>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="tarifModal" class="fixed inset-0 bg-black/40 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
            <div class="p-6 border-b border-gray-100">
                <h3 id="tarifModalTitle" class="text-lg font-bold text-slate-900">Tambah Tarif</h3>
            </div>
            <form id="tarifForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="tarifFormMethod" value="POST">

                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Paket</label>
                        <input type="text" name="nama_paket" id="tarif_nama_paket" required
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm"
                            placeholder="Contoh: Rumah Tangga">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Dasar</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">Rp</span>
                            <input type="number" name="harga_dasar" id="tarif_harga_dasar" required min="0"
                                class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm"
                                placeholder="50000">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (Opsional)</label>
                        <textarea name="deskripsi" id="tarif_deskripsi" rows="3"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm"
                            placeholder="Keterangan tentang paket ini..."></textarea>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-100 flex gap-3 justify-end">
                    <button type="button" onclick="closeTarifModal()"
                        class="px-4 py-2.5 rounded-lg border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 transition-colors text-sm">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2.5 rounded-lg bg-orange-500 text-white font-medium hover:bg-orange-600 shadow-lg shadow-orange-500/25 transition-all text-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="wilayahModal" class="fixed inset-0 bg-black/40 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
            <div class="p-6 border-b border-gray-100">
                <h3 id="wilayahModalTitle" class="text-lg font-bold text-slate-900">Tambah Wilayah</h3>
            </div>
            <form id="wilayahForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="wilayahFormMethod" value="POST">

                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Wilayah</label>
                        <input type="text" name="nama" id="wilayah_nama" required
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm"
                            placeholder="Contoh: RT 01 RW 05">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (Opsional)</label>
                        <textarea name="deskripsi" id="wilayah_deskripsi" rows="3"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm"
                            placeholder="Keterangan tentang wilayah ini..."></textarea>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-100 flex gap-3 justify-end">
                    <button type="button" onclick="closeWilayahModal()"
                        class="px-4 py-2.5 rounded-lg border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 transition-colors text-sm">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2.5 rounded-lg bg-orange-500 text-white font-medium hover:bg-orange-600 shadow-lg shadow-orange-500/25 transition-all text-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openTarifModal() {
            document.getElementById('tarifModalTitle').textContent = 'Tambah Tarif';
            document.getElementById('tarifForm').action = '{{ route('admin.settings.tarif.store') }}';
            document.getElementById('tarifFormMethod').value = 'POST';
            document.getElementById('tarif_nama_paket').value = '';
            document.getElementById('tarif_harga_dasar').value = '';
            document.getElementById('tarif_deskripsi').value = '';

            const modal = document.getElementById('tarifModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function editTarif(tarif) {
            document.getElementById('tarifModalTitle').textContent = 'Edit Tarif';
            document.getElementById('tarifForm').action = '/admin/settings/tarif/' + tarif.id;
            document.getElementById('tarifFormMethod').value = 'PUT';
            document.getElementById('tarif_nama_paket').value = tarif.nama_paket;
            document.getElementById('tarif_harga_dasar').value = tarif.harga_dasar;
            document.getElementById('tarif_deskripsi').value = tarif.deskripsi || '';

            const modal = document.getElementById('tarifModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeTarifModal() {
            const modal = document.getElementById('tarifModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function openWilayahModal() {
            document.getElementById('wilayahModalTitle').textContent = 'Tambah Wilayah';
            document.getElementById('wilayahForm').action = '{{ route('admin.settings.wilayah.store') }}';
            document.getElementById('wilayahFormMethod').value = 'POST';
            document.getElementById('wilayah_nama').value = '';
            document.getElementById('wilayah_deskripsi').value = '';

            const modal = document.getElementById('wilayahModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function editWilayah(wilayah) {
            document.getElementById('wilayahModalTitle').textContent = 'Edit Wilayah';
            document.getElementById('wilayahForm').action = '/admin/settings/wilayah/' + wilayah.id;
            document.getElementById('wilayahFormMethod').value = 'PUT';
            document.getElementById('wilayah_nama').value = wilayah.nama;
            document.getElementById('wilayah_deskripsi').value = wilayah.deskripsi || '';

            const modal = document.getElementById('wilayahModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeWilayahModal() {
            const modal = document.getElementById('wilayahModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function confirmDeleteTarif(event, namaPaket, pelangganCount) {
            event.preventDefault();

            if (pelangganCount > 0) {
                Swal.fire({
                    title: 'Tidak Dapat Menghapus',
                    text: `Tarif "${namaPaket}" masih digunakan oleh ${pelangganCount} pelanggan.`,
                    icon: 'warning',
                    confirmButtonColor: '#f97316'
                });
                return false;
            }

            Swal.fire({
                title: 'Hapus Tarif?',
                text: `Anda yakin ingin menghapus tarif "${namaPaket}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit();
                }
            });
            return false;
        }

        function confirmDeleteWilayah(event, namaWilayah, pelangganCount) {
            event.preventDefault();

            if (pelangganCount > 0) {
                Swal.fire({
                    title: 'Tidak Dapat Menghapus',
                    text: `Wilayah "${namaWilayah}" masih digunakan oleh ${pelangganCount} pelanggan.`,
                    icon: 'warning',
                    confirmButtonColor: '#f97316'
                });
                return false;
            }

            Swal.fire({
                title: 'Hapus Wilayah?',
                text: `Anda yakin ingin menghapus wilayah "${namaWilayah}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit();
                }
            });
            return false;
        }

        document.getElementById('tarifModal').addEventListener('click', function(e) {
            if (e.target === this) closeTarifModal();
        });

        document.getElementById('wilayahModal').addEventListener('click', function(e) {
            if (e.target === this) closeWilayahModal();
        });

        @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonColor: '#f97316'
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

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</x-layouts.admin>
