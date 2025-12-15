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

        return view('petugas.saldo', compact('transaksi', 'totalSaldo', 'totalTransaksi'));
    }
}
