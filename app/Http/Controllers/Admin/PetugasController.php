<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengguna::where('peran', 'petugas');
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%");
            });
        }
        
        $petugas = $query->latest()->paginate(10)->withQueryString();
        
        $totalPetugas = Pengguna::where('peran', 'petugas')->count();
        $petugasAktif = Pengguna::where('peran', 'petugas')->where('status', 'aktif')->count();
        $petugasIstirahat = Pengguna::where('peran', 'petugas')->where('status', 'istirahat')->count();
        
        return view('admin.petugas.index', compact('petugas', 'totalPetugas', 'petugasAktif', 'petugasIstirahat'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|min:8',
            'telepon' => 'required|string|max:20',
            'nomor_kendaraan' => 'nullable|string|max:20',
            'status' => 'required|in:aktif,istirahat,nonaktif',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $validated['password'] = Hash::make($validated['password']);
        $validated['peran'] = 'petugas';
        
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoPath = $foto->store('petugas', 'public');
            $validated['foto_profil'] = $fotoPath;
        }
        
        unset($validated['foto']);
        
        Pengguna::create($validated);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Petugas berhasil ditambahkan!']);
        }
        return back()->with('success', 'Petugas berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $petugas = Pengguna::where('peran', 'petugas')->findOrFail($id);
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email,' . $id,
            'telepon' => 'required|string|max:20',
            'nomor_kendaraan' => 'nullable|string|max:20',
            'status' => 'required|in:aktif,istirahat,nonaktif',
        ]);
        
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8']);
            $validated['password'] = Hash::make($request->password);
        }
        
        $petugas->update($validated);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Data petugas berhasil diperbarui!']);
        }
        return back()->with('success', 'Data petugas berhasil diperbarui!');
    }

    public function destroy(Request $request, $id)
    {
        $petugas = Pengguna::where('peran', 'petugas')->findOrFail($id);
        $petugas->delete();
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Petugas berhasil dihapus!']);
        }
        return back()->with('success', 'Petugas berhasil dihapus!');
    }
}
