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
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_pelanggan_id')->constrained('jenis_pelanggan')->onDelete('restrict');
            $table->string('nama');
            $table->string('email')->nullable()->unique();
            $table->text('alamat_lengkap');
            $table->string('wilayah')->index();
            $table->string('telepon');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->decimal('iuran_khusus', 12, 2)->nullable();
            $table->date('tanggal_registrasi');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
