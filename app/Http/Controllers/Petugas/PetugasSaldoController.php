<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;

class PetugasSaldoController extends Controller
{
    public function index()
    {
        $petugas = auth()->user();
        
        $transaksi = Pembayaran::with('tagihan.pelanggan')
            ->byPetugas($petugas->id)
            ->disetujui()
            ->whereNull('setoran_id')
            ->latest()
            ->get();

        $totalSaldo = $transaksi->sum('jumlah_bayar');
        $totalTransaksi = $transaksi->count();

        $sudahDisetor = Pembayaran::byPetugas($petugas->id)
            ->disetujui()
            ->whereNotNull('setoran_id')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('jumlah_bayar');

        $pending = Pembayaran::byPetugas($petugas->id)
            ->where('status', 'menunggu_admin')
            ->count();

        return view('petugas.saldo.index', compact(
            'transaksi', 
            'totalSaldo', 
            'totalTransaksi',
            'sudahDisetor',
            'pending'
        ));
    }
}

