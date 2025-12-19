<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisPelanggan;
use App\Models\Pelanggan;
use App\Models\Wilayah;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $tarifList = JenisPelanggan::withCount('pelanggan')->orderBy('nama_paket')->get();
        
        $wilayahList = Wilayah::withCount(['pelanggan' => function($query) {
            $query->whereColumn('pelanggan.wilayah', 'wilayah.nama');
        }])->orderBy('nama')->get();

        return view('admin.settings.index', compact('tarifList', 'wilayahList'));
    }

    public function storeTarif(Request $request)
    {
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:100',
            'harga_dasar' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        JenisPelanggan::create($validated);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Tarif berhasil ditambahkan.');
    }

    public function updateTarif(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:100',
            'harga_dasar' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        $tarif = JenisPelanggan::findOrFail($id);
        $tarif->update($validated);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Tarif berhasil diperbarui.');
    }

    public function destroyTarif($id)
    {
        $tarif = JenisPelanggan::withCount('pelanggan')->findOrFail($id);
        
        if ($tarif->pelanggan_count > 0) {
            return redirect()->route('admin.settings.index')
                ->with('error', "Tidak dapat menghapus tarif '{$tarif->nama_paket}' karena masih digunakan oleh {$tarif->pelanggan_count} pelanggan.");
        }

        $tarif->delete();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Tarif berhasil dihapus.');
    }

    public function storeWilayah(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:wilayah,nama',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        Wilayah::create($validated);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Wilayah berhasil ditambahkan.');
    }

    public function updateWilayah(Request $request, $id)
    {
        $wilayah = Wilayah::findOrFail($id);
        $oldNama = $wilayah->nama;
        
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:wilayah,nama,' . $id,
            'deskripsi' => 'nullable|string|max:500',
        ]);

        $wilayah->update($validated);
        
        if ($oldNama !== $validated['nama']) {
            Pelanggan::where('wilayah', $oldNama)->update(['wilayah' => $validated['nama']]);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Wilayah berhasil diperbarui.');
    }

    public function destroyWilayah($id)
    {
        $wilayah = Wilayah::findOrFail($id);
        $pelangganCount = Pelanggan::where('wilayah', $wilayah->nama)->count();
        
        if ($pelangganCount > 0) {
            return redirect()->route('admin.settings.index')
                ->with('error', "Tidak dapat menghapus wilayah '{$wilayah->nama}' karena masih digunakan oleh {$pelangganCount} pelanggan.");
        }

        $wilayah->delete();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Wilayah berhasil dihapus.');
    }
}
