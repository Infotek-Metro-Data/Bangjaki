<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pelanggan extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $table = 'pelanggan';

    protected $fillable = [
        'jenis_pelanggan_id',
        'nama',
        'email',
        'password',
        'alamat_lengkap',
        'wilayah',
        'telepon',
        'latitude',
        'longitude',
        'iuran_khusus',
        'tanggal_registrasi',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'tanggal_registrasi' => 'date',
        'iuran_khusus' => 'decimal:2',
        'password' => 'hashed',
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

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
