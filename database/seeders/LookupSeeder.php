<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LookupSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('metode_pembayaran')->insert([
            ['kode' => 'tunai', 'nama' => 'Tunai', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'transfer', 'nama' => 'Transfer Bank', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('status_pembayaran')->insert([
            ['kode' => 'dibuat', 'nama' => 'Dibuat', 'urutan' => 1, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'menunggu_admin', 'nama' => 'Menunggu Admin', 'urutan' => 2, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'disetujui', 'nama' => 'Disetujui', 'urutan' => 3, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'ditolak', 'nama' => 'Ditolak', 'urutan' => 4, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'disetor', 'nama' => 'Disetor', 'urutan' => 5, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('status_tagihan')->insert([
            ['kode' => 'belum_bayar', 'nama' => 'Belum Bayar', 'urutan' => 1, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'menunggu_verifikasi', 'nama' => 'Menunggu Verifikasi', 'urutan' => 2, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'lunas', 'nama' => 'Lunas', 'urutan' => 3, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'ditolak', 'nama' => 'Ditolak', 'urutan' => 4, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('status_setoran')->insert([
            ['kode' => 'terbuka', 'nama' => 'Terbuka', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'selesai', 'nama' => 'Selesai', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'selisih', 'nama' => 'Selisih', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('peran_pengguna')->insert([
            ['kode' => 'admin', 'nama' => 'Administrator', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'petugas', 'nama' => 'Petugas Lapangan', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('status_pengguna')->insert([
            ['kode' => 'aktif', 'nama' => 'Aktif', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'istirahat', 'nama' => 'Istirahat', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'nonaktif', 'nama' => 'Nonaktif', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('status_pelanggan')->insert([
            ['kode' => 'aktif', 'nama' => 'Aktif', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'nonaktif', 'nama' => 'Nonaktif', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('status_penjemputan')->insert([
            ['kode' => 'terjadwal', 'nama' => 'Terjadwal', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'selesai', 'nama' => 'Selesai', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'gagal', 'nama' => 'Gagal', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('kategori_keluhan')->insert([
            ['kode' => 'layanan', 'nama' => 'Layanan', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'pembayaran', 'nama' => 'Pembayaran', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'petugas', 'nama' => 'Petugas', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'lainnya', 'nama' => 'Lainnya', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('prioritas_keluhan')->insert([
            ['kode' => 'normal', 'nama' => 'Normal', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'mendesak', 'nama' => 'Mendesak', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('status_keluhan')->insert([
            ['kode' => 'terbuka', 'nama' => 'Terbuka', 'urutan' => 1, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'diproses', 'nama' => 'Diproses', 'urutan' => 2, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'selesai', 'nama' => 'Selesai', 'urutan' => 3, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
