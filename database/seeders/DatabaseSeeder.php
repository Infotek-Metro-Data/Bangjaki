<?php

namespace Database\Seeders;

use App\Models\JenisPelanggan;
use App\Models\Pelanggan;
use App\Models\Pengguna;
use App\Models\Tagihan;
use App\Models\PeranPengguna;
use App\Models\StatusPengguna;
use App\Models\StatusPelanggan;
use App\Models\StatusTagihan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $peranAdmin = PeranPengguna::where('kode', 'admin')->first();
        $peranPetugas = PeranPengguna::where('kode', 'petugas')->first();
        $statusAktifPengguna = StatusPengguna::where('kode', 'aktif')->first();
        $statusAktifPelanggan = StatusPelanggan::where('kode', 'aktif')->first();
        $statusBelumBayar = StatusTagihan::where('kode', 'belum_bayar')->first();
        $statusLunas = StatusTagihan::where('kode', 'lunas')->first();

        Pengguna::create([
            'nama' => 'Admin BangJaki',
            'email' => 'admin@bangjaki.com',
            'password' => Hash::make('password'),
            'peran_id' => $peranAdmin->id,
            'telepon' => '081234567890',
            'status_id' => $statusAktifPengguna->id,
        ]);

        $petugas1 = Pengguna::create([
            'nama' => 'Budi Collector',
            'email' => 'budi@bangjaki.com',
            'password' => Hash::make('password'),
            'peran_id' => $peranPetugas->id,
            'nomor_kendaraan' => 'B 1234 ABC',
            'telepon' => '081234567891',
            'status_id' => $statusAktifPengguna->id,
        ]);

        $petugas2 = Pengguna::create([
            'nama' => 'Andi Collector',
            'email' => 'andi@bangjaki.com',
            'password' => Hash::make('password'),
            'peran_id' => $peranPetugas->id,
            'nomor_kendaraan' => 'B 5678 DEF',
            'telepon' => '081234567892',
            'status_id' => $statusAktifPengguna->id,
        ]);

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

        $pelangganData = [
            ['nama' => 'Ahmad Santoso', 'alamat' => 'Jl. Merdeka No. 45, RT 05/RW 02', 'wilayah' => 'Wilayah A', 'jenis' => $jenisRT, 'tanggal' => 15],
            ['nama' => 'Siti Rahayu', 'alamat' => 'Jl. Sudirman No. 12, RT 03/RW 01', 'wilayah' => 'Wilayah A', 'jenis' => $jenisRT, 'tanggal' => 5],
            ['nama' => 'Budi Prasetyo', 'alamat' => 'Jl. Gatot Subroto No. 78', 'wilayah' => 'Wilayah B', 'jenis' => $jenisRT, 'tanggal' => 20],
            ['nama' => 'Toko Makmur', 'alamat' => 'Jl. Pasar Baru No. 10', 'wilayah' => 'Wilayah A', 'jenis' => $jenisUsaha, 'tanggal' => 1],
            ['nama' => 'Warung Barokah', 'alamat' => 'Jl. Raya Bogor No. 55', 'wilayah' => 'Wilayah B', 'jenis' => $jenisUsaha, 'tanggal' => 10],
            ['nama' => 'Dewi Lestari', 'alamat' => 'Perumahan Indah Blok A5', 'wilayah' => 'Wilayah A', 'jenis' => $jenisPremium, 'tanggal' => 25],
        ];

        $tagihanStatuses = [$statusBelumBayar->id, $statusBelumBayar->id, $statusBelumBayar->id, $statusLunas->id];

        foreach ($pelangganData as $data) {
            $createdAt = now()->subMonths(rand(1, 12))->setDay($data['tanggal']);
            
            $pelanggan = Pelanggan::create([
                'jenis_pelanggan_id' => $data['jenis']->id,
                'nama' => $data['nama'],
                'alamat_lengkap' => $data['alamat'],
                'wilayah' => $data['wilayah'],
                'telepon' => '08' . rand(1000000000, 9999999999),
                'status_id' => $statusAktifPelanggan->id,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            $tanggalReg = $pelanggan->created_at->day;
            $periodeAwal = now()->setDay($tanggalReg);
            
            if ($periodeAwal->isFuture()) {
                $periodeAwal = $periodeAwal->subMonth();
            }

            Tagihan::create([
                'pelanggan_id' => $pelanggan->id,
                'periode_mulai' => $periodeAwal,
                'periode_selesai' => $periodeAwal->copy()->addMonth()->subDay(),
                'jumlah_tagihan' => $pelanggan->harga,
                'status_id' => collect($tagihanStatuses)->random(),
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
