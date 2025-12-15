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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tagihan_id')->constrained('tagihan')->onDelete('cascade');
            $table->foreignId('petugas_id')->constrained('pengguna')->onDelete('restrict');
            $table->foreignId('setoran_id')->nullable()->constrained('setoran')->onDelete('set null');
            $table->decimal('jumlah_bayar', 12, 2);
            $table->enum('metode', ['tunai', 'transfer']);
            $table->string('bukti_foto');
            $table->decimal('lokasi_lat', 10, 8)->nullable();
            $table->decimal('lokasi_long', 11, 8)->nullable();
            $table->enum('status', ['dibuat', 'menunggu_admin', 'disetujui', 'ditolak', 'disetor'])
                  ->default('dibuat');
            $table->foreignId('diverifikasi_oleh')->nullable()->constrained('pengguna')->onDelete('set null');
            $table->timestamp('diverifikasi_pada')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
