<x-layouts.admin title="Manajemen Petugas">
    <x-slot name="slideOver">
        <div class="flex items-center justify-between p-6 border-b border-emerald-100 bg-emerald-50/50">
            <div>
                <h2 class="text-xl font-bold text-emerald-900" id="slideOverTitle">Tambah Petugas</h2>
                <p class="text-sm text-emerald-600 mt-1" id="slideOverSubtitle">Isi formulir data petugas baru</p>
            </div>
            <button onclick="closeSlideOver()" class="p-2 hover:bg-emerald-100 rounded-full text-emerald-400 hover:text-emerald-700 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form id="petugasForm" action="{{ route('admin.petugas.store') }}" method="POST" enctype="multipart/form-data" class="flex-1 flex flex-col overflow-hidden">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div class="flex-1 overflow-y-auto p-6 flex flex-col gap-5">
                <div class="flex flex-col items-center gap-3">
                    <div class="relative w-24 h-24 group">
                        <div id="photoPreview" class="w-full h-full rounded-full border-2 border-dashed border-emerald-200 bg-emerald-50 flex items-center justify-center overflow-hidden">
                            <span class="material-symbols-outlined text-emerald-300 text-3xl">add_a_photo</span>
                        </div>
                        <input type="file" name="foto" id="fotoInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*" onchange="previewImage(this)">
                        <div class="absolute bottom-0 right-0 bg-emerald-600 rounded-full p-1 text-white shadow-sm pointer-events-none">
                            <span class="material-symbols-outlined text-[14px]">edit</span>
                        </div>
                    </div>
                    <p class="text-xs text-emerald-500">Upload Foto Profil (Max 2MB)</p>
                </div>

                <div class="space-y-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-semibold text-emerald-700">Nama Lengkap</label>
                        <input name="nama" id="inputNama" class="w-full px-3 py-2.5 rounded-lg bg-white border border-emerald-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-sm text-emerald-900 placeholder:text-emerald-300" placeholder="Contoh: Budi Santoso" type="text" required/>
                    </div>
                    
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-semibold text-emerald-700">Email</label>
                        <input name="email" id="inputEmail" class="w-full px-3 py-2.5 rounded-lg bg-white border border-emerald-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-sm text-emerald-900 placeholder:text-emerald-300" placeholder="budi@email.com" type="email" required/>
                    </div>
                    
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-semibold text-emerald-700">Nomor Telepon</label>
                        <input name="telepon" id="inputTelepon" class="w-full px-3 py-2.5 rounded-lg bg-white border border-emerald-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-sm text-emerald-900 placeholder:text-emerald-300" placeholder="08123456789" type="tel" required/>
                    </div>
                    
                    <div class="flex flex-col gap-1.5" id="passwordGroup">
                        <label class="text-sm font-semibold text-emerald-700">Password</label>
                        <input name="password" id="inputPassword" class="w-full px-3 py-2.5 rounded-lg bg-white border border-emerald-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-sm text-emerald-900 placeholder:text-emerald-300" placeholder="••••••••" type="password"/>
                        <p class="text-xs text-emerald-500 hidden" id="passwordHint">Kosongkan jika tidak ingin mengubah password</p>
                    </div>
                    
                    <div class="h-px bg-emerald-100 my-2"></div>
                    
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-semibold text-emerald-700">Nomor Polisi Kendaraan</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-emerald-400 text-[20px]">directions_car</span>
                            <input name="nomor_kendaraan" id="inputNopol" class="w-full pl-10 pr-3 py-2.5 rounded-lg bg-white border border-emerald-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-sm font-mono uppercase text-emerald-900 placeholder:text-emerald-300" placeholder="B 1234 XYZ" type="text"/>
                        </div>
                    </div>
                    
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-semibold text-emerald-700">Status</label>
                        <div class="relative">
                            <select name="status" id="inputStatus" class="w-full appearance-none px-3 py-2.5 rounded-lg bg-white border border-emerald-200 focus:ring-2 focus:ring-emerald-500 outline-none text-sm text-emerald-900 cursor-pointer">
                                <option value="aktif">Aktif</option>
                                <option value="istirahat">Istirahat</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-emerald-500 pointer-events-none">expand_more</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-6 border-t border-emerald-100 bg-emerald-50/50 flex gap-3 sticky bottom-0 z-10">
                <button type="button" onclick="closeSlideOver()" class="flex-1 px-4 py-2.5 rounded-lg border border-emerald-200 hover:bg-emerald-50 font-semibold text-emerald-700 transition-colors">Batal</button>
                <button type="submit" class="flex-1 px-4 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 font-semibold text-white shadow-lg shadow-emerald-600/20 transition-all flex items-center justify-center gap-2">
                    <span id="submitBtnText">Simpan Data</span>
                </button>
            </div>
        </form>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="h-full flex flex-col overflow-hidden relative">
            <div class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8 w-full" id="mainContent">
            <div class="max-w-[1600px] mx-auto flex flex-col gap-6">
                
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-black tracking-tight text-emerald-900 mb-2">Manajemen Petugas</h1>
                        <p class="text-emerald-600 max-w-lg">Kelola data petugas lapangan, pantau status operasional, dan atur penugasan dalam satu tampilan.</p>
                    </div>
                    <button onclick="openCreatePetugas()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-lg font-bold shadow-lg shadow-emerald-600/25 flex items-center gap-2 transition-all active:scale-95 shrink-0 transform hover:-translate-y-0.5">
                        <span class="material-symbols-outlined text-[20px]">add</span>
                        <span>Tambah Petugas</span>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white p-5 rounded-xl border border-emerald-100 shadow-sm flex flex-col hover:border-emerald-300 transition-colors group">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 rounded-lg bg-blue-50 text-blue-600 group-hover:bg-blue-100 transition-colors">
                                <span class="material-symbols-outlined">group</span>
                            </div>
                            <span class="text-sm font-medium text-emerald-600">Total Petugas</span>
                        </div>
                        <p class="text-3xl font-bold text-emerald-900">{{ $totalPetugas ?? 0 }}</p>
                    </div>
                    <div class="bg-white p-5 rounded-xl border border-emerald-100 shadow-sm flex flex-col hover:border-emerald-300 transition-colors group">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 rounded-lg bg-emerald-50 text-emerald-600 group-hover:bg-emerald-100 transition-colors">
                                <span class="material-symbols-outlined">check_circle</span>
                            </div>
                            <span class="text-sm font-medium text-emerald-600">Sedang Aktif</span>
                        </div>
                        <p class="text-3xl font-bold text-emerald-900">{{ $petugasAktif ?? 0 }}</p>
                    </div>
                    <div class="bg-white p-5 rounded-xl border border-emerald-100 shadow-sm flex flex-col hover:border-emerald-300 transition-colors group">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 rounded-lg bg-amber-50 text-amber-600 group-hover:bg-amber-100 transition-colors">
                                <span class="material-symbols-outlined">coffee</span>
                            </div>
                            <span class="text-sm font-medium text-emerald-600">Istirahat</span>
                        </div>
                        <p class="text-3xl font-bold text-emerald-900">{{ $petugasIstirahat ?? 0 }}</p>
                    </div>
                </div>

                <form method="GET" action="{{ route('admin.petugas.index') }}" class="flex flex-col sm:flex-row gap-4 sticky top-0 z-10 py-2 bg-[#FDFDFD]/95 backdrop-blur-sm">
                    <div class="relative flex-1 group">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-emerald-400 group-focus-within:text-emerald-600 transition-colors">search</span>
                        <input name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-3 rounded-lg bg-white border border-emerald-200 focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition-all placeholder:text-emerald-400 text-emerald-900" placeholder="Cari nama petugas, email, atau nomor polisi..." type="text" onchange="this.form.submit()"/>
                    </div>
                    <div class="flex gap-2">
                        <div class="relative">
                            <select name="status" onchange="this.form.submit()" class="appearance-none pl-10 pr-8 py-3 rounded-lg bg-white border border-emerald-200 text-emerald-700 font-medium focus:ring-2 focus:ring-emerald-500 outline-none cursor-pointer hover:border-emerald-300 transition-colors">
                                <option value="">Semua Status</option>
                                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="istirahat" {{ request('status') == 'istirahat' ? 'selected' : '' }}>Istirahat</option>
                                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-emerald-500">filter_list</span>
                        </div>
                    </div>
                </form>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 pb-10">
                    @forelse($petugas as $p)
                        <div class="group relative flex flex-col bg-white border border-emerald-100 rounded-xl p-5 hover:border-emerald-400 transition-all hover:shadow-lg hover:shadow-emerald-100">
                            <div class="absolute top-4 right-4 z-10">
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" @click.outside="open = false" class="text-emerald-300 hover:text-emerald-600 rounded-full p-1 hover:bg-emerald-50 transition-colors">
                                        <span class="material-symbols-outlined text-[20px]">more_vert</span>
                                    </button>
                                    <div x-show="open" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-emerald-100 py-1" style="display: none;">
                                        <button onclick="editPetugas({{ json_encode($p) }})" class="w-full text-left px-4 py-2 text-sm text-emerald-700 hover:bg-emerald-50 hover:text-emerald-900 flex items-center gap-2">
                                            <span class="material-symbols-outlined text-[18px]">edit</span> Edit Data
                                        </button>
                                        <form action="{{ route('admin.petugas.destroy', $p->id) }}" method="POST" class="block w-full">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete(this.closest('form'))" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2">
                                                <span class="material-symbols-outlined text-[18px]">block</span> Nonaktifkan
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col items-center text-center">
                                <div class="relative mb-4">
                                    <div class="w-20 h-20 rounded-full bg-emerald-100 border-4 border-white shadow-sm flex items-center justify-center overflow-hidden">
                                        @if($p->foto_profil)
                                            <img src="{{ asset('storage/' . $p->foto_profil) }}" alt="{{ $p->nama }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="material-symbols-outlined text-4xl text-emerald-400">person</span>
                                        @endif
                                    </div>
                                    @php
                                        $statusColor = match($p->status) {
                                            'aktif' => 'bg-emerald-500',
                                            'istirahat' => 'bg-amber-500', 
                                            default => 'bg-slate-400'
                                        };
                                        $statusLabel = ucfirst($p->status);
                                    @endphp
                                    <div class="absolute bottom-0 right-0 w-5 h-5 {{ $statusColor }} border-2 border-white rounded-full" title="{{ $statusLabel }}"></div>
                                </div>
                                
                                <h3 class="text-lg font-bold text-emerald-900 line-clamp-1">{{ $p->nama }}</h3>
                                <p class="text-sm text-emerald-500 mb-4 line-clamp-1 break-all">{{ $p->email }}</p>
                                
                                <div class="w-full grid grid-cols-2 gap-2 mb-4">
                                    <div class="bg-emerald-50 rounded-lg p-2 flex flex-col items-center border border-emerald-50">
                                        <span class="text-[10px] uppercase tracking-wider text-emerald-400 font-semibold">Kendaraan</span>
                                        <span class="font-mono font-medium text-emerald-700 text-sm truncate w-full text-center">{{ $p->nomor_kendaraan ?? '-' }}</span>
                                    </div>
                                    <div class="{{ $p->status === 'aktif' ? 'bg-emerald-50 border-emerald-100' : ($p->status === 'istirahat' ? 'bg-amber-50 border-amber-100' : 'bg-slate-50 border-slate-100') }} border rounded-lg p-2 flex flex-col items-center">
                                        <span class="text-[10px] uppercase tracking-wider {{ $p->status === 'aktif' ? 'text-emerald-600' : ($p->status === 'istirahat' ? 'text-amber-600' : 'text-slate-500') }} font-semibold">Status</span>
                                        <span class="font-medium {{ $p->status === 'aktif' ? 'text-emerald-700' : ($p->status === 'istirahat' ? 'text-amber-700' : 'text-slate-700') }}">{{ $statusLabel }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center text-emerald-400">
                            <span class="material-symbols-outlined text-[48px]">search_off</span>
                            <p class="mt-2">Tidak ada data petugas ditemukan.</p>
                        </div>
                    @endforelse
                </div>
                
                <div class="mt-4">
                    {{ $petugas->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        // Custom function to handle Create mode (Reset Form)
        function openCreatePetugas() {
            const form = document.getElementById('petugasForm');
            
            // Reset form for create mode
            form.reset();
            form.action = "{{ route('admin.petugas.store') }}";
            document.getElementById('formMethod').value = "POST";
            document.getElementById('slideOverTitle').innerText = "Tambah Petugas";
            document.getElementById('slideOverSubtitle').innerText = "Isi formulir data petugas baru";
            document.getElementById('passwordHint').classList.add('hidden');
            document.getElementById('inputPassword').required = true;
            document.getElementById('photoPreview').innerHTML = '<span class="material-symbols-outlined text-emerald-300 text-3xl">add_a_photo</span>';
            
            // Call global open function from layout
            openSlideOver();
        }

        // Custom function to handle Edit mode
        function editPetugas(petugas) {
             const form = document.getElementById('petugasForm');
            
            // Reset & Populate
            form.action = `/admin/petugas/${petugas.id}`;
            document.getElementById('formMethod').value = "PUT";
            document.getElementById('slideOverTitle').innerText = "Edit Petugas";
            document.getElementById('slideOverSubtitle').innerText = "Perbarui data petugas";
            
            document.getElementById('inputNama').value = petugas.nama;
            document.getElementById('inputEmail').value = petugas.email;
            document.getElementById('inputTelepon').value = petugas.telepon;
            document.getElementById('inputNopol').value = petugas.nomor_kendaraan || '';
            document.getElementById('inputStatus').value = petugas.status;
            
            document.getElementById('inputPassword').required = false;
            document.getElementById('passwordHint').classList.remove('hidden');

            // Photo preview if exists
            if (petugas.foto_profil) {
                document.getElementById('photoPreview').innerHTML = `<img src="/storage/${petugas.foto_profil}" class="w-full h-full object-cover">`;
            } else {
                 document.getElementById('photoPreview').innerHTML = '<span class="material-symbols-outlined text-emerald-300 text-3xl">add_a_photo</span>';
            }
            
            // Call global open function from layout
            openSlideOver();
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('photoPreview').innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function confirmDelete(form) {
            Swal.fire({
                title: 'Nonaktifkan Petugas?',
                text: "Petugas tidak akan bisa login lagi. Status akan diubah menjadi Nonaktif.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#059669',
                confirmButtonText: 'Ya, Nonaktifkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
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
                                title: 'Dinonaktifkan!',
                                text: data.message,
                                icon: 'success'
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Error', 'Gagal memproses permintaan.', 'error');
                        }
                    })
                    .catch(() => {
                         form.submit();
                    });
                }
            });
        }

        document.getElementById('petugasForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            const btn = form.querySelector('button[type="submit"]');
            const originalBtnText = document.getElementById('submitBtnText').innerText;
            
            btn.disabled = true;
            document.getElementById('submitBtnText').innerText = 'Menyimpan...';

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
                    closeSlideOver();
                    Swal.fire({
                        title: 'Berhasil!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#059669',
                        draggable: true
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.message || 'Terjadi kesalahan.',
                        icon: 'error',
                        confirmButtonColor: '#d33'
                    });
                    btn.disabled = false;
                    document.getElementById('submitBtnText').innerText = originalBtnText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Gagal!', 'Terjadi kesalahan sistem.', 'error');
                btn.disabled = false;
                document.getElementById('submitBtnText').innerText = originalBtnText;
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
