<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    use HasFactory;

    protected $table = 'pengguna';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'telepon',
        'peran',
        'status',
        'nomor_kendaraan',
        'foto_profil',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'petugas_id');
    }

    public function setoran()
    {
        return $this->hasMany(Setoran::class, 'petugas_id');
    }
}
