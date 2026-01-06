<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluhan extends Model
{
    use HasFactory;

    protected $table = 'keluhan';

    protected $fillable = [
        'pelanggan_id',
        'kategori_id',
        'deskripsi',
        'bukti_foto',
        'prioritas_id',
        'status_id',
        'tanggapan_admin',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function kategoriKeluhan()
    {
        return $this->belongsTo(KategoriKeluhan::class, 'kategori_id');
    }

    public function prioritasKeluhan()
    {
        return $this->belongsTo(PrioritasKeluhan::class, 'prioritas_id');
    }

    public function statusKeluhan()
    {
        return $this->belongsTo(StatusKeluhan::class, 'status_id');
    }

    public function getKategoriAttribute()
    {
        return $this->kategoriKeluhan?->kode;
    }

    public function getPrioritasAttribute()
    {
        return $this->prioritasKeluhan?->kode;
    }

    public function getStatusAttribute()
    {
        return $this->statusKeluhan?->kode;
    }

    public function scopeByStatusKode($query, string $kode)
    {
        return $query->whereHas('statusKeluhan', fn($q) => $q->where('kode', $kode));
    }

    public function scopeTerbuka($query)
    {
        return $query->whereHas('statusKeluhan', fn($q) => $q->where('kode', 'terbuka'));
    }
}
