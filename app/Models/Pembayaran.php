<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'tagihan_id',
        'petugas_id',
        'jumlah_bayar',
        'metode_id',
        'status_id',
        'tanggal_bayar',
        'bukti_foto',
        'catatan',
        'diverifikasi_oleh',
        'diverifikasi_pada',
        'setoran_id',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
        'diverifikasi_pada' => 'datetime',
        'bukti_foto' => 'array',
    ];

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }

    public function petugas()
    {
        return $this->belongsTo(Pengguna::class, 'petugas_id');
    }

    public function verifikator()
    {
        return $this->belongsTo(Pengguna::class, 'diverifikasi_oleh');
    }

    public function setoran()
    {
        return $this->belongsTo(Setoran::class);
    }

    public function metode()
    {
        return $this->belongsTo(MetodePembayaran::class, 'metode_id');
    }

    public function statusPembayaran()
    {
        return $this->belongsTo(StatusPembayaran::class, 'status_id');
    }

    public function getStatusAttribute()
    {
        return $this->statusPembayaran?->kode;
    }

    public function getMetodeNamaAttribute()
    {
        return $this->metode?->nama;
    }

    public function scopeMenunggAdmin($query)
    {
        return $query->whereHas('statusPembayaran', fn($q) => $q->where('kode', 'menunggu_admin'));
    }

    public function scopeByPetugas($query, $petugasId)
    {
        return $query->where('petugas_id', $petugasId);
    }

    public function scopeDisetujui($query)
    {
        return $query->whereHas('statusPembayaran', fn($q) => $q->where('kode', 'disetujui'));
    }

    public function scopeByStatusKode($query, string $kode)
    {
        return $query->whereHas('statusPembayaran', fn($q) => $q->where('kode', $kode));
    }
}
