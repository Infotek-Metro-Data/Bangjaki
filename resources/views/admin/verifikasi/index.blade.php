<x-layouts.admin title="Verifikasi Pembayaran">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <div class="h-full flex flex-col overflow-hidden">
        <div class="flex-1 p-4 md:p-6 lg:p-8 overflow-y-auto">
            <div class="max-w-[1600px] mx-auto flex flex-col gap-6">
                
                <div class="flex flex-col gap-4">
                    <div class="flex flex-wrap gap-2 items-center text-sm">
                        <a href="{{ route('admin.dashboard') }}" class="text-emerald-600 hover:text-emerald-800 font-medium">Dashboard</a>
                        <span class="text-emerald-400">/</span>
                        <span class="text-emerald-900 font-medium">Verifikasi Pembayaran</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 pb-4 border-b border-emerald-100">
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-emerald-900 mb-1">Verifikasi Pembayaran</h1>
                            <p class="text-emerald-600 text-sm">Review bukti pembayaran dan setujui atau tolak transaksi.</p>
                        </div>
                        @if(isset($currentPayment))
                        <div class="flex gap-2">
                            <button class="flex items-center gap-2 px-3 py-2 rounded-lg border border-emerald-200 bg-white hover:bg-emerald-50 text-emerald-700 text-sm font-medium transition-colors">
                                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                                <span class="hidden sm:inline">Sebelumnya</span>
                            </button>
                            <button class="flex items-center gap-2 px-3 py-2 rounded-lg border border-emerald-200 bg-white hover:bg-emerald-50 text-emerald-700 text-sm font-medium transition-colors">
                                <span class="hidden sm:inline">Selanjutnya</span>
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </button>
                        </div>
                        @endif
                    </div>
                </div>

                @if(isset($currentPayment) && $currentPayment)
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                    
                    <section class="lg:col-span-7 flex flex-col">
                        <div class="bg-white rounded-xl border border-emerald-100 overflow-hidden shadow-sm flex flex-col h-full">
                            <div class="px-4 md:px-6 py-4 border-b border-emerald-100 flex justify-between items-center bg-emerald-50">
                                <h3 class="font-bold text-emerald-900 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-emerald-600">image</span>
                                    Bukti Pembayaran
                                </h3>
                                <div class="flex gap-1">
                                    <button onclick="rotateImage()" class="p-2 hover:bg-emerald-100 rounded-full transition-colors text-emerald-600" title="Putar">
                                        <span class="material-symbols-outlined text-[20px]">rotate_left</span>
                                    </button>
                                    <button onclick="zoomImage()" class="p-2 hover:bg-emerald-100 rounded-full transition-colors text-emerald-600" title="Projeksi">
                                        <span class="material-symbols-outlined text-[20px]">zoom_in</span>
                                    </button>
                                    <button onclick="openFullImage()" class="p-2 hover:bg-emerald-100 rounded-full transition-colors text-emerald-600" title="Buka di tab baru">
                                        <span class="material-symbols-outlined text-[20px]">open_in_new</span>
                                    </button>
                                </div>
                            </div>
                            <div class="relative bg-emerald-50/50 flex-1 min-h-[300px] md:min-h-[450px] flex items-center justify-center p-4 overflow-hidden">
                                @if($currentPayment->foto_bukti)
                                    <img id="paymentProofImg" 
                                         src="{{ asset('storage/' . $currentPayment->foto_bukti) }}" 
                                         alt="Bukti Pembayaran" 
                                         class="max-w-full max-h-full object-contain shadow-lg rounded-lg transition-transform duration-300"
                                         style="transform: scale(1) rotate(0deg);">
                                @else
                                    <div class="text-center">
                                        <span class="material-symbols-outlined text-[64px] text-emerald-300">image_not_supported</span>
                                        <p class="text-emerald-600 mt-2">Tidak ada bukti pembayaran</p>
                                    </div>
                                @endif
                            </div>
                            <div class="bg-white px-4 md:px-6 py-3 border-t border-emerald-100 text-xs text-emerald-600 flex justify-between">
                                <span>Diupload: {{ $currentPayment->created_at->format('d M Y, H:i') }}</span>
                                <span>ID: #PBY-{{ str_pad($currentPayment->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </div>
                    </section>

                    <section class="lg:col-span-5 flex flex-col gap-4 md:gap-6">
                        <div class="bg-white rounded-xl border border-emerald-100 shadow-sm p-4 md:p-6">
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <p class="text-sm text-emerald-600 font-medium mb-1">Total Pembayaran</p>
                                    <h2 class="text-2xl md:text-3xl font-bold text-emerald-900">Rp {{ number_format($currentPayment->jumlah_bayar, 0, ',', '.') }}</h2>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-sm font-bold border border-amber-200">
                                    Menunggu
                                </span>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4 pb-4 border-b border-emerald-100">
                                    <div>
                                        <p class="text-xs text-emerald-500 uppercase tracking-wider font-semibold mb-1">ID Transaksi</p>
                                        <p class="text-sm font-medium text-emerald-900 font-mono">#PBY-{{ str_pad($currentPayment->id, 4, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-emerald-500 uppercase tracking-wider font-semibold mb-1">Tanggal</p>
                                        <p class="text-sm font-medium text-emerald-900">{{ $currentPayment->tanggal_bayar->format('d M Y') }}</p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4 pb-4 border-b border-emerald-100">
                                    <div>
                                        <p class="text-xs text-emerald-500 uppercase tracking-wider font-semibold mb-1">Metode</p>
                                        <div class="flex items-center gap-2">
                                            <div class="bg-emerald-100 p-1 rounded text-emerald-600">
                                                <span class="material-symbols-outlined text-[16px]">payments</span>
                                            </div>
                                            <p class="text-sm font-medium text-emerald-900">{{ ucfirst($currentPayment->metode ?? 'Tunai') }}</p>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-xs text-emerald-500 uppercase tracking-wider font-semibold mb-1">Periode</p>
                                        <p class="text-sm font-medium text-emerald-900">{{ $currentPayment->tagihan->periode ?? '-' }}</p>
                                    </div>
                                </div>
                                
                                <div class="pb-4 border-b border-emerald-100">
                                    <p class="text-xs text-emerald-500 uppercase tracking-wider font-semibold mb-2">Info Pelanggan</p>
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-emerald-200 flex items-center justify-center text-emerald-800 font-bold text-sm">
                                            {{ strtoupper(substr($currentPayment->tagihan->pelanggan->nama ?? 'N', 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-emerald-900">{{ $currentPayment->tagihan->pelanggan->nama ?? 'N/A' }}</p>
                                            <p class="text-xs text-emerald-600">{{ $currentPayment->tagihan->pelanggan->telepon ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <p class="text-xs text-emerald-500 uppercase tracking-wider font-semibold mb-2">Petugas</p>
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-sm">
                                            {{ strtoupper(substr($currentPayment->petugas->nama ?? 'P', 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-emerald-900">{{ $currentPayment->petugas->nama ?? 'N/A' }}</p>
                                            <p class="text-xs text-emerald-600">{{ $currentPayment->petugas->telepon ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl border border-emerald-100 shadow-sm p-4 md:p-6">
                            <h3 class="font-bold text-emerald-900 mb-4">Keputusan Verifikasi</h3>
                            <form id="verificationForm" class="flex flex-col gap-4">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-emerald-700 mb-2">Catatan (Opsional)</label>
                                    <textarea id="verificationNotes" class="w-full bg-emerald-50 border border-emerald-200 rounded-lg p-3 text-sm text-emerald-900 focus:ring-2 focus:ring-emerald-500 focus:border-transparent min-h-[80px] resize-none placeholder:text-emerald-400" placeholder="Masukkan alasan jika menolak, atau catatan untuk persetujuan..."></textarea>
                                </div>
                                <div class="flex gap-3 pt-2">
                                    <button type="button" onclick="rejectPayment({{ $currentPayment->id }})" class="flex-1 bg-red-50 text-red-600 border border-red-200 hover:bg-red-100 font-bold py-3 rounded-lg transition-all flex items-center justify-center gap-2">
                                        <span class="material-symbols-outlined text-[20px]">close</span>
                                        Tolak
                                    </button>
                                    <button type="button" onclick="approvePayment({{ $currentPayment->id }})" class="flex-[2] bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-lg shadow-sm transition-all flex items-center justify-center gap-2">
                                        <span class="material-symbols-outlined text-[20px]">check</span>
                                        Setujui
                                    </button>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
                @endif

                <section>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg md:text-xl font-bold text-emerald-900">Antrian Pending</h2>
                        <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-sm font-bold">{{ $pendingPayments->count() ?? 0 }} transaksi</span>
                    </div>
                    
                    <div class="rounded-xl border border-emerald-100 bg-white overflow-hidden shadow-sm">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-emerald-50 border-b border-emerald-100">
                                        <th class="px-4 md:px-6 py-4 text-xs font-semibold text-emerald-700 uppercase tracking-wider">ID</th>
                                        <th class="hidden sm:table-cell px-4 md:px-6 py-4 text-xs font-semibold text-emerald-700 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-4 md:px-6 py-4 text-xs font-semibold text-emerald-700 uppercase tracking-wider">Pelanggan</th>
                                        <th class="px-4 md:px-6 py-4 text-xs font-semibold text-emerald-700 uppercase tracking-wider">Jumlah</th>
                                        <th class="hidden md:table-cell px-4 md:px-6 py-4 text-xs font-semibold text-emerald-700 uppercase tracking-wider">Petugas</th>
                                        <th class="px-4 md:px-6 py-4 text-xs font-semibold text-emerald-700 uppercase tracking-wider">Status</th>
                                        <th class="px-4 md:px-6 py-4 text-xs font-semibold text-emerald-700 uppercase tracking-wider text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-emerald-50">
                                    @forelse($pendingPayments ?? [] as $payment)
                                        <tr class="hover:bg-emerald-50/50 transition-colors {{ isset($currentPayment) && $currentPayment->id === $payment->id ? 'bg-emerald-50' : '' }}">
                                            <td class="px-4 md:px-6 py-4 text-sm font-medium text-emerald-700">#PBY-{{ str_pad($payment->id, 4, '0', STR_PAD_LEFT) }}</td>
                                            <td class="hidden sm:table-cell px-4 md:px-6 py-4 text-sm text-emerald-600">{{ $payment->tanggal_bayar->format('d M, H:i') }}</td>
                                            <td class="px-4 md:px-6 py-4">
                                                <div class="flex items-center gap-2">
                                                    <div class="hidden sm:flex h-8 w-8 rounded-full bg-emerald-200 items-center justify-center text-emerald-800 text-xs font-bold">
                                                        {{ strtoupper(substr($payment->tagihan->pelanggan->nama ?? 'N', 0, 2)) }}
                                                    </div>
                                                    <span class="text-sm font-medium text-emerald-900 truncate max-w-[120px]">{{ $payment->tagihan->pelanggan->nama ?? 'N/A' }}</span>
                                                </div>
                                            </td>
                                            <td class="px-4 md:px-6 py-4 text-sm font-bold text-emerald-900">Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</td>
                                            <td class="hidden md:table-cell px-4 md:px-6 py-4 text-sm text-emerald-600">{{ $payment->petugas->nama ?? '-' }}</td>
                                            <td class="px-4 md:px-6 py-4">
                                                @php
                                                    $statusClass = match($payment->status) {
                                                        'disetujui' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                                        'ditolak' => 'bg-red-100 text-red-700 border-red-200',
                                                        default => 'bg-amber-100 text-amber-700 border-amber-200',
                                                    };
                                                    $statusLabel = match($payment->status) {
                                                        'disetujui' => 'Disetujui',
                                                        'ditolak' => 'Ditolak',
                                                        default => 'Pending',
                                                    };
                                                @endphp
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold border {{ $statusClass }}">
                                                    {{ $statusLabel }}
                                                </span>
                                            </td>
                                            <td class="px-4 md:px-6 py-4 text-right">
                                                @if($payment->status === 'menunggu_admin')
                                                    <a href="{{ route('admin.verifikasi.show', $payment->id) }}" class="text-emerald-600 font-bold text-sm hover:text-emerald-800 hover:underline">Verifikasi</a>
                                                @else
                                                    <button onclick="showPaymentDetail({{ json_encode($payment) }})" class="text-emerald-500 text-sm hover:text-emerald-700">Detail</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-12 text-center">
                                                <span class="material-symbols-outlined text-[48px] text-emerald-300">task_alt</span>
                                                <p class="text-emerald-600 mt-2">Tidak ada pembayaran yang perlu diverifikasi</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script>
        let currentRotation = 0;
        let currentScale = 1;

        function rotateImage() {
            currentRotation = (currentRotation - 90) % 360;
            updateImageTransform();
        }

        function zoomImage() {
            currentScale = currentScale === 1 ? 2 : 1;
            updateImageTransform();
        }

        function updateImageTransform() {
            const img = document.getElementById('paymentProofImg');
            if (img) {
                img.style.transform = `scale(${currentScale}) rotate(${currentRotation}deg)`;
            }
        }

        function openFullImage() {
            @if(isset($currentPayment) && $currentPayment->foto_bukti)
                window.open('{{ asset('storage/' . $currentPayment->foto_bukti) }}', '_blank');
            @endif
        }

        function approvePayment(id) {
            const notes = document.getElementById('verificationNotes').value;
            
            Swal.fire({
                title: 'Setujui Pembayaran?',
                text: 'Transaksi ini akan ditandai sebagai diverifikasi.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Setujui',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = new FormData();
                    form.append('_token', '{{ csrf_token() }}');
                    form.append('catatan', notes);

                    fetch(`/admin/verifikasi/${id}/approve`, {
                        method: 'POST',
                        body: form
                    }).then(response => {
                        if (response.ok) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Pembayaran telah disetujui.',
                                icon: 'success',
                                confirmButtonColor: '#059669',
                                draggable: true
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Error!', 'Gagal menyetujui pembayaran.', 'error');
                        }
                    });
                }
            });
        }

        function rejectPayment(id) {
            const notes = document.getElementById('verificationNotes').value;

            if (!notes.trim()) {
                Swal.fire({
                    title: 'Catatan Diperlukan',
                    text: 'Masukkan alasan penolakan terlebih dahulu.',
                    icon: 'warning',
                    confirmButtonColor: '#059669'
                });
                return;
            }

            Swal.fire({
                title: 'Tolak Pembayaran?',
                text: 'Transaksi ini akan ditandai sebagai ditolak.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = new FormData();
                    form.append('_token', '{{ csrf_token() }}');
                    form.append('catatan', notes);

                    fetch(`/admin/verifikasi/${id}/reject`, {
                        method: 'POST',
                        body: form
                    }).then(response => {
                        if (response.ok) {
                            Swal.fire({
                                title: 'Ditolak!',
                                text: 'Pembayaran telah ditolak.',
                                icon: 'success',
                                confirmButtonColor: '#059669'
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Error!', 'Gagal menolak pembayaran.', 'error');
                        }
                    });
                }
            });
        }

        function showPaymentDetail(payment) {
            const statusLabel = payment.status === 'disetujui' ? 'Disetujui' : payment.status === 'ditolak' ? 'Ditolak' : 'Pending';
            const statusColor = payment.status === 'disetujui' ? 'green' : payment.status === 'ditolak' ? 'red' : 'yellow';
            
            Swal.fire({
                title: '<strong>Detail Pembayaran</strong>',
                icon: 'info',
                html: `
                    <div class="text-left space-y-3 text-sm">
                        <div class="grid grid-cols-2 gap-2">
                            <div class="text-gray-500">ID:</div>
                            <div class="font-medium">#PBY-${String(payment.id).padStart(4, '0')}</div>
                            
                            <div class="text-gray-500">Jumlah:</div>
                            <div class="font-bold">Rp ${Number(payment.jumlah_bayar).toLocaleString('id-ID')}</div>
                            
                            <div class="text-gray-500">Status:</div>
                            <div><span class="px-2 py-0.5 rounded-full text-xs font-medium bg-${statusColor}-100 text-${statusColor}-700">${statusLabel}</span></div>
                        </div>
                    </div>
                `,
                showCloseButton: true,
                showConfirmButton: false
            });
        }

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
