<x-layouts.admin title="Riwayat Settlement">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="h-full flex flex-col overflow-hidden">
        <div class="flex-1 p-4 md:p-6 lg:p-8 overflow-y-auto w-full">
            <div class="max-w-[1400px] mx-auto flex flex-col gap-6">

                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-2 text-sm">
                        <a href="{{ route('admin.settlement.index') }}"
                            class="text-orange-500 hover:text-orange-600">Settlement</a>
                        <span class="text-gray-300">/</span>
                        <span class="text-slate-900 font-medium">Riwayat</span>
                    </div>
                    <div class="flex justify-between items-end flex-wrap gap-4">
                        <div>
                            <h2 class="text-3xl md:text-4xl font-black tracking-tight text-slate-900 mb-2">Riwayat
                                Settlement</h2>
                            <p class="text-gray-500">Daftar semua setoran yang telah dikonfirmasi.</p>
                        </div>
                        <a href="{{ route('admin.settlement.index') }}"
                            class="flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors text-sm font-medium text-gray-700 hover:border-gray-300">
                            <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-5 rounded-xl bg-white shadow-sm border border-gray-100 flex flex-col gap-1">
                        <div class="flex justify-between items-start">
                            <p class="text-gray-500 text-sm font-medium">Total Disetor</p>
                            <span
                                class="material-symbols-outlined text-orange-500 bg-orange-50 p-1 rounded-md text-[20px]">account_balance</span>
                        </div>
                        <p class="text-2xl font-bold text-slate-900 mt-2">Rp
                            {{ number_format($totalSettled ?? 0, 0, ',', '.') }}</p>
                        <p class="text-xs text-orange-500 mt-1">Sepanjang waktu</p>
                    </div>
                    <div class="p-5 rounded-xl bg-white shadow-sm border border-gray-100 flex flex-col gap-1">
                        <div class="flex justify-between items-start">
                            <p class="text-gray-500 text-sm font-medium">Disetor Hari Ini</p>
                            <span
                                class="material-symbols-outlined text-blue-500 bg-blue-50 p-1 rounded-md text-[20px]">today</span>
                        </div>
                        <p class="text-2xl font-bold text-slate-900 mt-2">Rp
                            {{ number_format($todaySettled ?? 0, 0, ',', '.') }}</p>
                        <p class="text-xs text-blue-500 mt-1">{{ now()->format('d M Y') }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                    <div
                        class="p-4 border-b border-gray-100 flex flex-col md:flex-row gap-3 justify-between items-start md:items-center">
                        <h3 class="font-bold text-slate-900">Daftar Settlement</h3>
                        <form method="GET" class="flex flex-wrap gap-2" x-data="{ open: false }">
                            <input type="date" name="date" value="{{ request('date') }}"
                                class="rounded-lg border border-gray-200 px-3 py-2 text-sm focus:ring-2 focus:ring-orange-500 focus:outline-none"
                                onchange="this.form.submit()">
                            <select name="petugas_id" onchange="this.form.submit()"
                                class="rounded-lg border border-gray-200 px-3 py-2 text-sm focus:ring-2 focus:ring-orange-500 focus:outline-none">
                                <option value="">Semua Petugas</option>
                                @foreach ($petugasList as $p)
                                    <option value="{{ $p->id }}"
                                        {{ request('petugas_id') == $p->id ? 'selected' : '' }}>{{ $p->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @if (request('date') || request('petugas_id'))
                                <a href="{{ route('admin.settlement.history') }}"
                                    class="px-3 py-2 text-sm text-red-500 hover:text-red-700">Reset</a>
                            @endif
                        </form>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <th class="p-4 text-xs font-semibold text-gray-500 uppercase">ID</th>
                                <th class="p-4 text-xs font-semibold text-gray-500 uppercase">Petugas</th>
                                <th class="p-4 text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                                <th class="p-4 text-xs font-semibold text-gray-500 uppercase text-right">Jumlah
                                    Sistem</th>
                                <th class="p-4 text-xs font-semibold text-gray-500 uppercase text-right">Diterima
                                </th>
                                <th class="p-4 text-xs font-semibold text-gray-500 uppercase">Dikonfirmasi Oleh
                                </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($settlements as $s)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="p-4 text-sm text-gray-500 font-mono">
                                            #STL-{{ str_pad($s->id, 4, '0', STR_PAD_LEFT) }}</td>
                                        <td class="p-4">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 border border-orange-200 flex items-center justify-center font-bold text-xs">
                                                    {{ strtoupper(substr($s->petugas->nama ?? 'N', 0, 2)) }}
                                                </div>
                                                <span
                                                    class="text-sm font-medium text-slate-900">{{ $s->petugas->nama ?? 'N/A' }}</span>
                                            </div>
                                        </td>
                                        <td class="p-4 text-sm text-gray-600">
                                            {{ $s->tanggal_setor->format('d M Y, H:i') }}</td>
                                        <td class="p-4 text-sm text-slate-900 font-mono text-right">Rp
                                            {{ number_format($s->total_tagihan_sistem, 0, ',', '.') }}</td>
                                        <td class="p-4 text-sm font-bold text-green-600 font-mono text-right">Rp
                                            {{ number_format($s->total_uang_diterima, 0, ',', '.') }}</td>
                                        <td class="p-4 text-sm text-gray-500">
                                            {{ $s->konfirmator->nama ?? 'System' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-8 text-center text-gray-400">
                                            <span
                                                class="material-symbols-outlined text-[48px] block mb-2">receipt_long</span>
                                            Belum ada riwayat settlement
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($settlements->hasPages())
                        <div class="p-4 border-t border-gray-100">
                            {{ $settlements->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
