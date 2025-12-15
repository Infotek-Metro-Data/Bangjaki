<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;

class PetugasTagihanController extends Controller
{
    public function index()
    {
        $tagihan = Tagihan::with('pelanggan')
            ->belumBayar()
            ->latest()
            ->paginate(20);

        return view('petugas.tagihan.index', compact('tagihan'));
    }
}
