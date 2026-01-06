<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrioritasKeluhan extends Model
{
    protected $table = 'prioritas_keluhan';

    protected $fillable = ['kode', 'nama', 'aktif'];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function keluhan()
    {
        return $this->hasMany(Keluhan::class, 'prioritas_id');
    }

    public static function getByKode(string $kode): ?self
    {
        return static::where('kode', $kode)->first();
    }
}
