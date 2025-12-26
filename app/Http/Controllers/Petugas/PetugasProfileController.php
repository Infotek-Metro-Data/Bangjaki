<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PetugasProfileController extends Controller
{
    public function index()
    {
        $petugas = auth()->user();
        
        return view('petugas.profile.index', compact('petugas'));
    }

    public function update(Request $request)
    {
        $petugas = auth()->user();
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email,' . $petugas->id,
            'telepon' => 'nullable|string|max:20',
            'foto_profil' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto_profil')) {
            $validated['foto_profil'] = $request->file('foto_profil')->store('profil-petugas', 'public');
        }

        $petugas->update($validated);

        return redirect()->route('petugas.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $petugas = auth()->user();

        if (!password_verify($request->current_password, $petugas->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $petugas->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('petugas.profile')
            ->with('success', 'Password berhasil diperbarui.');
    }
}
