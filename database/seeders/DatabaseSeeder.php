<?php

namespace Database\Seeders;

use App\Models\JenisPelanggan;
use App\Models\Pelanggan;
use App\Models\Pengguna;
use App\Models\Tagihan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        Pengguna::create([
            'nama' => 'Admin BangJaki',
            'email' => 'admin@bangjaki.com',
            'password' => Hash::make('password'),
            'peran' => 'admin',
            'telepon' => '081234567890',
            'status' => 'aktif',
        ]);

        // Create Petugas
        $petugas1 = Pengguna::create([
            'nama' => 'Budi Collector',
            'email' => 'budi@bangjaki.com',
            'password' => Hash::make('password'),
            'peran' => 'petugas',
            'nomor_kendaraan' => 'B 1234 ABC',
            'telepon' => '081234567891',
            'status' => 'aktif',
        ]);

        $petugas2 = Pengguna::create([
            'nama' => 'Andi Collector',
            'email' => 'andi@bangjaki.com',
            'password' => Hash::make('password'),
            'peran' => 'petugas',
            'nomor_kendaraan' => 'B 5678 DEF',
            'telepon' => '081234567892',
            'status' => 'aktif',
        ]);

        // Create Jenis Pelanggan
        $jenisRT = JenisPelanggan::create([
            'nama_paket' => 'Rumah Tangga',
            'harga_dasar' => 50000,
            'deskripsi' => 'Paket untuk rumah tangga biasa',
        ]);

        $jenisUsaha = JenisPelanggan::create([
            'nama_paket' => 'Usaha',
            'harga_dasar' => 100000,
            'deskripsi' => 'Paket untuk usaha/toko',
        ]);

        $jenisPremium = JenisPelanggan::create([
            'nama_paket' => 'Premium',
            'harga_dasar' => 150000,
            'deskripsi' => 'Paket premium dengan pengangkutan 2x/minggu',
        ]);

        // Create Pelanggan
        $pelangganData = [
            ['nama' => 'Ahmad Santoso', 'alamat' => 'Jl. Merdeka No. 45, RT 05/RW 02', 'wilayah' => 'Wilayah A', 'jenis' => $jenisRT, 'tanggal' => 15],
            ['nama' => 'Siti Rahayu', 'alamat' => 'Jl. Sudirman No. 12, RT 03/RW 01', 'wilayah' => 'Wilayah A', 'jenis' => $jenisRT, 'tanggal' => 5],
            ['nama' => 'Budi Prasetyo', 'alamat' => 'Jl. Gatot Subroto No. 78', 'wilayah' => 'Wilayah B', 'jenis' => $jenisRT, 'tanggal' => 20],
            ['nama' => 'Toko Makmur', 'alamat' => 'Jl. Pasar Baru No. 10', 'wilayah' => 'Wilayah A', 'jenis' => $jenisUsaha, 'tanggal' => 1],
            ['nama' => 'Warung Barokah', 'alamat' => 'Jl. Raya Bogor No. 55', 'wilayah' => 'Wilayah B', 'jenis' => $jenisUsaha, 'tanggal' => 10],
            ['nama' => 'Dewi Lestari', 'alamat' => 'Perumahan Indah Blok A5', 'wilayah' => 'Wilayah A', 'jenis' => $jenisPremium, 'tanggal' => 25],
        ];

        foreach ($pelangganData as $data) {
            $pelanggan = Pelanggan::create([
                'jenis_pelanggan_id' => $data['jenis']->id,
                'nama' => $data['nama'],
                'alamat_lengkap' => $data['alamat'],
                'wilayah' => $data['wilayah'],
                'telepon' => '08' . rand(1000000000, 9999999999),
                'tanggal_registrasi' => now()->subMonths(rand(1, 12))->setDay($data['tanggal']),
                'status' => 'aktif',
            ]);

            // Create tagihan for current month
            $tanggalReg = $pelanggan->tanggal_registrasi->day;
            $periodeAwal = now()->setDay($tanggalReg);
            
            if ($periodeAwal->isFuture()) {
                $periodeAwal = $periodeAwal->subMonth();
            }

            Tagihan::create([
                'pelanggan_id' => $pelanggan->id,
                'periode_mulai' => $periodeAwal,
                'periode_selesai' => $periodeAwal->copy()->addMonth()->subDay(),
                'jumlah_tagihan' => $pelanggan->harga,
                'status' => collect(['belum_bayar', 'belum_bayar', 'belum_bayar', 'lunas'])->random(),
                'jatuh_tempo' => $periodeAwal->copy()->addDays(7),
            ]);
        }

        $this->command->info('Demo data seeded successfully!');
        $this->command->info('');
        $this->command->info('Login Credentials:');
        $this->command->info('Admin: admin@bangjaki.com / password');
        $this->command->info('Petugas: budi@bangjaki.com / password');
    }
}
