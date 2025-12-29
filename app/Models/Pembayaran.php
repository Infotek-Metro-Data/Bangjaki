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
        'metode',
        'tanggal_bayar',
        'bukti_foto',
        'lokasi_lat',
        'lokasi_long',
        'status',
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

    public function scopeMenunggAdmin($query)
    {
        return $query->where('status', 'menunggu_admin');
    }

    public function scopeByPetugas($query, $petugasId)
    {
        return $query->where('petugas_id', $petugasId);
    }

    public function scopeDisetujui($query)
    {
        return $query->where('status', 'disetujui');
    }
}
