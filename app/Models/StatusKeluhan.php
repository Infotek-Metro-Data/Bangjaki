<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusKeluhan extends Model
{
    protected $table = 'status_keluhan';

    protected $fillable = ['kode', 'nama', 'urutan', 'aktif'];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function keluhan()
    {
        return $this->hasMany(Keluhan::class, 'status_id');
    }

    public static function getByKode(string $kode): ?self
    {
        return static::where('kode', $kode)->first();
    }
}
