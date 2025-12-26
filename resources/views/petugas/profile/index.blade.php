<x-layouts.petugas title="Profil">
    <div class="px-4 py-5 flex flex-col gap-5 pb-24">
        <div class="flex flex-wrap gap-2 items-center">
            <a class="text-slate-500 text-sm font-medium hover:text-orange-600 hover:underline"
                href="{{ route('petugas.home') }}">Home</a>
            <span class="text-slate-400 text-sm">/</span>
            <span class="text-slate-800 text-sm font-medium">Profil</span>
        </div>

        <div>
            <h1 class="text-slate-800 text-2xl font-bold tracking-tight">Pengaturan Profil</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola informasi pribadi dan keamanan akun Anda.</p>
        </div>

        <div
            class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-5 text-white shadow-lg shadow-orange-600/30 relative overflow-hidden">
            <div class="absolute top-0 right-0 opacity-10">
                <span class="material-symbols-outlined text-[100px] rotate-12">badge</span>
            </div>

            <div class="flex flex-col items-center gap-4 relative z-10">
                <div class="relative">
                    <div
                        class="h-24 w-24 rounded-full bg-white/20 flex items-center justify-center border-4 border-white/30 shadow-xl overflow-hidden">
                        @if ($petugas->foto_profil)
                            <img src="{{ asset('storage/' . $petugas->foto_profil) }}" alt="Profile"
                                class="h-24 w-24 object-cover">
                        @else
                            <span class="text-white font-bold text-3xl">
                                {{ substr($petugas->nama ?? 'P', 0, 1) }}
                            </span>
                        @endif
                    </div>
                    <label
                        class="absolute bottom-0 right-0 bg-white text-orange-600 p-1.5 rounded-full shadow-lg cursor-pointer hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-sm">edit</span>
                        <input type="file" class="hidden" accept="image/*">
                    </label>
                </div>

                <div class="text-center">
                    <div class="flex items-center justify-center gap-2 mb-1">
                        <h2 class="text-xl font-bold">{{ $petugas->nama }}</h2>
                        <span
                            class="bg-white/20 text-white text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">Petugas</span>
                    </div>
                    <p class="text-orange-100 text-sm flex items-center justify-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">mail</span>
                        {{ $petugas->email }}
                    </p>
                    @if ($petugas->telepon)
                        <p class="text-orange-100 text-sm flex items-center justify-center gap-1 mt-0.5">
                            <span class="material-symbols-outlined text-[16px]">call</span>
                            {{ $petugas->telepon }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        @if ($petugas->nomor_kendaraan)
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="px-4 py-3 border-b border-slate-100 bg-slate-50 flex items-center gap-2">
                    <span class="material-symbols-outlined text-orange-600">directions_car</span>
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Informasi Kendaraan</h3>
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-slate-500 text-xs font-medium mb-0.5">Nomor Kendaraan</p>
                            <p class="text-slate-800 text-lg font-bold tracking-tight">{{ $petugas->nomor_kendaraan }}
                            </p>
                        </div>
                        <div class="p-3 bg-orange-50 rounded-xl">
                            <span class="material-symbols-outlined text-orange-600 text-2xl">two_wheeler</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('petugas.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="px-4 py-3 border-b border-slate-100 bg-slate-50 flex items-center gap-2">
                    <span class="material-symbols-outlined text-orange-600">person</span>
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Informasi Pribadi</h3>
                </div>
                <div class="p-4 space-y-4">
                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-slate-600">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ $petugas->nama }}"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-slate-600">Email</label>
                        <div class="relative">
                            <span
                                class="material-symbols-outlined absolute left-3 top-3 text-slate-400 text-xl">mail</span>
                            <input type="email" name="email" value="{{ $petugas->email }}"
                                class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-slate-600">Nomor Telepon</label>
                        <div class="relative">
                            <span
                                class="material-symbols-outlined absolute left-3 top-3 text-slate-400 text-xl">call</span>
                            <input type="tel" name="telepon" value="{{ $petugas->telepon }}"
                                class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all">
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-orange-600 hover:bg-orange-700 text-white font-semibold shadow-lg shadow-orange-600/30 transition-all">
                        <span class="material-symbols-outlined text-xl">save</span>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>

        <form action="{{ route('petugas.profile.password') }}" method="POST">
            @csrf
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="px-4 py-3 border-b border-slate-100 bg-slate-50 flex items-center gap-2">
                    <span class="material-symbols-outlined text-orange-600">lock</span>
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Keamanan</h3>
                </div>
                <div class="p-4 space-y-4">
                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-slate-600">Password Saat Ini</label>
                        <div class="relative">
                            <input type="password" name="current_password" id="current_password" placeholder="••••••••"
                                class="w-full px-4 py-3 pr-11 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all">
                            <button type="button" onclick="togglePassword('current_password')"
                                class="absolute right-3 top-3 text-slate-400 hover:text-slate-600 transition-colors">
                                <span class="material-symbols-outlined text-xl">visibility</span>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-slate-600">Password Baru</label>
                        <div class="relative">
                            <input type="password" name="password" id="new_password" placeholder="••••••••"
                                class="w-full px-4 py-3 pr-11 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all">
                            <button type="button" onclick="togglePassword('new_password')"
                                class="absolute right-3 top-3 text-slate-400 hover:text-slate-600 transition-colors">
                                <span class="material-symbols-outlined text-xl">visibility_off</span>
                            </button>
                        </div>
                        <div class="flex gap-1 h-1 mt-2">
                            <div class="flex-1 bg-slate-200 rounded-full" id="strength-1"></div>
                            <div class="flex-1 bg-slate-200 rounded-full" id="strength-2"></div>
                            <div class="flex-1 bg-slate-200 rounded-full" id="strength-3"></div>
                            <div class="flex-1 bg-slate-200 rounded-full" id="strength-4"></div>
                        </div>
                        <p class="text-xs text-slate-400 mt-1" id="strength-text">Minimal 8 karakter</p>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-slate-600">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="confirm_password"
                                placeholder="••••••••"
                                class="w-full px-4 py-3 pr-11 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all">
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-semibold transition-all">
                        <span class="material-symbols-outlined text-xl">key</span>
                        Ubah Password
                    </button>
                </div>
            </div>
        </form>

        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="px-4 py-3 border-b border-slate-100 bg-slate-50 flex items-center gap-2">
                <span class="material-symbols-outlined text-orange-600">info</span>
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Tentang Akun</h3>
            </div>
            <div class="p-4 space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-slate-100">
                    <span class="text-sm text-slate-500">ID Petugas</span>
                    <span
                        class="text-sm font-mono font-medium text-slate-800">OFF-{{ str_pad($petugas->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-slate-100">
                    <span class="text-sm text-slate-500">Status</span>
                    <span
                        class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $petugas->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ ucfirst($petugas->status) }}
                    </span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm text-slate-500">Bergabung Sejak</span>
                    <span
                        class="text-sm font-medium text-slate-800">{{ $petugas->created_at->locale('id')->translatedFormat('d F Y') }}</span>
                </div>
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full py-4 bg-red-50 text-red-600 font-semibold rounded-xl hover:bg-red-100 transition-colors flex items-center justify-center gap-2 border border-red-100">
                <span class="material-symbols-outlined">logout</span>
                Keluar dari Akun
            </button>
        </form>

        <p class="text-center text-xs text-slate-400 pb-4">BangJaki Petugas v1.0</p>
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling.querySelector('.material-symbols-outlined');

            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility_off';
            }
        }

        document.getElementById('new_password').addEventListener('input', function(e) {
            const password = e.target.value;
            let strength = 0;

            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
            if (password.match(/\d/)) strength++;
            if (password.match(/[^a-zA-Z\d]/)) strength++;

            const colors = ['bg-red-500', 'bg-yellow-500', 'bg-blue-500', 'bg-green-500'];
            const texts = ['Lemah', 'Cukup', 'Baik', 'Kuat'];
            const textColors = ['text-red-500', 'text-yellow-500', 'text-blue-500', 'text-green-500'];

            for (let i = 1; i <= 4; i++) {
                const bar = document.getElementById('strength-' + i);
                bar.className = 'flex-1 rounded-full ' + (i <= strength ? colors[strength - 1] : 'bg-slate-200');
            }

            const strengthText = document.getElementById('strength-text');
            if (password.length === 0) {
                strengthText.textContent = 'Minimal 8 karakter';
                strengthText.className = 'text-xs text-slate-400 mt-1';
            } else {
                strengthText.textContent = texts[strength - 1] || 'Sangat lemah';
                strengthText.className = 'text-xs mt-1 ' + (textColors[strength - 1] || 'text-red-500');
            }
        });
    </script>
</x-layouts.petugas>
