<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Tagihan;

class PetugasHomeController extends Controller
{
    public function index()
    {
        $petugas = auth()->user();
        $wilayahPetugas = $petugas->wilayah;
        
        $today = now();
        
        $filter = request('filter', 'semua');
        
        $query = Tagihan::with('pelanggan')
            ->whereHas('pelanggan', function ($q) use ($wilayahPetugas) {
                $q->aktif();
                if ($wilayahPetugas) {
                    $q->where('wilayah', $wilayahPetugas);
                }
            });

        if ($filter === 'jatuh_tempo') {
            $query->jatuhTempoHariIni()->belumBayar();
        } elseif ($filter === 'menunggak') {
            $query->menunggak();
        } else {
            $query->belumBayar();
        }

        $tagihan = $query->latest()->take(10)->get();

        $baseQuery = fn() => Tagihan::whereHas('pelanggan', function($q) use ($wilayahPetugas) {
            $q->aktif();
            if ($wilayahPetugas) {
                $q->where('wilayah', $wilayahPetugas);
            }
        });

        $jatuhTempo = $baseQuery()->jatuhTempoHariIni()->belumBayar()->count();
        $sudahBayar = $baseQuery()->whereDate('updated_at', $today)->where('status', 'lunas')->count();
        $menunggak = $baseQuery()->menunggak()->count();

        $transaksiHariIni = Pembayaran::byPetugas($petugas->id)
            ->disetujui()
            ->whereNull('setoran_id')
            ->get();

        $totalSaldo = $transaksiHariIni->sum('jumlah_bayar');
        $totalTransaksi = $transaksiHariIni->count();

        return view('petugas.home', compact(
            'tagihan', 
            'jatuhTempo', 
            'sudahBayar', 
            'menunggak',
            'totalSaldo',
            'totalTransaksi',
            'wilayahPetugas'
        ));
    }
}
