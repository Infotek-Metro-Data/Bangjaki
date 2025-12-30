<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $pengguna = Pengguna::where('email', $request->email)->first();

        if ($pengguna) {
            if (!Hash::check($request->password, $pengguna->password)) {
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

            return match($pengguna->peran) {
                'admin' => redirect()->intended(route('admin.dashboard')),
                'petugas' => redirect()->intended(route('petugas.home')),
                default => redirect()->intended('/'),
            };
        }

        $pelanggan = Pelanggan::where('email', $request->email)->first();

        if ($pelanggan) {
            if (!$pelanggan->password) {
                throw ValidationException::withMessages([
                    'email' => ['Akun belum diaktifkan. Hubungi admin untuk mendapatkan password.'],
                ]);
            }

            if (!Hash::check($request->password, $pelanggan->password)) {
                throw ValidationException::withMessages([
                    'email' => ['Email atau password salah.'],
                ]);
            }

            if ($pelanggan->status !== 'aktif') {
                throw ValidationException::withMessages([
                    'email' => ['Akun Anda tidak aktif. Hubungi admin.'],
                ]);
            }

            Auth::guard('pelanggan')->login($pelanggan, $request->boolean('remember'));
            $request->session()->regenerate();

            return redirect()->intended(route('pelanggan.dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => ['Email atau password salah.'],
        ]);
    }

    public function logout(Request $request)
    {
        if (Auth::guard('pelanggan')->check()) {
            Auth::guard('pelanggan')->logout();
        } else {
            Auth::logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

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
