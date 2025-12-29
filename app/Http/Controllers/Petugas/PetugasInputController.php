<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PetugasInputController extends Controller
{
    public function create(Request $request)
    {
        $tagihan = null;
        
        if ($request->tagihan_id) {
            $tagihan = Tagihan::with('pelanggan')->findOrFail($request->tagihan_id);
        }

        return view('petugas.input.create', compact('tagihan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tagihan_id' => 'required|exists:tagihan,id',
            'nominal' => 'required|numeric|min:0',
            'metode' => 'required|in:tunai,transfer',
            'bukti_foto' => 'required|array|min:1|max:5',
            'bukti_foto.*' => 'image|max:5120',
            'catatan' => 'nullable|string|max:500',
        ]);

        $fotoPaths = [];
        foreach ($request->file('bukti_foto') as $foto) {
            $fotoPaths[] = $foto->store('bukti-pembayaran', 'public');
        }

        $pembayaran = Pembayaran::create([
            'tagihan_id' => $validated['tagihan_id'],
            'petugas_id' => auth()->id(),
            'jumlah_bayar' => $validated['nominal'],
            'metode' => $validated['metode'],
            'bukti_foto' => $fotoPaths,
            'catatan' => $validated['catatan'] ?? null,
            'tanggal_bayar' => now(),
            'status' => 'menunggu_admin',
        ]);

        Tagihan::where('id', $validated['tagihan_id'])
            ->update(['status' => 'menunggu_verifikasi']);

        return redirect()->route('petugas.home')
            ->with('success', 'Pembayaran berhasil diinput. Menunggu verifikasi admin.');
    }
}
