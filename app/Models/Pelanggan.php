<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';

    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'alamat',
        'wilayah',
        'jenis_pelanggan_id',
        'tanggal_daftar',
        'status',
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
    ];

    public function jenisPelanggan()
    {
        return $this->belongsTo(JenisPelanggan::class, 'jenis_pelanggan_id');
    }

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }
}
