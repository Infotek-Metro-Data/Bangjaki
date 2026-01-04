<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusPelanggan extends Model
{
    protected $table = 'status_pelanggan';

    protected $fillable = ['kode', 'nama', 'aktif'];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function pelanggan()
    {
        return $this->hasMany(Pelanggan::class, 'status_id');
    }

    public static function getByKode(string $kode): ?self
    {
        return static::where('kode', $kode)->first();
    }
}
