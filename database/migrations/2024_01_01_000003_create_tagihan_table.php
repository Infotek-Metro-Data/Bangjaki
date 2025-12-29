<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('pelanggan')->onDelete('cascade');
            $table->date('periode_mulai');
            $table->date('periode_selesai');
            $table->decimal('jumlah_tagihan', 12, 2);
            $table->enum('status', ['belum_bayar', 'menunggu_verifikasi', 'lunas', 'ditolak'])
                  ->default('belum_bayar');
            $table->date('jatuh_tempo')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan');
    }
};
