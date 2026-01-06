<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // First, seed lookup tables
        $this->seedLookupTables();

        // ===== PEMBAYARAN =====
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->foreignId('metode_id')->nullable()->after('jumlah_bayar');
            $table->foreignId('status_id')->nullable()->after('metode_id');
        });

        // Migrate pembayaran.metode data
        DB::statement("UPDATE pembayaran SET metode_id = (SELECT id FROM metode_pembayaran WHERE kode = pembayaran.metode)");
        DB::statement("UPDATE pembayaran SET status_id = (SELECT id FROM status_pembayaran WHERE kode = pembayaran.status)");

        Schema::table('pembayaran', function (Blueprint $table) {
            $table->dropColumn(['metode', 'status']);
        });

        Schema::table('pembayaran', function (Blueprint $table) {
            $table->foreign('metode_id')->references('id')->on('metode_pembayaran')->onDelete('restrict');
            $table->foreign('status_id')->references('id')->on('status_pembayaran')->onDelete('restrict');
        });

        // ===== TAGIHAN =====
        Schema::table('tagihan', function (Blueprint $table) {
            $table->foreignId('status_id')->nullable()->after('jumlah_tagihan');
        });

        DB::statement("UPDATE tagihan SET status_id = (SELECT id FROM status_tagihan WHERE kode = tagihan.status)");

        Schema::table('tagihan', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('tagihan', function (Blueprint $table) {
            $table->foreign('status_id')->references('id')->on('status_tagihan')->onDelete('restrict');
        });

        // ===== SETORAN =====
        Schema::table('setoran', function (Blueprint $table) {
            $table->foreignId('status_id')->nullable()->after('tanggal_setor');
        });

        DB::statement("UPDATE setoran SET status_id = (SELECT id FROM status_setoran WHERE kode = setoran.status)");

        Schema::table('setoran', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('setoran', function (Blueprint $table) {
            $table->foreign('status_id')->references('id')->on('status_setoran')->onDelete('restrict');
        });

        // ===== PENGGUNA =====
        Schema::table('pengguna', function (Blueprint $table) {
            $table->foreignId('peran_id')->nullable()->after('password');
            $table->foreignId('status_id')->nullable()->after('telepon');
        });

        DB::statement("UPDATE pengguna SET peran_id = (SELECT id FROM peran_pengguna WHERE kode = pengguna.peran)");
        DB::statement("UPDATE pengguna SET status_id = (SELECT id FROM status_pengguna WHERE kode = pengguna.status)");

        Schema::table('pengguna', function (Blueprint $table) {
            $table->dropColumn(['peran', 'status']);
        });

        Schema::table('pengguna', function (Blueprint $table) {
            $table->foreign('peran_id')->references('id')->on('peran_pengguna')->onDelete('restrict');
            $table->foreign('status_id')->references('id')->on('status_pengguna')->onDelete('restrict');
        });

        // ===== PELANGGAN =====
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->foreignId('status_id')->nullable()->after('iuran_khusus');
        });

        DB::statement("UPDATE pelanggan SET status_id = (SELECT id FROM status_pelanggan WHERE kode = pelanggan.status)");

        Schema::table('pelanggan', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('pelanggan', function (Blueprint $table) {
            $table->foreign('status_id')->references('id')->on('status_pelanggan')->onDelete('restrict');
        });

        // ===== PENJEMPUTAN =====
        Schema::table('penjemputan', function (Blueprint $table) {
            $table->foreignId('status_id')->nullable()->after('tanggal_jemput');
        });

        DB::statement("UPDATE penjemputan SET status_id = (SELECT id FROM status_penjemputan WHERE kode = penjemputan.status)");

        Schema::table('penjemputan', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('penjemputan', function (Blueprint $table) {
            $table->foreign('status_id')->references('id')->on('status_penjemputan')->onDelete('restrict');
        });

        // ===== KELUHAN =====
        Schema::table('keluhan', function (Blueprint $table) {
            $table->foreignId('kategori_id')->nullable()->after('pelanggan_id');
            $table->foreignId('prioritas_id')->nullable()->after('bukti_foto');
            $table->foreignId('status_id')->nullable()->after('prioritas_id');
        });

        // Migrate kategori (was string, need to match or create)
        DB::statement("UPDATE keluhan SET kategori_id = COALESCE((SELECT id FROM kategori_keluhan WHERE kode = LOWER(REPLACE(keluhan.kategori, ' ', '_'))), (SELECT id FROM kategori_keluhan WHERE kode = 'lainnya'))");
        DB::statement("UPDATE keluhan SET prioritas_id = (SELECT id FROM prioritas_keluhan WHERE kode = keluhan.prioritas)");
        DB::statement("UPDATE keluhan SET status_id = (SELECT id FROM status_keluhan WHERE kode = keluhan.status)");

        Schema::table('keluhan', function (Blueprint $table) {
            $table->dropColumn(['kategori', 'prioritas', 'status']);
        });

        Schema::table('keluhan', function (Blueprint $table) {
            $table->foreign('kategori_id')->references('id')->on('kategori_keluhan')->onDelete('restrict');
            $table->foreign('prioritas_id')->references('id')->on('prioritas_keluhan')->onDelete('restrict');
            $table->foreign('status_id')->references('id')->on('status_keluhan')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        // This is a complex migration, down() would be very complex
        // For safety, recommend fresh migration instead
        throw new \Exception('This migration cannot be reversed. Please run migrate:fresh --seed');
    }

    private function seedLookupTables(): void
    {
        // Only seed if tables are empty
        if (DB::table('metode_pembayaran')->count() === 0) {
            DB::table('metode_pembayaran')->insert([
                ['kode' => 'tunai', 'nama' => 'Tunai', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
                ['kode' => 'transfer', 'nama' => 'Transfer Bank', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        if (DB::table('status_pembayaran')->count() === 0) {
            DB::table('status_pembayaran')->insert([
                ['kode' => 'dibuat', 'nama' => 'Dibuat', 'urutan' => 1, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
                ['kode' => 'menunggu_admin', 'nama' => 'Menunggu Admin', 'urutan' => 2, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
                ['kode' => 'disetujui', 'nama' => 'Disetujui', 'urutan' => 3, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
                ['kode' => 'ditolak', 'nama' => 'Ditolak', 'urutan' => 4, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
                ['kode' => 'disetor', 'nama' => 'Disetor', 'urutan' => 5, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        if (DB::table('status_tagihan')->count() === 0) {
            DB::table('status_tagihan')->insert([
                ['kode' => 'belum_bayar', 'nama' => 'Belum Bayar', 'urutan' => 1, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
                ['kode' => 'menunggu_verifikasi', 'nama' => 'Menunggu Verifikasi', 'urutan' => 2, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
                ['kode' => 'lunas', 'nama' => 'Lunas', 'urutan' => 3, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
                ['kode' => 'ditolak', 'nama' => 'Ditolak', 'urutan' => 4, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        if (DB::table('status_setoran')->count() === 0) {
            DB::table('status_setoran')->insert([
                ['kode' => 'terbuka', 'nama' => 'Terbuka', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
                ['kode' => 'selesai', 'nama' => 'Selesai', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
                ['kode' => 'selisih', 'nama' => 'Selisih', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        if (DB::table('peran_pengguna')->count() === 0) {
            DB::table('peran_pengguna')->insert([
                ['kode' => 'admin', 'nama' => 'Administrator', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
                ['kode' => 'petugas', 'nama' => 'Petugas Lapangan', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        if (DB::table('status_pengguna')->count() === 0) {
            DB::table('status_pengguna')->insert([
                ['kode' => 'aktif', 'nama' => 'Aktif', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
                ['kode' => 'istirahat', 'nama' => 'Istirahat', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
                ['kode' => 'nonaktif', 'nama' => 'Nonaktif', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        if (DB::table('status_pelanggan')->count() === 0) {
            DB::table('status_pelanggan')->insert([
                ['kode' => 'aktif', 'nama' => 'Aktif', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
                ['kode' => 'nonaktif', 'nama' => 'Nonaktif', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        if (DB::table('status_penjemputan')->count() === 0) {
            DB::table('status_penjemputan')->insert([
                ['kode' => 'terjadwal', 'nama' => 'Terjadwal', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
                ['kode' => 'selesai', 'nama' => 'Selesai', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
                ['kode' => 'gagal', 'nama' => 'Gagal', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        if (DB::table('kategori_keluhan')->count() === 0) {
            DB::table('kategori_keluhan')->insert([
                ['kode' => 'layanan', 'nama' => 'Layanan', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
                ['kode' => 'pembayaran', 'nama' => 'Pembayaran', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
                ['kode' => 'petugas', 'nama' => 'Petugas', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
                ['kode' => 'lainnya', 'nama' => 'Lainnya', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        if (DB::table('prioritas_keluhan')->count() === 0) {
            DB::table('prioritas_keluhan')->insert([
                ['kode' => 'normal', 'nama' => 'Normal', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
                ['kode' => 'mendesak', 'nama' => 'Mendesak', 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        if (DB::table('status_keluhan')->count() === 0) {
            DB::table('status_keluhan')->insert([
                ['kode' => 'terbuka', 'nama' => 'Terbuka', 'urutan' => 1, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
                ['kode' => 'diproses', 'nama' => 'Diproses', 'urutan' => 2, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
                ['kode' => 'selesai', 'nama' => 'Selesai', 'urutan' => 3, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
    }
};
