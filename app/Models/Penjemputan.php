<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjemputan extends Model
{
    use HasFactory;

    protected $table = 'penjemputan';

    protected $fillable = [
        'pelanggan_id',
        'petugas_id',
        'tanggal_jemput',
        'status_id',
        'catatan',
    ];

    protected $casts = [
        'tanggal_jemput' => 'date',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function petugas()
    {
        return $this->belongsTo(Pengguna::class, 'petugas_id');
    }

    public function statusPenjemputan()
    {
        return $this->belongsTo(StatusPenjemputan::class, 'status_id');
    }

    public function getStatusAttribute()
    {
        return $this->statusPenjemputan?->kode;
    }

    public function scopeByStatusKode($query, string $kode)
    {
        return $query->whereHas('statusPenjemputan', fn($q) => $q->where('kode', $kode));
    }

    public function scopeTerjadwal($query)
    {
        return $query->whereHas('statusPenjemputan', fn($q) => $q->where('kode', 'terjadwal'));
    }
}
