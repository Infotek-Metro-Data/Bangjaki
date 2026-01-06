<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'telepon',
        'peran_id',
        'status_id',
        'nomor_kendaraan',
        'wilayah',
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

    public function peranPengguna()
    {
        return $this->belongsTo(PeranPengguna::class, 'peran_id');
    }

    public function statusPengguna()
    {
        return $this->belongsTo(StatusPengguna::class, 'status_id');
    }

    public function getPeranAttribute()
    {
        return $this->peranPengguna?->kode;
    }

    public function getStatusAttribute()
    {
        return $this->statusPengguna?->kode;
    }

    public function isAdmin(): bool
    {
        return $this->peran === 'admin';
    }

    public function isPetugas(): bool
    {
        return $this->peran === 'petugas';
    }

    public function isAktif(): bool
    {
        return $this->status === 'aktif';
    }
}
