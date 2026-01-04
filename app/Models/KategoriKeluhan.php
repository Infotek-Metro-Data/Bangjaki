<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriKeluhan extends Model
{
    protected $table = 'kategori_keluhan';

    protected $fillable = ['kode', 'nama', 'aktif'];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function keluhan()
    {
        return $this->hasMany(Keluhan::class, 'kategori_id');
    }

    public static function getByKode(string $kode): ?self
    {
        return static::where('kode', $kode)->first();
    }
}
