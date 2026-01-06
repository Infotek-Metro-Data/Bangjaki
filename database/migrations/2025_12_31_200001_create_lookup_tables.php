<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Metode Pembayaran
        Schema::create('metode_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // Status Pembayaran
        Schema::create('status_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // Status Tagihan
        Schema::create('status_tagihan', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // Status Setoran
        Schema::create('status_setoran', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // Peran Pengguna
        Schema::create('peran_pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // Status Pengguna
        Schema::create('status_pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // Status Pelanggan
        Schema::create('status_pelanggan', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // Status Penjemputan
        Schema::create('status_penjemputan', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // Kategori Keluhan
        Schema::create('kategori_keluhan', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // Prioritas Keluhan
        Schema::create('prioritas_keluhan', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // Status Keluhan
        Schema::create('status_keluhan', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('status_keluhan');
        Schema::dropIfExists('prioritas_keluhan');
        Schema::dropIfExists('kategori_keluhan');
        Schema::dropIfExists('status_penjemputan');
        Schema::dropIfExists('status_pelanggan');
        Schema::dropIfExists('status_pengguna');
        Schema::dropIfExists('peran_pengguna');
        Schema::dropIfExists('status_setoran');
        Schema::dropIfExists('status_tagihan');
        Schema::dropIfExists('status_pembayaran');
        Schema::dropIfExists('metode_pembayaran');
    }
};
