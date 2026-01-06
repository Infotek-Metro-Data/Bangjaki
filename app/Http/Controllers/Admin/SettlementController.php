<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Pengguna;
use App\Models\Setoran;
use App\Models\StatusPembayaran;
use App\Models\StatusSetoran;
use App\Models\StatusTagihan;
use Illuminate\Http\Request;

class SettlementController extends Controller
{
    public function index(Request $request)
    {
        $petugasList = Pengguna::whereHas('peranPengguna', fn($q) => $q->where('kode', 'petugas'))
            ->withSum(['pembayaran as pending_amount' => function($query) {
                $query->whereHas('statusPembayaran', fn($q) => $q->where('kode', 'dikumpulkan'))
                    ->whereNull('setoran_id');
            }], 'jumlah_bayar')
            ->get();
        
        $totalPending = Pembayaran::whereHas('statusPembayaran', fn($q) => $q->where('kode', 'dikumpulkan'))
            ->whereNull('setoran_id')
            ->sum('jumlah_bayar');
        
        $settledToday = Setoran::whereDate('tanggal_setor', today())
            ->whereHas('statusSetoran', fn($q) => $q->where('kode', 'selesai'))
            ->sum('total_uang_diterima');
        
        $activeAgents = $petugasList->filter(fn($p) => ($p->pending_amount ?? 0) > 0)->count();
        
        $selectedPetugas = $petugasList->first();
        $transactions = collect();
        
        return view('admin.settlement.index', compact(
            'petugasList', 
            'totalPending', 
            'settledToday', 
            'activeAgents',
            'selectedPetugas',
            'transactions'
        ));
    }

    public function show($id)
    {
        $petugasList = Pengguna::whereHas('peranPengguna', fn($q) => $q->where('kode', 'petugas'))
            ->withSum(['pembayaran as pending_amount' => function($query) {
                $query->whereHas('statusPembayaran', fn($q) => $q->where('kode', 'dikumpulkan'))
                    ->whereNull('setoran_id');
            }], 'jumlah_bayar')
            ->get();
        
        $selectedPetugas = $petugasList->firstWhere('id', $id);
        
        if (!$selectedPetugas) {
            return redirect()->route('admin.settlement.index');
        }
        
        $transactions = Pembayaran::with(['tagihan.pelanggan', 'metode'])
            ->where('petugas_id', $id)
            ->whereHas('statusPembayaran', fn($q) => $q->where('kode', 'dikumpulkan'))
            ->whereNull('setoran_id')
            ->latest()
            ->get();
        
        $totalPending = Pembayaran::whereHas('statusPembayaran', fn($q) => $q->where('kode', 'dikumpulkan'))
            ->whereNull('setoran_id')
            ->sum('jumlah_bayar');
        
        $settledToday = Setoran::whereDate('tanggal_setor', today())
            ->whereHas('statusSetoran', fn($q) => $q->where('kode', 'selesai'))
            ->sum('total_uang_diterima');
        
        $activeAgents = $petugasList->filter(fn($p) => ($p->pending_amount ?? 0) > 0)->count();
        
        return view('admin.settlement.index', compact(
            'petugasList',
            'totalPending',
            'settledToday',
            'activeAgents',
            'selectedPetugas',
            'transactions'
        ));
    }

    public function confirm(Request $request, $id)
    {
        $petugas = Pengguna::whereHas('peranPengguna', fn($q) => $q->where('kode', 'petugas'))
            ->findOrFail($id);
        
        $payments = Pembayaran::with('tagihan')
            ->where('petugas_id', $id)
            ->whereHas('statusPembayaran', fn($q) => $q->where('kode', 'dikumpulkan'))
            ->whereNull('setoran_id')
            ->get();
        
        if ($payments->isEmpty()) {
            return response()->json([
                'success' => false, 
                'message' => 'Tidak ada pembayaran yang perlu disetor'
            ], 400);
        }
        
        $totalAmount = $payments->sum('jumlah_bayar');
        
        $statusSelesai = StatusSetoran::where('kode', 'selesai')->first();
        $statusDisetor = StatusPembayaran::where('kode', 'disetor')->first();
        $statusLunas = StatusTagihan::where('kode', 'lunas')->first();
        
        $setoran = Setoran::create([
            'petugas_id' => $id,
            'total_tagihan_sistem' => $totalAmount,
            'total_uang_diterima' => $totalAmount,
            'tanggal_setor' => now(),
            'status_id' => $statusSelesai->id,
            'dikonfirmasi_oleh' => auth()->id(),
        ]);
        
        Pembayaran::whereIn('id', $payments->pluck('id'))
            ->update([
                'setoran_id' => $setoran->id,
                'status_id' => $statusDisetor->id,
                'diverifikasi_oleh' => auth()->id(),
                'diverifikasi_pada' => now(),
            ]);
        
        $tagihanIds = $payments->pluck('tagihan_id')->unique();
        \App\Models\Tagihan::whereIn('id', $tagihanIds)
            ->update(['status_id' => $statusLunas->id]);
        
        return response()->json([
            'success' => true, 
            'message' => 'Setoran berhasil dikonfirmasi! ' . $payments->count() . ' tagihan ditandai lunas.',
            'redirect' => route('admin.settlement.index')
        ]);
    }

    public function history(Request $request)
    {
        $query = Setoran::with(['petugas', 'konfirmator'])
            ->whereHas('statusSetoran', fn($q) => $q->where('kode', 'selesai'))
            ->latest('tanggal_setor');
        
        if ($request->filled('date')) {
            $query->whereDate('tanggal_setor', $request->date);
        }
        
        if ($request->filled('petugas_id')) {
            $query->where('petugas_id', $request->petugas_id);
        }
        
        $settlements = $query->paginate(15)->withQueryString();
        $petugasList = Pengguna::whereHas('peranPengguna', fn($q) => $q->where('kode', 'petugas'))->get();
        
        $totalSettled = Setoran::whereHas('statusSetoran', fn($q) => $q->where('kode', 'selesai'))
            ->sum('total_uang_diterima');
        $todaySettled = Setoran::whereHas('statusSetoran', fn($q) => $q->where('kode', 'selesai'))
            ->whereDate('tanggal_setor', today())
            ->sum('total_uang_diterima');
        
        return view('admin.settlement.history', compact('settlements', 'petugasList', 'totalSettled', 'todaySettled'));
    }
}
