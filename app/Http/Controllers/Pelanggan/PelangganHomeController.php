<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Tagihan;

class PelangganHomeController extends Controller
{
    public function index()
    {
        $pelangganId = session('pelanggan_id') ?? request('id');
        
        if (!$pelangganId) {
            return view('pelanggan.lookup');
        }

        $pelanggan = Pelanggan::with('jenisPelanggan')->findOrFail($pelangganId);
        
        $tagihanBulanIni = Tagihan::where('pelanggan_id', $pelanggan->id)
            ->whereMonth('jatuh_tempo', now()->month)
            ->whereYear('jatuh_tempo', now()->year)
            ->first();

        $statusBulanIni = $tagihanBulanIni?->status === 'lunas' ? 'paid' : 'unpaid';
        $nextDueDate = $tagihanBulanIni?->jatuh_tempo ?? now()->setDay($pelanggan->created_at->day);

        $petugas = (object)[
            'name' => 'Petugas Wilayah ' . $pelanggan->wilayah,
            'phone' => '081234567890',
            'status' => 'aktif',
        ];

        return view('pelanggan.home', compact('pelanggan', 'statusBulanIni', 'nextDueDate', 'petugas'));
    }
}
