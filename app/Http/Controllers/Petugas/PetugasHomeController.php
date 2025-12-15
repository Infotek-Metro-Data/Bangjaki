<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;

class PetugasHomeController extends Controller
{
    public function index()
    {
        $petugas = auth()->user();
        
        // Get today's date for filtering
        $today = now();
        
        // Get tagihan based on filter
        $filter = request('filter', 'semua');
        
        $query = Tagihan::with('pelanggan')
            ->whereHas('pelanggan', function ($q) {
                $q->aktif();
            });

        if ($filter === 'jatuh_tempo') {
            $query->jatuhTempoHariIni()->belumBayar();
        } elseif ($filter === 'menunggak') {
            $query->menunggak();
        } else {
            $query->belumBayar();
        }

        $tagihan = $query->get();

        // Stats
        $jatuhTempo = Tagihan::jatuhTempoHariIni()->belumBayar()->count();
        $sudahBayar = Tagihan::whereDate('updated_at', $today)->where('status', 'lunas')->count();
        $menunggak = Tagihan::menunggak()->count();

        return view('petugas.home', compact('tagihan', 'jatuhTempo', 'sudahBayar', 'menunggak'));
    }
}
