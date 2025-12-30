<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $pelanggan = Auth::guard('pelanggan')->user();
        
        $totalTagihan = Tagihan::where('pelanggan_id', $pelanggan->id)->count();
        $tagihanLunas = Tagihan::where('pelanggan_id', $pelanggan->id)->where('status', 'lunas')->count();
        $tagihanBelumBayar = Tagihan::where('pelanggan_id', $pelanggan->id)->where('status', 'belum_bayar')->count();
        $tagihanMenunggu = Tagihan::where('pelanggan_id', $pelanggan->id)->where('status', 'menunggu_verifikasi')->count();
        
        $tagihanTerbaru = Tagihan::with('pembayaran')
            ->where('pelanggan_id', $pelanggan->id)
            ->latest()
            ->take(5)
            ->get();
        
        $totalTunggakan = Tagihan::where('pelanggan_id', $pelanggan->id)
            ->where('status', 'belum_bayar')
            ->sum('jumlah_tagihan');

        return view('pelanggan.dashboard', compact(
            'pelanggan',
            'totalTagihan',
            'tagihanLunas',
            'tagihanBelumBayar',
            'tagihanMenunggu',
            'tagihanTerbaru',
            'totalTunggakan'
        ));
    }
}
