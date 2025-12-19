<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelanggan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pelanggan';

    protected $fillable = [
        'jenis_pelanggan_id',
        'nama',
        'email',
        'alamat_lengkap',
        'wilayah',
        'telepon',
        'latitude',
        'longitude',
        'iuran_khusus',
        'tanggal_registrasi',
        'status',
    ];

    protected $casts = [
        'tanggal_registrasi' => 'date',
        'iuran_khusus' => 'decimal:2',
    ];

    public function getHargaAttribute()
    {
        return $this->iuran_khusus ?? $this->jenisPelanggan?->harga_dasar ?? 0;
    }

    public function jenisPelanggan()
    {
        return $this->belongsTo(JenisPelanggan::class, 'jenis_pelanggan_id');
    }

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }
}
