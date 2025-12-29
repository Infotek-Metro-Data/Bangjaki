<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Tagihan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    public function index(Request $request)
    {
        $query = Tagihan::with('pelanggan');

        if ($request->search) {
            $query->whereHas('pelanggan', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->bulan) {
            $query->whereMonth('periode_mulai', $request->bulan);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $tagihan = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        $currentMonth = Carbon::now()->format('F Y');
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $totalTagihan = Tagihan::whereBetween('periode_mulai', [$startOfMonth, $endOfMonth])->count();
        $totalLunas = Tagihan::whereBetween('periode_mulai', [$startOfMonth, $endOfMonth])->where('status', 'lunas')->count();
        $nominalLunas = Tagihan::whereBetween('periode_mulai', [$startOfMonth, $endOfMonth])->where('status', 'lunas')->sum('jumlah_tagihan');
        $totalBelumBayar = Tagihan::whereBetween('periode_mulai', [$startOfMonth, $endOfMonth])->where('status', 'belum_bayar')->count();
        $nominalBelumBayar = Tagihan::whereBetween('periode_mulai', [$startOfMonth, $endOfMonth])->where('status', 'belum_bayar')->sum('jumlah_tagihan');
        $totalJatuhTempo = Tagihan::where('status', 'belum_bayar')->where('jatuh_tempo', '<', Carbon::now())->count();

        return view('admin.tagihan.index', compact(
            'tagihan',
            'currentMonth',
            'totalTagihan',
            'totalLunas',
            'nominalLunas',
            'totalBelumBayar',
            'nominalBelumBayar',
            'totalJatuhTempo'
        ));
    }

    public function generate(Request $request)
    {
        $now = Carbon::now();
        $periodeAwal = $now->copy()->startOfMonth();
        $periodeAkhir = $now->copy()->endOfMonth();
        $jatuhTempo = $now->copy()->endOfMonth()->addDays(7);

        $existingCount = Tagihan::where('periode_mulai', $periodeAwal->format('Y-m-d'))->count();
        if ($existingCount > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tagihan untuk bulan ini sudah di-generate sebelumnya.'
            ], 400);
        }

        $pelangganAktif = Pelanggan::where('status', 'aktif')->with('jenisPelanggan')->get();

        if ($pelangganAktif->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada pelanggan aktif untuk di-generate tagihan.'
            ], 400);
        }

        $count = 0;
        $totalNominal = 0;
        
        foreach ($pelangganAktif as $pelanggan) {
            $hargaFull = $pelanggan->iuran_khusus ?? $pelanggan->jenisPelanggan->harga_dasar ?? 50000;
            
            if ($pelanggan->tanggal_registrasi && $pelanggan->tanggal_registrasi >= $periodeAwal) {
                $sisaHari = $periodeAkhir->diffInDays($pelanggan->tanggal_registrasi) + 1;
                $totalHari = $periodeAkhir->day;
                $nominal = round($hargaFull * ($sisaHari / $totalHari));
            } else {
                $nominal = $hargaFull;
            }

            Tagihan::create([
                'pelanggan_id' => $pelanggan->id,
                'periode_mulai' => $periodeAwal,
                'periode_selesai' => $periodeAkhir,
                'jumlah_tagihan' => $nominal,
                'jatuh_tempo' => $jatuhTempo,
                'status' => 'belum_bayar',
            ]);
            $count++;
            $totalNominal += $nominal;
        }

        return response()->json([
            'success' => true,
            'message' => "Berhasil generate $count tagihan untuk bulan " . $now->format('F Y') . "."
        ]);
    }
}
