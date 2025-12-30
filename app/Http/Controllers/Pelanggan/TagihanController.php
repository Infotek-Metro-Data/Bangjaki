<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagihanController extends Controller
{
    public function index(Request $request)
    {
        $pelanggan = Auth::guard('pelanggan')->user();
        
        $query = Tagihan::with('pembayaran')
            ->where('pelanggan_id', $pelanggan->id);
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('tahun')) {
            $query->whereYear('periode_mulai', $request->tahun);
        }

        $tagihan = $query->latest()->paginate(10)->withQueryString();
        
        $stats = [
            'total' => Tagihan::where('pelanggan_id', $pelanggan->id)->count(),
            'lunas' => Tagihan::where('pelanggan_id', $pelanggan->id)->where('status', 'lunas')->count(),
            'belum_bayar' => Tagihan::where('pelanggan_id', $pelanggan->id)->where('status', 'belum_bayar')->count(),
            'menunggu' => Tagihan::where('pelanggan_id', $pelanggan->id)->where('status', 'menunggu_verifikasi')->count(),
        ];

        return view('pelanggan.tagihan.index', compact('tagihan', 'stats', 'pelanggan'));
    }
}
