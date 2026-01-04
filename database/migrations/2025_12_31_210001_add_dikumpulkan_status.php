<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('status_pembayaran')->insert([
            'kode' => 'dikumpulkan',
            'nama' => 'Dikumpulkan',
            'urutan' => 2,
            'aktif' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('status_pembayaran')
            ->where('kode', 'menunggu_admin')
            ->update(['urutan' => 3]);
        DB::table('status_pembayaran')
            ->where('kode', 'disetujui')
            ->update(['urutan' => 4]);
        DB::table('status_pembayaran')
            ->where('kode', 'ditolak')
            ->update(['urutan' => 5]);
        DB::table('status_pembayaran')
            ->where('kode', 'disetor')
            ->update(['urutan' => 6]);
    }

    public function down(): void
    {
        DB::table('status_pembayaran')
            ->where('kode', 'dikumpulkan')
            ->delete();
    }
};
