<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Pengguna;
use App\Models\Tagihan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPelanggan = Pelanggan::where('status', 'aktif')->count();
        
        $tagihanHariIni = Tagihan::whereDate('jatuh_tempo', today())
            ->where('status', 'belum_bayar')
            ->count();
        
        $pendingVerifikasi = Pembayaran::where('status', 'menunggu_admin')->count();
        
        $uangPetugas = Pembayaran::where('status', 'disetujui')
            ->whereNull('setoran_id')
            ->sum('jumlah_bayar');
        
        $recentPending = Pembayaran::with(['tagihan.pelanggan', 'petugas'])
            ->where('status', 'menunggu_admin')
            ->latest()
            ->take(5)
            ->get();
        
        $recentTransactions = Pembayaran::with(['tagihan.pelanggan', 'petugas'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalPelanggan',
            'tagihanHariIni',
            'pendingVerifikasi',
            'uangPetugas',
            'recentPending',
            'recentTransactions'
        ));
    }
}
