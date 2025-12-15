<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Keluhan;
use Illuminate\Http\Request;

class PelangganLaporController extends Controller
{
    public function create()
    {
        $pelangganId = session('pelanggan_id') ?? request('id');
        
        $laporanTerbaru = collect();
        
        if ($pelangganId) {
            $laporanTerbaru = Keluhan::where('pelanggan_id', $pelangganId)
                ->latest()
                ->take(5)
                ->get();
        }

        return view('pelanggan.lapor', compact('laporanTerbaru'));
    }

    public function store(Request $request)
    {
        $pelangganId = session('pelanggan_id') ?? request('pelanggan_id');
        
        if (!$pelangganId) {
            return back()->with('error', 'Pelanggan tidak ditemukan.');
        }

        $validated = $request->validate([
            'kategori' => 'required|string',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|max:5120',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('keluhan', 'public');
        }

        Keluhan::create([
            'pelanggan_id' => $pelangganId,
            'kategori' => $validated['kategori'],
            'deskripsi' => $validated['deskripsi'],
            'bukti_foto' => $fotoPath,
            'prioritas' => 'normal',
            'status' => 'terbuka',
        ]);

        return back()->with('success', 'Laporan berhasil dikirim. Kami akan segera menindaklanjuti.');
    }
}
