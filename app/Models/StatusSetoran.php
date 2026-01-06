<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusSetoran extends Model
{
    protected $table = 'status_setoran';

    protected $fillable = ['kode', 'nama', 'aktif'];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function setoran()
    {
        return $this->hasMany(Setoran::class, 'status_id');
    }

    public static function getByKode(string $kode): ?self
    {
        return static::where('kode', $kode)->first();
    }
}
