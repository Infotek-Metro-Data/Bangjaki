<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $pelanggan = Auth::guard('pelanggan')->user();
        
        $tagihanIds = Tagihan::where('pelanggan_id', $pelanggan->id)->pluck('id');
        
        $query = Pembayaran::with(['tagihan', 'petugas'])
            ->whereIn('tagihan_id', $tagihanIds);
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }
        
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        $pembayaran = $query->latest()->paginate(10)->withQueryString();
        
        $totalDibayar = Pembayaran::whereIn('tagihan_id', $tagihanIds)
            ->where('status', 'disetujui')
            ->sum('jumlah_bayar');

        return view('pelanggan.riwayat.index', compact('pembayaran', 'totalDibayar', 'pelanggan'));
    }
}
