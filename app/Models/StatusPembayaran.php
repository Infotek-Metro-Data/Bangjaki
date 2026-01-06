<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusPembayaran extends Model
{
    protected $table = 'status_pembayaran';

    protected $fillable = ['kode', 'nama', 'urutan', 'aktif'];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'status_id');
    }

    public static function getByKode(string $kode): ?self
    {
        return static::where('kode', $kode)->first();
    }
}
