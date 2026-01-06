<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });

        Schema::table('pembayaran', function (Blueprint $table) {
            $table->dropColumn(['lokasi_lat', 'lokasi_long']);
        });
    }

    public function down(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
        });

        Schema::table('pembayaran', function (Blueprint $table) {
            $table->decimal('lokasi_lat', 10, 8)->nullable();
            $table->decimal('lokasi_long', 11, 8)->nullable();
        });
    }
};
