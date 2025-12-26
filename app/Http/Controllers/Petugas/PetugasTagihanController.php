<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class PetugasTagihanController extends Controller
{
    public function index(Request $request)
    {
        $petugas = auth()->user();
        $wilayahPetugas = $petugas->wilayah;
        
        $query = Tagihan::with('pelanggan')
            ->whereHas('pelanggan', function ($q) use ($wilayahPetugas) {
                $q->aktif();
                if ($wilayahPetugas) {
                    $q->where('wilayah', $wilayahPetugas);
                }
            })
            ->belumBayar();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('pelanggan', function ($q) use ($search, $wilayahPetugas) {
                $q->where(function($sub) use ($search) {
                    $sub->where('nama', 'like', "%{$search}%")
                        ->orWhere('alamat_lengkap', 'like', "%{$search}%")
                        ->orWhere('telepon', 'like', "%{$search}%");
                });
                if ($wilayahPetugas) {
                    $q->where('wilayah', $wilayahPetugas);
                }
            });
        }

        if ($request->filter === 'jatuh_tempo') {
            $query->jatuhTempoHariIni();
        } elseif ($request->filter === 'menunggak') {
            $query->menunggak();
        }

        $tagihan = $query->orderBy('jatuh_tempo', 'asc')->paginate(20)->withQueryString();

        return view('petugas.tagihan.index', compact('tagihan', 'wilayahPetugas'));
    }
}
