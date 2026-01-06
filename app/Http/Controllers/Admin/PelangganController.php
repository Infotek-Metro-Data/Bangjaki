<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisPelanggan;
use App\Models\Pelanggan;
use App\Models\Wilayah;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelanggan::with('jenisPelanggan');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%")
                  ->orWhere('alamat_lengkap', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('wilayah')) {
            $query->where('wilayah', $request->wilayah);
        }
        
        $pelanggan = $query->latest()->paginate(10)->withQueryString();
        $jenisPelanggan = JenisPelanggan::orderBy('nama_paket')->get();
        $wilayahList = Wilayah::orderBy('nama')->get();
        
        return view('admin.pelanggan.index', compact('pelanggan', 'jenisPelanggan', 'wilayahList'));
    }

    public function show($id)
    {
        $pelanggan = Pelanggan::with(['jenisPelanggan'])->findOrFail($id);
        
        $tagihan = \App\Models\Tagihan::with(['pembayaran.petugas'])
            ->where('pelanggan_id', $id)
            ->latest()
            ->paginate(10);
        
        $totalTagihan = \App\Models\Tagihan::where('pelanggan_id', $id)->count();
        $tagihanLunas = \App\Models\Tagihan::where('pelanggan_id', $id)->where('status', 'lunas')->count();
        $tagihanBelumBayar = \App\Models\Tagihan::where('pelanggan_id', $id)->where('status', 'belum_bayar')->count();
        $totalPembayaran = \App\Models\Pembayaran::whereHas('tagihan', fn($q) => $q->where('pelanggan_id', $id))
            ->where('status', 'disetujui')
            ->sum('jumlah_bayar');
        
        return view('admin.pelanggan.show', compact(
            'pelanggan', 
            'tagihan', 
            'totalTagihan', 
            'tagihanLunas', 
            'tagihanBelumBayar',
            'totalPembayaran'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_pelanggan_id' => 'required|exists:jenis_pelanggan,id',
            'telepon' => 'required|string|max:20',
            'alamat_lengkap' => 'required|string',
            'wilayah' => 'required|string|max:100',
            'email' => 'nullable|email|unique:pelanggan,email',
            'iuran_khusus' => 'nullable|numeric|min:0',
            'password' => 'nullable|string|min:8',
            'foto_rumah' => 'required|image|max:5120',
        ]);
        
        $statusAktif = \App\Models\StatusPelanggan::where('kode', 'aktif')->first();
        $validated['status_id'] = $statusAktif->id;
        
        if (empty($validated['password'])) {
            unset($validated['password']);
        }
        
        if ($request->hasFile('foto_rumah')) {
            $validated['foto_rumah'] = $request->file('foto_rumah')->store('foto-rumah', 'public');
        }
        
        Pelanggan::create($validated);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Pelanggan berhasil ditambahkan!']);
        }
        return back()->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_pelanggan_id' => 'required|exists:jenis_pelanggan,id',
            'telepon' => 'required|string|max:20',
            'alamat_lengkap' => 'required|string',
            'wilayah' => 'required|string|max:100',
            'email' => 'nullable|email|unique:pelanggan,email,' . $id,
            'iuran_khusus' => 'nullable|numeric|min:0',
            'status' => 'required|in:aktif,nonaktif',
        ]);
        
        $pelanggan->update($validated);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Data pelanggan berhasil diperbarui!']);
        }
        return back()->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    public function destroy(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Pelanggan berhasil dihapus!']);
        }
        return back()->with('success', 'Pelanggan berhasil dihapus!');
    }
}
