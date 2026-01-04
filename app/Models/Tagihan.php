<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $table = 'tagihan';

    protected $fillable = [
        'pelanggan_id',
        'periode_mulai',
        'periode_selesai',
        'jumlah_tagihan',
        'jatuh_tempo',
        'status_id',
    ];

    protected $casts = [
        'periode_mulai' => 'date',
        'periode_selesai' => 'date',
        'jatuh_tempo' => 'date',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function statusTagihan()
    {
        return $this->belongsTo(StatusTagihan::class, 'status_id');
    }

    public function getTotalTagihanAttribute()
    {
        return $this->jumlah_tagihan;
    }

    public function getStatusAttribute()
    {
        return $this->statusTagihan?->kode;
    }

    public function scopeBelumBayar($query)
    {
        return $query->whereHas('statusTagihan', fn($q) => $q->where('kode', 'belum_bayar'));
    }

    public function scopeLunas($query)
    {
        return $query->whereHas('statusTagihan', fn($q) => $q->where('kode', 'lunas'));
    }

    public function scopeJatuhTempoHariIni($query)
    {
        return $query->whereDate('jatuh_tempo', now()->toDateString());
    }

    public function scopeMenunggak($query)
    {
        return $query->whereHas('statusTagihan', fn($q) => $q->where('kode', 'belum_bayar'))
                     ->whereDate('jatuh_tempo', '<', now()->toDateString());
    }

    public function scopeByStatusKode($query, string $kode)
    {
        return $query->whereHas('statusTagihan', fn($q) => $q->where('kode', $kode));
    }
}
