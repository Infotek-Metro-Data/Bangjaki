<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Carbon\Carbon;

class PetugasRiwayatController extends Controller
{
    public function index()
    {
        $petugas = auth()->user();
        
        $query = Pembayaran::with('tagihan.pelanggan')
            ->byPetugas($petugas->id);

        if (request('status') && request('status') !== 'all') {
            $query->where('status', request('status'));
        }

        if (request('metode') && request('metode') !== 'all') {
            $query->where('metode', request('metode'));
        }

        if (request('periode') === '7days') {
            $query->where('created_at', '>=', now()->subDays(7));
        } elseif (request('periode') === '30days') {
            $query->where('created_at', '>=', now()->subDays(30));
        } elseif (request('periode') === 'thismonth') {
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
        }

        if (request('search')) {
            $search = request('search');
            $query->whereHas('tagihan.pelanggan', function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            });
        }

        $pembayaran = $query->latest()->paginate(10);

        $totalBulanIni = Pembayaran::byPetugas($petugas->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->disetujui()
            ->sum('jumlah_bayar');

        $pending = Pembayaran::byPetugas($petugas->id)
            ->where('status', 'menunggu_admin')
            ->count();

        $settled = Pembayaran::byPetugas($petugas->id)
            ->disetujui()
            ->count();

        return view('petugas.riwayat.index', compact(
            'pembayaran',
            'totalBulanIni',
            'pending',
            'settled'
        ));
    }
}
