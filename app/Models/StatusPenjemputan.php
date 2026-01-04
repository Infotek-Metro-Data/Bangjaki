<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusPenjemputan extends Model
{
    protected $table = 'status_penjemputan';

    protected $fillable = ['kode', 'nama', 'aktif'];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function penjemputan()
    {
        return $this->hasMany(Penjemputan::class, 'status_id');
    }

    public static function getByKode(string $kode): ?self
    {
        return static::where('kode', $kode)->first();
    }
}
