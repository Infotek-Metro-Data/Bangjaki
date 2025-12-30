<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $pelanggan = Auth::guard('pelanggan')->user();
        
        return view('pelanggan.profile.index', compact('pelanggan'));
    }

    public function update(Request $request)
    {
        $pelanggan = Auth::guard('pelanggan')->user();
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'alamat_lengkap' => 'required|string',
        ]);
        
        $pelanggan->update($validated);
        
        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $pelanggan = Auth::guard('pelanggan')->user();
        
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);
        
        if (!Hash::check($request->current_password, $pelanggan->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah.']);
        }
        
        $pelanggan->update([
            'password' => $request->password,
        ]);
        
        return back()->with('success', 'Password berhasil diubah!');
    }
}
