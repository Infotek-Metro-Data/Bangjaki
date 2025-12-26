<x-layouts.petugas title="Input Pembayaran">
    <div class="px-4 py-5 flex flex-col gap-5">
        <div class="flex flex-wrap gap-2 items-center">
            <a class="text-slate-500 text-sm font-medium hover:text-orange-600 hover:underline"
                href="{{ route('petugas.home') }}">Dashboard</a>
            <span class="text-slate-400 text-sm">/</span>
            <span class="text-slate-800 text-sm font-medium">Catat Pembayaran</span>
        </div>

        <h1 class="text-slate-800 text-2xl font-black leading-tight tracking-tight">Catat Pembayaran</h1>

        <form action="{{ route('petugas.input.store') }}" method="POST" enctype="multipart/form-data"
            class="flex flex-col gap-6">
            @csrf

            <div class="flex flex-col gap-3">
                <label class="text-base font-bold text-slate-800">Pilih Pelanggan</label>

                @if ($tagihan)
                    <input type="hidden" name="tagihan_id" value="{{ $tagihan->id }}">
                    <div class="rounded-xl border border-orange-200 bg-orange-50/50 p-4 flex items-center gap-4">
                        <div class="h-12 w-12 rounded-full bg-orange-100 flex items-center justify-center shrink-0">
                            <span
                                class="text-orange-600 font-bold text-lg">{{ substr($tagihan->pelanggan->nama ?? 'P', 0, 1) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-bold text-slate-800 truncate">
                                {{ $tagihan->pelanggan->nama }}
                                <span
                                    class="text-xs font-normal text-slate-500 ml-1">#{{ $tagihan->pelanggan->id }}</span>
                            </h4>
                            <p class="text-xs text-slate-500 truncate">{{ $tagihan->pelanggan->alamat_lengkap }}</p>
                        </div>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-white p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500">Total Tagihan</span>
                            <span class="text-xl font-bold text-orange-600">Rp
                                {{ number_format($tagihan->total_tagihan ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @else
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-slate-400">search</span>
                        </div>
                        <input type="text"
                            class="block w-full pl-12 pr-10 py-4 bg-white border border-slate-200 rounded-xl text-slate-800 text-base font-medium placeholder-slate-400 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all shadow-sm"
                            placeholder="Cari atau pilih pelanggan...">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer">
                            <span class="material-symbols-outlined text-slate-400">expand_more</span>
                        </div>
                    </div>
                    <p class="text-sm text-amber-600 bg-amber-50 rounded-lg p-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">info</span>
                        Pilih tagihan dari halaman Tagihan untuk melanjutkan
                    </p>
                @endif
            </div>

            <div class="flex flex-col gap-3">
                <label class="text-base font-bold text-slate-800">Nominal</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <span class="text-slate-500 font-bold text-lg">Rp</span>
                    </div>
                    <input type="number" name="nominal" required value="{{ $tagihan->total_tagihan ?? '' }}"
                        class="block w-full pl-12 pr-4 py-4 bg-white border border-slate-200 rounded-xl text-slate-800 text-2xl font-bold placeholder-slate-300 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all shadow-sm"
                        placeholder="0">
                </div>
            </div>

            <div class="flex flex-col gap-3">
                <label class="text-base font-bold text-slate-800">Metode Bayar</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="cursor-pointer relative group">
                        <input type="radio" name="metode" value="tunai" checked class="peer sr-only">
                        <div
                            class="flex flex-col items-center justify-center p-5 rounded-xl border-2 border-slate-200 bg-white hover:bg-slate-50 peer-checked:border-orange-500 peer-checked:bg-orange-50 transition-all text-center gap-2 shadow-sm">
                            <span
                                class="material-symbols-outlined text-3xl text-slate-400 peer-checked:text-orange-600 transition-colors">wallet</span>
                            <span
                                class="text-base font-bold text-slate-600 peer-checked:text-orange-600 transition-colors">Tunai</span>
                        </div>
                    </label>
                    <label class="cursor-pointer relative group">
                        <input type="radio" name="metode" value="transfer" class="peer sr-only">
                        <div
                            class="flex flex-col items-center justify-center p-5 rounded-xl border-2 border-slate-200 bg-white hover:bg-slate-50 peer-checked:border-orange-500 peer-checked:bg-orange-50 transition-all text-center gap-2 shadow-sm">
                            <span
                                class="material-symbols-outlined text-3xl text-slate-400 peer-checked:text-orange-600 transition-colors">payments</span>
                            <span
                                class="text-base font-bold text-slate-600 peer-checked:text-orange-600 transition-colors">Transfer</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="flex flex-col gap-3">
                <label class="text-base font-bold text-slate-800">Bukti Foto <span
                        class="text-xs font-normal text-slate-400">(Maks. 5 foto)</span></label>

                <div id="foto-preview-grid" class="grid grid-cols-3 gap-2 mb-2 hidden">
                </div>

                <div class="w-full relative group cursor-pointer aspect-[4/3]" id="upload-area">
                    <input type="file" name="bukti_foto[]" accept="image/*" capture="environment" required multiple
                        id="foto-input" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div id="foto-preview-container"
                        class="flex flex-col items-center justify-center w-full h-full border-2 border-dashed border-slate-300 rounded-xl bg-slate-50 group-hover:bg-slate-100 group-hover:border-orange-300 transition-all text-center px-4">
                        <span
                            class="material-symbols-outlined text-5xl text-slate-400 mb-3 group-hover:scale-110 transition-transform">photo_camera</span>
                        <p class="text-sm font-medium text-slate-600">Ketuk untuk ambil foto</p>
                        <p class="text-xs text-slate-400 mt-1">atau pilih dari galeri (maks. 5 foto)</p>
                    </div>
                </div>
                <p class="text-xs text-slate-400 text-center">Format: JPG, PNG (Max 5MB per foto)</p>
            </div>

            <div class="flex flex-col gap-3">
                <label class="text-base font-bold text-slate-800">Catatan (Opsional)</label>
                <textarea name="catatan" rows="3"
                    class="block w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 text-sm placeholder-slate-400 focus:ring-2 focus:ring-orange-500 focus:border-transparent resize-none shadow-sm"
                    placeholder="Tambahkan catatan transaksi..."></textarea>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="flex items-start gap-3 text-sm">
                    <span class="material-symbols-outlined text-orange-600 mt-0.5 text-lg">schedule</span>
                    <div class="flex flex-col">
                        <span class="text-slate-500 text-xs">Waktu Transaksi</span>
                        <span
                            class="font-medium text-slate-800">{{ now()->locale('id')->translatedFormat('d F Y • H:i') }}
                            WIB</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-3 pt-2">
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-6 py-4 rounded-xl bg-orange-600 hover:bg-orange-700 text-white font-bold text-base shadow-lg shadow-orange-600/30 transition-all transform active:scale-[0.98]">
                    <span class="material-symbols-outlined">check_circle</span>
                    Simpan Transaksi
                </button>

                <a href="{{ route('petugas.home') }}"
                    class="w-full text-center py-3 text-sm font-medium text-slate-500 hover:text-slate-700 transition-colors">
                    Batalkan
                </a>
            </div>
        </form>
    </div>

    <script>
        let selectedFiles = [];

        document.getElementById('foto-input').addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            const maxFiles = 5;

            if (files.length > maxFiles) {
                alert('Maksimal ' + maxFiles + ' foto yang dapat diupload');
                e.target.value = '';
                return;
            }

            selectedFiles = files;
            updatePreviewGrid();
        });

        function updatePreviewGrid() {
            const grid = document.getElementById('foto-preview-grid');
            const uploadArea = document.getElementById('upload-area');

            grid.innerHTML = '';

            if (selectedFiles.length > 0) {
                grid.classList.remove('hidden');
                uploadArea.classList.add('hidden');

                selectedFiles.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className =
                            'relative aspect-square rounded-xl overflow-hidden border border-slate-200 bg-slate-100';
                        div.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-full object-cover" alt="Preview ${index + 1}">
                            <button type="button" onclick="removePhoto(${index})" 
                                class="absolute top-1 right-1 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-red-600 transition-colors">
                                <span class="material-symbols-outlined text-sm">close</span>
                            </button>
                            <div class="absolute bottom-1 left-1 bg-black/60 text-white text-xs px-2 py-0.5 rounded-full">
                                ${index + 1}/${selectedFiles.length}
                            </div>
                        `;
                        grid.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                });

                if (selectedFiles.length < 5) {
                    const addBtn = document.createElement('div');
                    addBtn.className =
                        'relative aspect-square rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 flex flex-col items-center justify-center cursor-pointer hover:bg-slate-100 hover:border-orange-300 transition-all';
                    addBtn.innerHTML = `
                        <span class="material-symbols-outlined text-2xl text-slate-400">add_photo_alternate</span>
                        <span class="text-xs text-slate-400 mt-1">Tambah</span>
                    `;
                    addBtn.onclick = function() {
                        document.getElementById('foto-input').click();
                    };
                    grid.appendChild(addBtn);
                }
            } else {
                grid.classList.add('hidden');
                uploadArea.classList.remove('hidden');
            }
        }

        function removePhoto(index) {
            const dt = new DataTransfer();
            selectedFiles = selectedFiles.filter((_, i) => i !== index);
            selectedFiles.forEach(file => dt.items.add(file));
            document.getElementById('foto-input').files = dt.files;
            updatePreviewGrid();
        }
    </script>
</x-layouts.petugas>
