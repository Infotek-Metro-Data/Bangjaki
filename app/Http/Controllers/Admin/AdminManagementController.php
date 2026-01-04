<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use App\Models\PeranPengguna;
use App\Models\StatusPengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengguna::whereHas('peranPengguna', fn($q) => $q->where('kode', 'admin'));
        
        if ($request->filled('status')) {
            $query->whereHas('statusPengguna', fn($q) => $q->where('kode', $request->status));
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%");
            });
        }
        
        $admins = $query->latest()->paginate(10)->withQueryString();
        
        $totalAdmin = Pengguna::whereHas('peranPengguna', fn($q) => $q->where('kode', 'admin'))->count();
        $adminAktif = Pengguna::whereHas('peranPengguna', fn($q) => $q->where('kode', 'admin'))
            ->whereHas('statusPengguna', fn($q) => $q->where('kode', 'aktif'))->count();
        
        return view('admin.admins.index', compact('admins', 'totalAdmin', 'adminAktif'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|min:8',
            'telepon' => 'required|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $peranAdmin = PeranPengguna::where('kode', 'admin')->first();
        $statusAktif = StatusPengguna::where('kode', 'aktif')->first();
        
        $validated['password'] = Hash::make($validated['password']);
        $validated['peran_id'] = $peranAdmin->id;
        $validated['status_id'] = $statusAktif->id;
        
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoPath = $foto->store('admin', 'public');
            $validated['foto_profil'] = $fotoPath;
        }
        
        unset($validated['foto']);
        
        Pengguna::create($validated);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Admin berhasil ditambahkan!']);
        }
        return back()->with('success', 'Admin berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $admin = Pengguna::whereHas('peranPengguna', fn($q) => $q->where('kode', 'admin'))->findOrFail($id);
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email,' . $id,
            'telepon' => 'required|string|max:20',
            'status' => 'required|in:aktif,nonaktif',
        ]);
        
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8']);
            $validated['password'] = Hash::make($request->password);
        }
        
        if ($request->status) {
            $status = StatusPengguna::where('kode', $request->status)->first();
            $validated['status_id'] = $status->id;
            unset($validated['status']);
        }
        
        $admin->update($validated);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Data admin berhasil diperbarui!']);
        }
        return back()->with('success', 'Data admin berhasil diperbarui!');
    }

    public function destroy(Request $request, $id)
    {
        $currentAdminId = auth()->id();
        
        if ($id == $currentAdminId) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Tidak dapat menghapus akun sendiri!'], 400);
            }
            return back()->with('error', 'Tidak dapat menghapus akun sendiri!');
        }
        
        $admin = Pengguna::whereHas('peranPengguna', fn($q) => $q->where('kode', 'admin'))->findOrFail($id);
        $admin->delete();
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Admin berhasil dihapus!']);
        }
        return back()->with('success', 'Admin berhasil dihapus!');
    }
}
