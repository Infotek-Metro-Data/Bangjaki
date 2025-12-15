<x-layouts.admin title="Pelanggan">
    <x-slot name="slideOver">
        <div class="flex items-center justify-between p-4 md:p-6 border-b border-emerald-100 sticky top-0 bg-white/95 backdrop-blur z-10">
            <h2 class="text-emerald-900 text-lg font-bold">Tambah Pelanggan Baru</h2>
            <button onclick="closeSlideOver()" class="text-emerald-500 hover:text-emerald-700 transition-colors p-1">
                <span class="material-symbols-outlined text-[24px]">close</span>
            </button>
        </div>
        <form id="formTambahPelanggan" method="POST" action="{{ route('admin.pelanggan.store') }}" class="flex flex-col flex-1">
            @csrf
            <div class="p-4 md:p-6 flex flex-col gap-6 flex-1 overflow-y-auto">
                <div class="flex flex-col gap-4">
                    <h3 class="text-emerald-900 text-sm font-bold border-b border-emerald-100 pb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-600 text-[18px]">person</span>
                        Data Pribadi
                    </h3>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-medium text-emerald-700">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" required class="w-full rounded-lg border border-emerald-200 bg-white text-emerald-900 text-sm px-3 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-transparent placeholder:text-emerald-400" placeholder="Masukkan nama lengkap">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-medium text-emerald-700">Telepon <span class="text-red-500">*</span></label>
                            <input type="tel" name="telepon" required class="w-full rounded-lg border border-emerald-200 bg-white text-emerald-900 text-sm px-3 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-transparent placeholder:text-emerald-400" placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-medium text-emerald-700">Email</label>
                            <input type="email" name="email" class="w-full rounded-lg border border-emerald-200 bg-white text-emerald-900 text-sm px-3 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-transparent placeholder:text-emerald-400" placeholder="email@contoh.com">
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <h3 class="text-emerald-900 text-sm font-bold border-b border-emerald-100 pb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-600 text-[18px]">location_on</span>
                        Alamat
                    </h3>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-medium text-emerald-700">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="alamat_lengkap" required rows="2" class="w-full rounded-lg border border-emerald-200 bg-white text-emerald-900 text-sm px-3 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-transparent placeholder:text-emerald-400 resize-none" placeholder="Jl. Contoh No. 123, RT/RW"></textarea>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-medium text-emerald-700">Wilayah <span class="text-red-500">*</span></label>
                        <select name="wilayah" required class="w-full rounded-lg border border-emerald-200 bg-white text-emerald-900 text-sm px-3 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            <option value="">Pilih Wilayah</option>
                            <option value="Wilayah A">Wilayah A</option>
                            <option value="Wilayah B">Wilayah B</option>
                            <option value="Wilayah C">Wilayah C</option>
                        </select>
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <h3 class="text-emerald-900 text-sm font-bold border-b border-emerald-100 pb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-600 text-[18px]">payments</span>
                        Paket & Iuran
                    </h3>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-medium text-emerald-700">Jenis Pelanggan <span class="text-red-500">*</span></label>
                        <select name="jenis_pelanggan_id" class="w-full rounded-lg border border-emerald-200 bg-white text-emerald-900 text-sm px-3 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            <option value="">Pilih Paket</option>
                            @foreach($jenisPelanggan ?? [] as $id => $nama)
                                <option value="{{ $id }}">{{ $nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-medium text-emerald-700">Tgl Registrasi <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_registrasi" value="{{ date('Y-m-d') }}" required class="w-full rounded-lg border border-emerald-200 bg-white text-emerald-900 text-sm px-3 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-medium text-emerald-700">Iuran Khusus</label>
                            <input type="number" name="iuran_khusus" class="w-full rounded-lg border border-emerald-200 bg-white text-emerald-900 text-sm px-3 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-transparent placeholder:text-emerald-400" placeholder="Opsional">
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4 md:p-6 border-t border-emerald-100 bg-emerald-50 sticky bottom-0 z-10">
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-semibold h-10 text-sm transition-colors shadow-sm flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        Simpan
                    </button>
                    <button type="button" onclick="closeSlideOver()" class="px-4 rounded-lg border border-emerald-200 hover:bg-emerald-100 text-emerald-700 font-semibold h-10 text-sm transition-colors">
                        Batal
                    </button>
                </div>
            </div>
        </form>
    </x-slot>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="h-full flex flex-col">
        <div class="flex-1 p-4 md:p-6 lg:p-8 overflow-y-auto">
            <div class="max-w-[1400px] mx-auto flex flex-col gap-4 md:gap-6">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 border-b border-emerald-100 pb-4 md:pb-6">
                    <div class="flex flex-col gap-1">
                        <h1 class="text-emerald-900 text-xl md:text-2xl font-bold leading-tight">Data Pelanggan</h1>
                        <p class="text-emerald-600 text-sm">Kelola data pelanggan dan tagihan iuran sampah.</p>
                    </div>
                    <div class="flex gap-2 md:gap-3">
                        <button class="flex items-center justify-center gap-2 rounded-lg h-9 md:h-10 px-3 md:px-4 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 text-sm font-semibold transition-colors">
                            <span class="material-symbols-outlined text-[18px]">upload</span>
                            <span class="hidden sm:inline">Import</span>
                        </button>
                        <button onclick="openSlideOver()" class="flex items-center justify-center gap-2 rounded-lg h-9 md:h-10 px-3 md:px-4 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold shadow-sm transition-all">
                            <span class="material-symbols-outlined text-[18px]">add</span>
                            <span class="hidden sm:inline">Tambah Pelanggan</span>
                        </button>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-3 md:gap-4 items-stretch md:items-center justify-between">
                    <div class="w-full md:w-96 relative group">
                        <form method="GET" action="{{ route('admin.pelanggan.index') }}">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-outlined text-emerald-400 group-focus-within:text-emerald-600 transition-colors text-[20px]">search</span>
                            </div>
                            <input 
                                type="text" 
                                name="search"
                                value="{{ request('search') }}"
                                class="block w-full rounded-lg border border-emerald-200 bg-white pl-10 pr-3 py-2.5 text-emerald-900 placeholder-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm"
                                placeholder="Cari nama, alamat, atau telepon..."
                            >
                        </form>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button class="flex h-9 items-center justify-center gap-x-2 rounded-lg bg-emerald-50 border border-emerald-200 hover:border-emerald-300 px-3 transition-colors">
                            <span class="text-emerald-800 text-xs font-medium">Status: <span class="text-emerald-600">Semua</span></span>
                            <span class="material-symbols-outlined text-emerald-500 text-[18px]">keyboard_arrow_down</span>
                        </button>
                        <button class="flex h-9 items-center justify-center gap-x-2 rounded-lg bg-emerald-50 border border-emerald-200 hover:border-emerald-300 px-3 transition-colors">
                            <span class="text-emerald-800 text-xs font-medium">Wilayah: <span class="text-emerald-600">Semua</span></span>
                            <span class="material-symbols-outlined text-emerald-500 text-[18px]">keyboard_arrow_down</span>
                        </button>
                    </div>
                </div>
                <div class="w-full">
                    <div class="flex flex-col overflow-hidden rounded-xl border border-emerald-100 bg-white shadow-sm">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-emerald-50 border-b border-emerald-100">
                                        <th class="p-3 md:p-4 text-xs font-semibold text-emerald-700 uppercase tracking-wider">Pelanggan</th>
                                        <th class="hidden lg:table-cell p-3 md:p-4 text-xs font-semibold text-emerald-700 uppercase tracking-wider">Kontak</th>
                                        <th class="p-3 md:p-4 text-xs font-semibold text-emerald-700 uppercase tracking-wider">Status</th>
                                        <th class="hidden md:table-cell p-3 md:p-4 text-xs font-semibold text-emerald-700 uppercase tracking-wider">Wilayah</th>
                                        <th class="hidden xl:table-cell p-3 md:p-4 text-xs font-semibold text-emerald-700 uppercase tracking-wider text-right">Iuran</th>
                                        <th class="p-3 md:p-4 text-xs font-semibold text-emerald-700 uppercase tracking-wider w-[60px]"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-emerald-50">
                                    @forelse($pelanggan ?? [] as $p)
                                        <tr class="group hover:bg-emerald-50/50 transition-colors">
                                            <td class="p-3 md:p-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="h-9 w-9 md:h-10 md:w-10 rounded-full bg-emerald-200 flex items-center justify-center text-emerald-800 font-bold text-xs md:text-sm shrink-0">
                                                        {{ strtoupper(substr($p->nama, 0, 2)) }}
                                                    </div>
                                                    <div class="min-w-0">
                                                        <p class="text-emerald-900 text-sm font-semibold truncate">{{ $p->nama }}</p>
                                                        <p class="text-emerald-600 text-xs">ID: #PLG-{{ str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="hidden lg:table-cell p-3 md:p-4">
                                                <div class="flex flex-col">
                                                    <span class="text-emerald-900 text-sm">{{ $p->telepon }}</span>
                                                    <span class="text-emerald-600 text-xs truncate max-w-[200px]">{{ $p->alamat_lengkap }}</span>
                                                </div>
                                            </td>
                                            <td class="p-3 md:p-4">
                                                @if($p->status === 'aktif')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 border border-emerald-200">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                                        Aktif
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400 mr-1.5"></span>
                                                        Nonaktif
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="hidden md:table-cell p-3 md:p-4">
                                                <span class="text-emerald-700 text-sm">{{ $p->wilayah }}</span>
                                            </td>
                                            <td class="hidden xl:table-cell p-3 md:p-4 text-right">
                                                <p class="text-emerald-900 text-sm font-medium">Rp {{ number_format($p->harga, 0, ',', '.') }}</p>
                                                <p class="text-emerald-600 text-xs">{{ $p->jenisPelanggan->nama_paket ?? '-' }}</p>
                                            </td>
                                            <td class="p-3 md:p-4 text-right">
                                                <div class="relative inline-block text-left">
                                                    <button onclick="toggleMenu({{ $p->id }})" class="text-emerald-500 hover:text-emerald-700 p-1 rounded-md hover:bg-emerald-100 transition-colors">
                                                        <span class="material-symbols-outlined text-[20px]">more_vert</span>
                                                    </button>
                                                    <div id="menu-{{ $p->id }}" class="hidden absolute right-0 mt-2 w-36 rounded-lg bg-white shadow-lg border border-emerald-100 z-10">
                                                        <button onclick="showDetailPelanggan({{ json_encode($p) }})" class="flex items-center gap-2 px-3 py-2 text-sm text-emerald-700 hover:bg-emerald-50 w-full">
                                                            <span class="material-symbols-outlined text-[18px]">visibility</span>
                                                            Lihat
                                                        </button>
                                                        <button onclick="showEditPelanggan({{ json_encode($p) }})" class="flex items-center gap-2 px-3 py-2 text-sm text-emerald-700 hover:bg-emerald-50 w-full">
                                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                                            Edit
                                                        </button>
                                                        <hr class="my-1 border-emerald-100">
                                                        <button onclick="confirmDelete({{ $p->id }}, '{{ $p->nama }}')" class="flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50 w-full">
                                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                                            Hapus
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-4 md:px-6 py-12 md:py-16 text-center">
                                                <span class="material-symbols-outlined text-[48px] md:text-[56px] text-emerald-300">group_off</span>
                                                <p class="text-emerald-600 text-sm mt-3">Belum ada data pelanggan</p>
                                                <button onclick="openSlideOver()" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700 transition-colors">
                                                    <span class="material-symbols-outlined text-[18px]">add</span>
                                                    Tambah Pelanggan
                                                </button>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if(isset($pelanggan) && $pelanggan->hasPages())
                            <div class="border-t border-emerald-100 px-3 md:px-4 py-3 flex items-center justify-between bg-emerald-50/50">
                                <span class="text-xs text-emerald-600 hidden sm:inline">
                                    Menampilkan {{ $pelanggan->firstItem() }}-{{ $pelanggan->lastItem() }} dari {{ $pelanggan->total() }}
                                </span>
                                <div class="flex gap-2 mx-auto sm:mx-0">
                                    @if($pelanggan->onFirstPage())
                                        <span class="px-3 py-1 rounded text-xs font-medium text-emerald-400 bg-emerald-50 border border-emerald-200 cursor-not-allowed">Prev</span>
                                    @else
                                        <a href="{{ $pelanggan->previousPageUrl() }}" class="px-3 py-1 rounded text-xs font-medium text-emerald-700 bg-white border border-emerald-200 hover:bg-emerald-50">Prev</a>
                                    @endif
                                    
                                    @if($pelanggan->hasMorePages())
                                        <a href="{{ $pelanggan->nextPageUrl() }}" class="px-3 py-1 rounded text-xs font-medium text-emerald-700 bg-white border border-emerald-200 hover:bg-emerald-50">Next</a>
                                    @else
                                        <span class="px-3 py-1 rounded text-xs font-medium text-emerald-400 bg-emerald-50 border border-emerald-200 cursor-not-allowed">Next</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function toggleMenu(id) {
            document.querySelectorAll('[id^="menu-"]').forEach(menu => {
                if (menu.id !== 'menu-' + id) {
                    menu.classList.add('hidden');
                }
            });
            document.getElementById('menu-' + id).classList.toggle('hidden');
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('[id^="menu-"]') && !e.target.closest('button[onclick^="toggleMenu"]')) {
                document.querySelectorAll('[id^="menu-"]').forEach(menu => {
                    menu.classList.add('hidden');
                });
            }
        });

        function showDetailPelanggan(pelanggan) {
            toggleMenu(pelanggan.id); 
            
            Swal.fire({
                title: '<strong>Detail Pelanggan</strong>',
                icon: 'info',
                html: `
                    <div class="text-left space-y-3">
                        <div class="flex justify-center mb-4">
                            <div class="h-16 w-16 rounded-full bg-emerald-200 flex items-center justify-center text-emerald-800 font-bold text-xl">
                                ${pelanggan.nama.substring(0, 2).toUpperCase()}
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <div class="text-gray-500">ID:</div>
                            <div class="font-medium">#PLG-${String(pelanggan.id).padStart(4, '0')}</div>
                            
                            <div class="text-gray-500">Nama:</div>
                            <div class="font-medium">${pelanggan.nama}</div>
                            
                            <div class="text-gray-500">Telepon:</div>
                            <div class="font-medium">${pelanggan.telepon}</div>
                            
                            <div class="text-gray-500">Status:</div>
                            <div><span class="px-2 py-0.5 rounded-full text-xs font-medium ${pelanggan.status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600'}">${pelanggan.status}</span></div>
                            
                            <div class="text-gray-500">Wilayah:</div>
                            <div class="font-medium">${pelanggan.wilayah}</div>
                            
                            <div class="text-gray-500">Iuran:</div>
                            <div class="font-medium">Rp ${Number(pelanggan.harga || 0).toLocaleString('id-ID')}</div>
                        </div>
                        <div class="mt-3 pt-3 border-t">
                            <div class="text-gray-500 text-sm mb-1">Alamat:</div>
                            <div class="text-sm">${pelanggan.alamat_lengkap || '-'}</div>
                        </div>
                    </div>
                `,
                showCloseButton: true,
                showConfirmButton: false,
                customClass: {
                    popup: 'rounded-xl',
                    title: 'text-emerald-900'
                }
            });
        }
        async function showEditPelanggan(pelanggan) {
            toggleMenu(pelanggan.id); 
            
            const { value: formValues } = await Swal.fire({
                title: 'Edit Pelanggan',
                html: `
                    <div class="text-left space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <input id="swal-nama" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent" value="${pelanggan.nama}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                            <input id="swal-telepon" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent" value="${pelanggan.telepon}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                            <textarea id="swal-alamat" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent" rows="2">${pelanggan.alamat_lengkap || ''}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Wilayah</label>
                            <select id="swal-wilayah" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                <option value="Wilayah A" ${pelanggan.wilayah === 'Wilayah A' ? 'selected' : ''}>Wilayah A</option>
                                <option value="Wilayah B" ${pelanggan.wilayah === 'Wilayah B' ? 'selected' : ''}>Wilayah B</option>
                                <option value="Wilayah C" ${pelanggan.wilayah === 'Wilayah C' ? 'selected' : ''}>Wilayah C</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="swal-status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                <option value="aktif" ${pelanggan.status === 'aktif' ? 'selected' : ''}>Aktif</option>
                                <option value="nonaktif" ${pelanggan.status === 'nonaktif' ? 'selected' : ''}>Nonaktif</option>
                            </select>
                        </div>
                    </div>
                `,
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#059669',
                preConfirm: () => {
                    return {
                        nama: document.getElementById('swal-nama').value,
                        telepon: document.getElementById('swal-telepon').value,
                        alamat_lengkap: document.getElementById('swal-alamat').value,
                        wilayah: document.getElementById('swal-wilayah').value,
                        status: document.getElementById('swal-status').value
                    }
                }
            });

            if (formValues) {
                const form = new FormData();
                form.append('_token', '{{ csrf_token() }}');
                form.append('_method', 'PUT');
                form.append('nama', formValues.nama);
                form.append('telepon', formValues.telepon);
                form.append('alamat_lengkap', formValues.alamat_lengkap);
                form.append('wilayah', formValues.wilayah);
                form.append('status', formValues.status);

                fetch(`/admin/pelanggan/${pelanggan.id}`, {
                    method: 'POST',
                    body: form
                }).then(response => {
                    if (response.ok) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data pelanggan berhasil diupdate.',
                            icon: 'success',
                            confirmButtonColor: '#059669'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire('Error!', 'Gagal mengupdate data.', 'error');
                    }
                });
            }
        }
        function confirmDelete(id, nama) {
            toggleMenu(id); 
            
            Swal.fire({
                title: 'Hapus Pelanggan?',
                text: `Yakin ingin menghapus "${nama}"? Data tidak dapat dikembalikan!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('deleteForm');
                    form.action = `/admin/pelanggan/${id}`;
                    form.submit();
                }
            });
        }
        document.getElementById('formTambahPelanggan').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData
            }).then(response => {
                if (response.ok) {
                    closeSlideOver();
                    Swal.fire({
                        title: 'Berhasil Ditambahkan!',
                        text: 'Pelanggan baru berhasil didaftarkan.',
                        icon: 'success',
                        confirmButtonColor: '#059669',
                        draggable: true
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire('Error!', 'Gagal menambahkan pelanggan.', 'error');
                }
            }).catch(error => {
                Swal.fire('Error!', 'Terjadi kesalahan.', 'error');
            });
        });
        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonColor: '#059669',
                draggable: true
            });
        @endif
    </script>
</x-layouts.admin>
