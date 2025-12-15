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
        Schema::create('setoran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petugas_id')->constrained('pengguna')->onDelete('restrict');
            $table->decimal('total_tagihan_sistem', 12, 2);
            $table->decimal('total_uang_diterima', 12, 2);
            $table->date('tanggal_setor');
            $table->enum('status', ['terbuka', 'selesai', 'selisih'])->default('terbuka');
            $table->text('catatan_admin')->nullable();
            $table->foreignId('dikonfirmasi_oleh')->nullable()->constrained('pengguna')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setoran');
    }
};
