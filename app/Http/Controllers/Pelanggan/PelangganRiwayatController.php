<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Tagihan;

class PelangganRiwayatController extends Controller
{
    public function index()
    {
        $pelangganId = session('pelanggan_id') ?? request('id');
        
        if (!$pelangganId) {
            return redirect()->route('pelanggan.home');
        }

        $riwayat = Tagihan::where('pelanggan_id', $pelangganId)
            ->with('pembayaran')
            ->latest('periode_mulai')
            ->get()
            ->map(function ($tagihan) {
                $tagihan->periode = $tagihan->periode_mulai;
                $tagihan->tanggal_bayar = $tagihan->pembayaran->first()?->created_at;
                $tagihan->nominal = $tagihan->jumlah_tagihan;
                return $tagihan;
            });

        $totalDibayar = $riwayat->where('status', 'lunas')->sum('jumlah_tagihan');
        $bulanLunas = $riwayat->where('status', 'lunas')->count();

        return view('pelanggan.riwayat', compact('riwayat', 'totalDibayar', 'bulanLunas'));
    }
}
