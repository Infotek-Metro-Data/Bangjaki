<x-layouts.pelanggan title="Profil Saya">
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="bg-gradient-to-br from-sky-500 to-sky-600 rounded-2xl p-6 text-white">
            <div class="flex items-center gap-4">
                <div
                    class="h-20 w-20 rounded-full bg-white/20 flex items-center justify-center border-4 border-white/30">
                    <span class="text-white font-bold text-3xl">{{ strtoupper(substr($pelanggan->nama, 0, 2)) }}</span>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">{{ $pelanggan->nama }}</h1>
                    <p class="text-sky-100">ID: #PLG-{{ str_pad($pelanggan->id, 4, '0', STR_PAD_LEFT) }}</p>
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium mt-2 {{ $pelanggan->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                        {{ ucfirst($pelanggan->status) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-slate-900 flex items-center gap-2">
                    <span class="material-symbols-outlined text-gray-400 text-[20px]">person</span>
                    Informasi Pribadi
                </h3>
            </div>
            <form action="{{ route('pelanggan.profile.update') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama', $pelanggan->nama) }}" required
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                        @error('nama')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" value="{{ $pelanggan->email }}" disabled
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed">
                        <p class="text-xs text-gray-400 mt-1">Email tidak dapat diubah</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                        <input type="text" name="telepon" value="{{ old('telepon', $pelanggan->telepon) }}" required
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                        @error('telepon')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Wilayah</label>
                        <input type="text" value="{{ $pelanggan->wilayah }}" disabled
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                    <textarea name="alamat_lengkap" rows="3" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent resize-none">{{ old('alamat_lengkap', $pelanggan->alamat_lengkap) }}</textarea>
                    @error('alamat_lengkap')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="pt-2">
                    <button type="submit"
                        class="px-6 py-2.5 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-lg transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-slate-900 flex items-center gap-2">
                    <span class="material-symbols-outlined text-gray-400 text-[20px]">lock</span>
                    Keamanan
                </h3>
            </div>
            <form action="{{ route('pelanggan.profile.password') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
                        <input type="password" name="current_password" required
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                        @error('current_password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                    </div>
                </div>
                <div class="pt-2">
                    <button type="submit"
                        class="px-6 py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-medium rounded-lg transition-colors">
                        Ganti Password
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-gray-400 text-[20px]">info</span>
                Informasi Langganan
            </h3>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-sky-500 text-[20px]">payments</span>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Paket</p>
                        <p class="text-slate-900 font-medium">{{ $pelanggan->jenisPelanggan->nama_paket ?? '-' }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-sky-500 text-[20px]">attach_money</span>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Iuran Bulanan</p>
                        <p class="text-sky-600 font-bold text-lg">Rp
                            {{ number_format($pelanggan->iuran_khusus ?? ($pelanggan->jenisPelanggan->harga_dasar ?? 0), 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.pelanggan>
