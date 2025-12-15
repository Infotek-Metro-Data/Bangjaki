<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

Route::prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', function () {
        $recentPending = collect([
            (object)[
                'id' => 101,
                'jumlah_bayar' => 50000,
                'created_at' => now()->subMinutes(15),
                'tagihan' => (object)[
                    'pelanggan' => (object)['nama' => 'Budi Santoso']
                ],
                'petugas' => (object)['nama' => 'Petugas A']
            ],
            (object)[
                'id' => 102,
                'jumlah_bayar' => 75000,
                'created_at' => now()->subHours(2),
                'tagihan' => (object)[
                    'pelanggan' => (object)['nama' => 'Siti Aminah']
                ],
                'petugas' => (object)['nama' => 'Petugas B']
            ]
        ]);

        return view('admin.dashboard', [
            'totalPelanggan' => 150,
            'tagihanHariIni' => 25,
            'pendingVerifikasi' => 5,
            'uangPetugas' => 2500000,
            'recentPending' => $recentPending
        ]);
    })->name('dashboard');

    Route::get('/pelanggan', function (Request $request) {
        $mockPelanggan = collect([]);
        for($i=1; $i<=10; $i++) {
            $mockPelanggan->push((object)[
                'id' => $i,
                'nama' => "Pelanggan Demo $i",
                'email' => "pelanggan$i@demo.com",
                'telepon' => "0812345678$i",
                'alamat' => "Jl. Contoh No. $i",
                'alamat_lengkap' => "Jl. Contoh No. $i, RT/RW 00$i/00$i, Kelurahan Demo",
                'wilayah' => 'Wilayah Pusat',
                'status' => 'aktif',
                'harga' => 50000,
                'jenis_pelanggan' => (object)['nama_paket' => 'Rumah Tangga', 'harga_dasar' => 50000],
                'tagihan_terakhir' => (object)['status' => $i % 2 == 0 ? 'lunas' : 'belum_bayar'],
                'created_at' => now()->subDays(rand(1, 30)),
            ]);
        }
        
        $perPage = 10;
        $page = $request->input('page', 1);
        $pelanggan = new \Illuminate\Pagination\LengthAwarePaginator(
            $mockPelanggan, 
            $mockPelanggan->count(), 
            $perPage, 
            $page, 
            ['path' => remove_query_param(['page'], $request->fullUrl())]
        );

        return view('admin.pelanggan.index', [
            'pelanggan' => $pelanggan
        ]);
    })->name('pelanggan.index');

    Route::post('/pelanggan', function() { 
        return back()->with('success', 'Data Pelanggan (Mock) Berhasil Disimpan'); 
    })->name('pelanggan.store');
    
    Route::put('/pelanggan/{id}', function() { 
        return back()->with('success', 'Data Pelanggan (Mock) Berhasil Diupdate'); 
    })->name('pelanggan.update');
    
    Route::delete('/pelanggan/{id}', function() { 
        return back()->with('success', 'Data Pelanggan (Mock) Berhasil Dihapus'); 
    })->name('pelanggan.destroy');


    Route::get('/petugas', function (Request $request) {
        $mockPetugas = collect([]);
        for($i=1; $i<=5; $i++) {
            $mockPetugas->push((object)[
                'id' => $i,
                'nama' => "Petugas Lapangan $i",
                'email' => "petugas$i@bangjaki.com",
                'telepon' => "0819876543$i",
                'nomor_kendaraan' => "BK 123$i ABC",
                'status' => 'aktif',
                'foto_profil' => null,
                'peran' => 'petugas'
            ]);
        }

        $pelanggan = new \Illuminate\Pagination\LengthAwarePaginator(
            $mockPetugas, 5, 10, 1
        );

        return view('admin.petugas.index', [
            'petugas' => $pelanggan,
            'totalPetugas' => 5,
            'petugasAktif' => 4,
            'petugasIstirahat' => 1
        ]);
    })->name('petugas.index');

    Route::post('/petugas', function() { return back()->with('success', 'Petugas (Mock) Created'); })->name('petugas.store');
    Route::put('/petugas/{id}', function() { return back()->with('success', 'Petugas (Mock) Updated'); })->name('petugas.update');
    Route::delete('/petugas/{id}', function() { return back()->with('success', 'Petugas (Mock) Deleted'); })->name('petugas.destroy');


    Route::get('/verifikasi', function (Request $request) {
        $mockPayments = collect([]);
        for($i=1; $i<=3; $i++) {
            $mockPayments->push((object)[
                'id' => $i,
                'jumlah_bayar' => 50000 * $i,
                'tanggal_bayar' => now(),
                'created_at' => now()->subHours(rand(1, 24)),
                'status' => 'menunggu_admin',
                'metode' => 'transfer',
                'foto_bukti' => null, 
                'tagihan' => (object)[
                    'periode' => now()->format('F Y'),
                    'pelanggan' => (object)['nama' => "Pelanggan $i", 'telepon' => '08123xxx']
                ],
                'petugas' => (object)[
                    'nama' => "Petugas $i",
                    'telepon' => '0819xxx'
                ]
            ]);
        }
        
        $currentPayment = $request->has('show') 
            ? $mockPayments->firstWhere('id', $request->show) 
            : $mockPayments->first();

        return view('admin.verifikasi.index', [
            'pendingPayments' => $mockPayments,
            'currentPayment' => $currentPayment
        ]);
    })->name('verifikasi.index');

    Route::get('/verifikasi/{id}', function($id) {
        return redirect()->route('admin.verifikasi.index', ['show' => $id]);
    })->name('verifikasi.show');

    Route::post('/verifikasi/{id}/approve', function() {
        return response()->json(['success' => true]);
    })->name('verifikasi.approve');

    Route::post('/verifikasi/{id}/reject', function() {
        return response()->json(['success' => true]);
    })->name('verifikasi.reject');


    Route::get('/settlement', function (Request $request) {
        $petugasList = collect([
            (object)[
                'id' => 1,
                'nama' => 'Budi Petugas',
                'email' => 'budi@upt.com',
                'telepon' => '08123456789',
                'pending_amount' => 1500000
            ],
            (object)[
                'id' => 2,
                'nama' => 'Andi Collector',
                'email' => 'andi@upt.com',
                'telepon' => '08198765432',
                'pending_amount' => 500000
            ]
        ]);

        $selectedPetugas = null;
        $transactions = collect([]);

        if ($request->route('id')) {
            $selectedPetugas = $petugasList->firstWhere('id', $request->route('id'));
            if($selectedPetugas) {
                for($i=0; $i<5; $i++) {
                    $transactions->push((object)[
                        'id' => rand(1000,9999),
                        'created_at' => now()->subMinutes(rand(10, 300)),
                        'jumlah_bayar' => 50000,
                        'tagihan' => (object)[
                            'pelanggan' => (object)['nama' => 'Pelanggan Random']
                        ]
                    ]);
                }
            }
        } else {
             $selectedPetugas = $petugasList->first();
        }

        return view('admin.settlement.index', [
            'petugasList' => $petugasList,
            'totalPending' => 2000000,
            'settledToday' => 5000000,
            'activeAgents' => 2,
            'selectedPetugas' => $selectedPetugas,
            'transactions' => $transactions
        ]);
    })->name('settlement.index');

    Route::get('/settlement/{id}', function ($id) {
        return  App::call(function(Request $request) use ($id) {
             $request->merge(['id' => $id]); 
             $petugasList = collect([
                (object)[ 'id' => 1, 'nama' => 'Budi Petugas', 'email' => 'budi@upt.com', 'telepon' => '08123456789', 'pending_amount' => 1500000 ],
                (object)[ 'id' => 2, 'nama' => 'Andi Collector', 'email' => 'andi@upt.com', 'telepon' => '08198765432', 'pending_amount' => 500000 ]
            ]);
            $selectedPetugas = $petugasList->firstWhere('id', $id);
            $transactions = collect([]);
            if($selectedPetugas) {
                for($i=0; $i<5; $i++) {
                    $transactions->push((object)[
                        'id' => rand(1000,9999),
                        'created_at' => now()->subMinutes(rand(10, 300)),
                        'jumlah_bayar' => 50000,
                        'tagihan' => (object)[ 'pelanggan' => (object)['nama' => 'Pelanggan Random'] ]
                    ]);
                }
            }
            return view('admin.settlement.index', [
                'petugasList' => $petugasList,
                'totalPending' => 2000000, 'settledToday' => 5000000, 'activeAgents' => 2,
                'selectedPetugas' => $selectedPetugas,
                'transactions' => $transactions
            ]);
        });
    })->name('settlement.show');

    Route::post('/settlement/{id}/confirm', function() {
        return response()->json(['success' => true, 'redirect' => route('admin.settlement.index')]);
    })->name('settlement.confirm');


    Route::get('/profile', function () {
        $user = (object)[
            'nama' => 'Admin Utama',
            'email' => 'admin@bangjaki.com',
            'peran' => 'admin',
            'foto_profil' => null
        ];
        return view('admin.profile.index', compact('user'));
    })->name('profile.index');

    Route::post('/profile', function() { return response()->json(['success' => true, 'message' => 'Profile Updated (Mock)']); })->name('profile.update');
    Route::post('/profile/password', function() { return response()->json(['success' => true, 'message' => 'Password Updated (Mock)']); })->name('profile.password');

});

Route::post('/logout', function() {
    return redirect('/');
})->name('logout');

function remove_query_param($params, $url) {
    return $url; 
}
