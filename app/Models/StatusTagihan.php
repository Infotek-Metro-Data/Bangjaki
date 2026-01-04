<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusTagihan extends Model
{
    protected $table = 'status_tagihan';

    protected $fillable = ['kode', 'nama', 'urutan', 'aktif'];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class, 'status_id');
    }

    public static function getByKode(string $kode): ?self
    {
        return static::where('kode', $kode)->first();
    }
}
