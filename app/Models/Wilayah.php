<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;

    protected $table = 'wilayah';

    protected $fillable = [
        'nama',
        'deskripsi',
    ];

    public function pelanggan()
    {
        return $this->hasMany(Pelanggan::class, 'wilayah', 'nama');
    }
}
