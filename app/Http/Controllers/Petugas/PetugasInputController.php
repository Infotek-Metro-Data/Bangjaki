<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\MetodePembayaran;
use App\Models\Pembayaran;
use App\Models\StatusPembayaran;
use App\Models\StatusTagihan;
use App\Models\Tagihan;
use Illuminate\Http\Request;

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

        $metode = MetodePembayaran::where('kode', $validated['metode'])->first();
        $statusDikumpulkan = StatusPembayaran::where('kode', 'dikumpulkan')->first();
        $statusMenungguVerifikasi = StatusTagihan::where('kode', 'menunggu_verifikasi')->first();

        $pembayaran = Pembayaran::create([
            'tagihan_id' => $validated['tagihan_id'],
            'petugas_id' => auth()->id(),
            'jumlah_bayar' => $validated['nominal'],
            'metode_id' => $metode->id,
            'bukti_foto' => $fotoPaths,
            'catatan' => $validated['catatan'] ?? null,
            'tanggal_bayar' => now(),
            'status_id' => $statusDikumpulkan->id,
        ]);

        Tagihan::where('id', $validated['tagihan_id'])
            ->update(['status_id' => $statusMenungguVerifikasi->id]);

        return redirect()->route('petugas.home')
            ->with('success', 'Pembayaran berhasil diinput. Uang dikumpulkan di saldo Anda.');
    }
}
