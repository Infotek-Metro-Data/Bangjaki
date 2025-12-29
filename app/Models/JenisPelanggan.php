<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPelanggan extends Model
{
    use HasFactory;

    protected $table = 'jenis_pelanggan';

    protected $fillable = [
        'nama_paket',
        'harga_dasar',
        'deskripsi',
    ];

    public function pelanggan()
    {
        return $this->hasMany(Pelanggan::class, 'jenis_pelanggan_id');
    }
}
