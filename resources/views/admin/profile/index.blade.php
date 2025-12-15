<x-layouts.admin title="Profil Saya">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="max-w-4xl mx-auto p-4 md:p-6 lg:p-8 flex flex-col gap-6">
        
        <div class="flex items-center gap-2 text-sm text-emerald-600/80">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-700 hover:underline">Home</a>
            <span>/</span>
            <span class="font-medium text-emerald-900">Profil Saya</span>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
            <div>
                <h1 class="text-3xl font-black tracking-tight text-emerald-900 mb-2">Profil Admin</h1>
                <p class="text-emerald-600">Kelola detail akun dan pengaturan keamanan Anda.</p>
            </div>
            <div class="flex items-center gap-2 px-3 py-1.5 bg-white border border-emerald-100 rounded-lg shadow-sm text-sm text-emerald-600">
                <span class="material-symbols-outlined text-[18px]">verified_user</span>
                <span>Login terakhir: {{ now()->format('d M Y, H:i') }}</span>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-emerald-100 shadow-sm overflow-hidden">
            
            <form id="profileForm" action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 border-b border-emerald-50">
                @csrf
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-emerald-900">Informasi Pribadi</h2>
                </div>

                <div class="flex flex-col md:flex-row gap-8 items-start">
                    <div class="flex flex-col items-center gap-3 min-w-[120px]">
                        <div class="relative group cursor-pointer w-24 h-24">
                            <div class="w-full h-full rounded-full overflow-hidden border-4 border-emerald-50 shadow-md">
                                @if($user->foto_profil)
                                    <img id="avatarPreview" src="{{ asset('storage/' . $user->foto_profil) }}" alt="Avatar" class="w-full h-full object-cover">
                                @else
                                    <div id="avatarPlaceholder" class="w-full h-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold text-3xl">
                                        {{ substr($user->nama, 0, 1) }}
                                    </div>
                                    <img id="avatarPreview" src="" alt="Avatar" class="w-full h-full object-cover hidden">
                                @endif
                            </div>
                            
                            <div class="absolute inset-0 bg-emerald-900/40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity" onclick="document.getElementById('fotoInput').click()">
                                <span class="material-symbols-outlined text-white">edit</span>
                            </div>

                            <button type="button" onclick="document.getElementById('fotoInput').click()" class="absolute bottom-0 right-0 bg-emerald-600 text-white rounded-full p-1.5 border-2 border-white shadow-sm hover:bg-emerald-700 transition-colors">
                                <span class="material-symbols-outlined text-[16px]">photo_camera</span>
                            </button>
                            
                            <input type="file" name="foto" id="fotoInput" class="hidden" accept="image/*" onchange="previewImage(this)">
                        </div>
                        <span class="text-sm font-medium text-emerald-900">{{ ucfirst($user->peran) }}</span>
                    </div>

                    <div class="flex-1 w-full grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-2">
                            <label class="text-sm font-semibold text-emerald-800">Nama Lengkap</label>
                            <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" class="w-full px-4 py-2.5 rounded-lg border border-emerald-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-emerald-900 placeholder:text-emerald-300 transition-all bg-emerald-50/30">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="text-sm font-semibold text-emerald-800">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-2.5 rounded-lg border border-emerald-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-emerald-900 placeholder:text-emerald-300 transition-all bg-emerald-50/30">
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-sm font-semibold text-emerald-800">Role</label>
                            <input type="text" value="{{ $user->peran == 'admin' ? 'Administrator (Full Access)' : 'Petugas' }}" disabled class="w-full px-4 py-2.5 rounded-lg border border-emerald-100 bg-emerald-50 text-emerald-500 cursor-not-allowed">
                        </div>
                        
                        <div class="md:col-span-2 flex justify-end">
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-lg font-bold shadow-lg shadow-emerald-600/20 transition-all active:scale-95 flex items-center gap-2">
                                <span class="material-symbols-outlined text-[20px]">save</span>
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <form id="passwordForm" action="{{ route('admin.profile.password') }}" method="POST" class="p-6 md:p-8 bg-emerald-50/30">
                @csrf
                <div class="flex flex-col gap-1 mb-6">
                    <h2 class="text-xl font-bold text-emerald-900">Ganti Password</h2>
                    <p class="text-sm text-emerald-600">Pastikan akun Anda aman dengan menggunakan password yang kuat.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-3xl">
                    <div class="md:col-span-2 max-w-md flex flex-col gap-2">
                        <label class="text-sm font-semibold text-emerald-800">Password Saat Ini</label>
                        <div class="relative">
                            <input type="password" name="current_password" class="w-full px-4 py-2.5 rounded-lg border border-emerald-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-emerald-900 placeholder:text-emerald-300 transition-all bg-white" placeholder="••••••••">
                            <button type="button" onclick="togglePassword(this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-emerald-400 hover:text-emerald-600 transition-colors">
                                <span class="material-symbols-outlined text-[20px]">visibility_off</span>
                            </button>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold text-emerald-800">Password Baru</label>
                        <div class="relative">
                            <input type="password" name="password" class="w-full px-4 py-2.5 rounded-lg border border-emerald-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-emerald-900 placeholder:text-emerald-300 transition-all bg-white" placeholder="Password baru">
                            <button type="button" onclick="togglePassword(this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-emerald-400 hover:text-emerald-600 transition-colors">
                                <span class="material-symbols-outlined text-[20px]">visibility_off</span>
                            </button>
                        </div>
                        <p class="text-xs text-emerald-500 mt-1">Min. 8 karakter (Huruf & Angka)</p>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold text-emerald-800">Konfirmasi Password</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" class="w-full px-4 py-2.5 rounded-lg border border-emerald-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-emerald-900 placeholder:text-emerald-300 transition-all bg-white" placeholder="Ulangi password baru">
                            <button type="button" onclick="togglePassword(this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-emerald-400 hover:text-emerald-600 transition-colors">
                                <span class="material-symbols-outlined text-[20px]">visibility_off</span>
                            </button>
                        </div>
                    </div>

                    <div class="md:col-span-2 flex justify-end mt-2">
                        <button type="submit" class="bg-white border border-emerald-200 hover:bg-emerald-50 text-emerald-700 px-6 py-2.5 rounded-lg font-bold transition-all active:scale-95 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[20px]">lock_reset</span>
                            Update Password
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('avatarPreview');
                    const placeholder = document.getElementById('avatarPlaceholder');
                    
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                    if(placeholder) placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function togglePassword(btn) {
            const input = btn.previousElementSibling;
            const icon = btn.querySelector('span');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerText = 'visibility';
            } else {
                input.type = 'password';
                icon.innerText = 'visibility_off';
            }
        }

        // AJAX Form Submission for Profile
        document.getElementById('profileForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            const btn = form.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            
            btn.disabled = true;
            btn.innerHTML = '<span class="material-symbols-outlined animate-spin text-[20px]">refresh</span> Menyimpan...';

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = originalText;
                
                if (data.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#059669'
                    });
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: data.message || 'Terjadi kesalahan validasi.',
                        icon: 'error',
                        confirmButtonColor: '#d33'
                    });
                }
            })
            .catch(error => {
                btn.disabled = false;
                btn.innerHTML = originalText;
                console.error(error);
                Swal.fire('Error', 'Terjadi kesalahan sistem.', 'error');
            });
        });

        // AJAX Form Submission for Password
        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            const btn = form.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            
            btn.disabled = true;
            btn.innerHTML = '<span class="material-symbols-outlined animate-spin text-[20px]">refresh</span> Memproses...';

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json().then(data => ({status: response.status, body: data})))
            .then(res => {
                btn.disabled = false;
                btn.innerHTML = originalText;
                
                if (res.status === 200 && res.body.success) {
                    form.reset();
                    Swal.fire({
                        title: 'Password Diubah!',
                        text: res.body.message,
                        icon: 'success',
                        confirmButtonColor: '#059669'
                    });
                } else {
                    let errorMsg = res.body.message || 'Gagal mengubah password.';
                    if (res.body.errors) {
                        errorMsg = Object.values(res.body.errors).flat().join('\n');
                    }
                    Swal.fire({
                        title: 'Gagal!',
                        text: errorMsg,
                        icon: 'error',
                        confirmButtonColor: '#d33'
                    });
                }
            })
            .catch(error => {
                btn.disabled = false;
                btn.innerHTML = originalText;
                Swal.fire('Error', 'Terjadi kesalahan sistem.', 'error');
            });
        });
    </script>
</x-layouts.admin>
