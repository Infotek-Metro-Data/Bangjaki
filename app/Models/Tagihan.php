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
        'status',
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

    public function getTotalTagihanAttribute()
    {
        return $this->jumlah_tagihan;
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function scopeBelumBayar($query)
    {
        return $query->where('status', 'belum_bayar');
    }

    public function scopeJatuhTempoHariIni($query)
    {
        return $query->whereDate('jatuh_tempo', now()->toDateString());
    }

    public function scopeMenunggak($query)
    {
        return $query->where('status', 'belum_bayar')
                     ->whereDate('jatuh_tempo', '<', now()->toDateString());
    }
}
