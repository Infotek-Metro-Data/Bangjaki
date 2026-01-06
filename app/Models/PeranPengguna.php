<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeranPengguna extends Model
{
    protected $table = 'peran_pengguna';

    protected $fillable = ['kode', 'nama', 'aktif'];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function pengguna()
    {
        return $this->hasMany(Pengguna::class, 'peran_id');
    }

    public static function getByKode(string $kode): ?self
    {
        return static::where('kode', $kode)->first();
    }
}
