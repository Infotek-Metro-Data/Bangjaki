<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setoran extends Model
{
    use HasFactory;

    protected $table = 'setoran';

    protected $fillable = [
        'petugas_id',
        'total_tagihan_sistem',
        'total_uang_diterima',
        'selisih',
        'dikonfirmasi_oleh',
    ];

    public function petugas()
    {
        return $this->belongsTo(Pengguna::class, 'petugas_id');
    }

    public function admin()
    {
        return $this->belongsTo(Pengguna::class, 'dikonfirmasi_oleh');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }
}
