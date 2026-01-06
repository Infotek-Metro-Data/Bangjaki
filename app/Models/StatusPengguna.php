<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusPengguna extends Model
{
    protected $table = 'status_pengguna';

    protected $fillable = ['kode', 'nama', 'aktif'];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function pengguna()
    {
        return $this->hasMany(Pengguna::class, 'status_id');
    }

    public static function getByKode(string $kode): ?self
    {
        return static::where('kode', $kode)->first();
    }
}
