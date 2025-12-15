<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $pengguna = Pengguna::where('email', $request->email)->first();

        if (!$pengguna || !Hash::check($request->password, $pengguna->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        if ($pengguna->status !== 'aktif') {
            throw ValidationException::withMessages([
                'email' => ['Akun Anda tidak aktif. Hubungi admin.'],
            ]);
        }

        Auth::login($pengguna, $request->boolean('remember'));

        $request->session()->regenerate();

        // Redirect based on role
        return match($pengguna->peran) {
            'admin' => redirect()->intended(route('admin.dashboard')),
            'petugas' => redirect()->intended(route('petugas.home')),
            default => redirect()->intended('/'),
        };
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Show register form (optional - for admin to create users)
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle register request
     */
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|min:8|confirmed',
            'peran' => 'required|in:admin,petugas',
            'telepon' => 'required|string',
        ]);

        $pengguna = Pengguna::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'peran' => $request->peran,
            'telepon' => $request->telepon,
            'nomor_kendaraan' => $request->nomor_kendaraan,
            'status' => 'aktif',
        ]);

        Auth::login($pengguna);

        return match($pengguna->peran) {
            'admin' => redirect()->route('admin.dashboard'),
            'petugas' => redirect()->route('petugas.home'),
            default => redirect('/'),
        };
    }
}
