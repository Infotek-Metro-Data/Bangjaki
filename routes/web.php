<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SettlementController;
use App\Http\Controllers\Admin\TagihanController;
use App\Http\Controllers\Admin\VerifikasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboardController;
use App\Http\Controllers\Pelanggan\TagihanController as PelangganTagihanController;
use App\Http\Controllers\Pelanggan\RiwayatController as PelangganRiwayatController;
use App\Http\Controllers\Pelanggan\ProfileController as PelangganProfileController;
use App\Http\Controllers\Petugas\PetugasHomeController;
use App\Http\Controllers\Petugas\PetugasInputController;
use App\Http\Controllers\Petugas\PetugasProfileController;
use App\Http\Controllers\Petugas\PetugasSaldoController;
use App\Http\Controllers\Petugas\PetugasTagihanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::guard('pelanggan')->check()) {
        return redirect()->route('pelanggan.dashboard');
    }
    if (auth()->check()) {
        return match(auth()->user()->peran) {
            'admin' => redirect()->route('admin.dashboard'),
            'petugas' => redirect()->route('petugas.home'),
            default => redirect()->route('login'),
        };
    }
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
        Route::get('/pelanggan/{id}', [PelangganController::class, 'show'])->name('pelanggan.show');
        Route::post('/pelanggan', [PelangganController::class, 'store'])->name('pelanggan.store');
        Route::put('/pelanggan/{id}', [PelangganController::class, 'update'])->name('pelanggan.update');
        Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');
        
        Route::get('/tagihan', [TagihanController::class, 'index'])->name('tagihan.index');
        Route::post('/tagihan/generate', [TagihanController::class, 'generate'])->name('tagihan.generate');
        
        Route::get('/petugas', [PetugasController::class, 'index'])->name('petugas.index');
        Route::post('/petugas', [PetugasController::class, 'store'])->name('petugas.store');
        Route::put('/petugas/{id}', [PetugasController::class, 'update'])->name('petugas.update');
        Route::delete('/petugas/{id}', [PetugasController::class, 'destroy'])->name('petugas.destroy');
        
        Route::get('/admins', [\App\Http\Controllers\Admin\AdminManagementController::class, 'index'])->name('admins.index');
        Route::post('/admins', [\App\Http\Controllers\Admin\AdminManagementController::class, 'store'])->name('admins.store');
        Route::put('/admins/{id}', [\App\Http\Controllers\Admin\AdminManagementController::class, 'update'])->name('admins.update');
        Route::delete('/admins/{id}', [\App\Http\Controllers\Admin\AdminManagementController::class, 'destroy'])->name('admins.destroy');
        
        Route::get('/verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi.index');
        Route::get('/verifikasi/{id}', [VerifikasiController::class, 'show'])->name('verifikasi.show');
        Route::post('/verifikasi/{id}/approve', [VerifikasiController::class, 'approve'])->name('verifikasi.approve');
        Route::post('/verifikasi/{id}/reject', [VerifikasiController::class, 'reject'])->name('verifikasi.reject');
        
        Route::get('/settlement', [SettlementController::class, 'index'])->name('settlement.index');
        Route::get('/settlement/history', [SettlementController::class, 'history'])->name('settlement.history');
        Route::get('/settlement/{id}', [SettlementController::class, 'show'])->name('settlement.show');
        Route::post('/settlement/{id}/confirm', [SettlementController::class, 'confirm'])->name('settlement.confirm');
        
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings/tarif', [SettingsController::class, 'storeTarif'])->name('settings.tarif.store');
        Route::put('/settings/tarif/{id}', [SettingsController::class, 'updateTarif'])->name('settings.tarif.update');
        Route::delete('/settings/tarif/{id}', [SettingsController::class, 'destroyTarif'])->name('settings.tarif.destroy');
        Route::post('/settings/wilayah', [SettingsController::class, 'storeWilayah'])->name('settings.wilayah.store');
        Route::put('/settings/wilayah/{id}', [SettingsController::class, 'updateWilayah'])->name('settings.wilayah.update');
        Route::delete('/settings/wilayah/{id}', [SettingsController::class, 'destroyWilayah'])->name('settings.wilayah.destroy');
        
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
        
        Route::get('/export/pelanggan', [\App\Http\Controllers\Admin\ExportController::class, 'pelanggan'])->name('export.pelanggan');
        Route::get('/export/tagihan', [\App\Http\Controllers\Admin\ExportController::class, 'tagihan'])->name('export.tagihan');
        Route::get('/export/petugas', [\App\Http\Controllers\Admin\ExportController::class, 'petugas'])->name('export.petugas');
    });

Route::prefix('petugas')
    ->name('petugas.')
    ->middleware(['auth', 'role:petugas'])
    ->group(function () {
        Route::get('/', [PetugasHomeController::class, 'index'])->name('home');
        
        Route::get('/tagihan', [PetugasTagihanController::class, 'index'])->name('tagihan');
        
        Route::get('/input', [PetugasInputController::class, 'create'])->name('input');
        Route::post('/input', [PetugasInputController::class, 'store'])->name('input.store');
        
        Route::get('/saldo', [PetugasSaldoController::class, 'index'])->name('saldo');
        
        Route::get('/riwayat', [\App\Http\Controllers\Petugas\PetugasRiwayatController::class, 'index'])->name('riwayat');
        
        Route::get('/profile', [PetugasProfileController::class, 'index'])->name('profile');
        Route::post('/profile', [PetugasProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/password', [PetugasProfileController::class, 'updatePassword'])->name('profile.password');
        
        Route::post('/notifications/read', function() {
            auth()->user()->unreadNotifications->markAsRead();
            return back();
        })->name('notifications.read');
    });

Route::prefix('pelanggan')
    ->name('pelanggan.')
    ->middleware(['role:pelanggan'])
    ->group(function () {
        Route::get('/', [PelangganDashboardController::class, 'index'])->name('dashboard');
        Route::get('/tagihan', [PelangganTagihanController::class, 'index'])->name('tagihan');
        Route::get('/riwayat', [PelangganRiwayatController::class, 'index'])->name('riwayat');
        Route::get('/profile', [PelangganProfileController::class, 'index'])->name('profile');
        Route::post('/profile', [PelangganProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/password', [PelangganProfileController::class, 'updatePassword'])->name('profile.password');
    });

