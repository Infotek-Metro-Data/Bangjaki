<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Pengguna;
use App\Models\Setoran;
use Illuminate\Http\Request;

class SettlementController extends Controller
{
    public function index(Request $request)
    {
        $petugasList = Pengguna::where('peran', 'petugas')
            ->withSum(['pembayaran as pending_amount' => function($query) {
                $query->where('status', 'disetujui')->whereNull('setoran_id');
            }], 'jumlah_bayar')
            ->get();
        
        $totalPending = Pembayaran::where('status', 'disetujui')
            ->whereNull('setoran_id')
            ->sum('jumlah_bayar');
        
        $settledToday = Setoran::whereDate('tanggal_setor', today())
            ->where('status', 'selesai')
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
        $petugasList = Pengguna::where('peran', 'petugas')
            ->withSum(['pembayaran as pending_amount' => function($query) {
                $query->where('status', 'disetujui')->whereNull('setoran_id');
            }], 'jumlah_bayar')
            ->get();
        
        $selectedPetugas = $petugasList->firstWhere('id', $id);
        
        if (!$selectedPetugas) {
            return redirect()->route('admin.settlement.index');
        }
        
        $transactions = Pembayaran::with(['tagihan.pelanggan'])
            ->where('petugas_id', $id)
            ->where('status', 'disetujui')
            ->whereNull('setoran_id')
            ->latest()
            ->get();
        
        $totalPending = Pembayaran::where('status', 'disetujui')
            ->whereNull('setoran_id')
            ->sum('jumlah_bayar');
        
        $settledToday = Setoran::whereDate('tanggal_setor', today())
            ->where('status', 'selesai')
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
        $petugas = Pengguna::where('peran', 'petugas')->findOrFail($id);
        
        $payments = Pembayaran::where('petugas_id', $id)
            ->where('status', 'disetujui')
            ->whereNull('setoran_id')
            ->get();
        
        if ($payments->isEmpty()) {
            return response()->json([
                'success' => false, 
                'message' => 'Tidak ada pembayaran yang perlu disetor'
            ], 400);
        }
        
        $totalAmount = $payments->sum('jumlah_bayar');
        
        $setoran = Setoran::create([
            'petugas_id' => $id,
            'total_tagihan_sistem' => $totalAmount,
            'total_uang_diterima' => $totalAmount,
            'tanggal_setor' => now(),
            'status' => 'selesai',
            'dikonfirmasi_oleh' => auth()->id(),
        ]);
        
        Pembayaran::whereIn('id', $payments->pluck('id'))
            ->update([
                'setoran_id' => $setoran->id,
                'status' => 'disetor',
            ]);
        
        return response()->json([
            'success' => true, 
            'message' => 'Setoran berhasil dikonfirmasi!',
            'redirect' => route('admin.settlement.index')
        ]);
    }

    public function history(Request $request)
    {
        $query = Setoran::with(['petugas', 'konfirmator'])
            ->where('status', 'selesai')
            ->latest('tanggal_setor');
        
        if ($request->filled('date')) {
            $query->whereDate('tanggal_setor', $request->date);
        }
        
        if ($request->filled('petugas_id')) {
            $query->where('petugas_id', $request->petugas_id);
        }
        
        $settlements = $query->paginate(15)->withQueryString();
        $petugasList = Pengguna::where('peran', 'petugas')->get();
        
        $totalSettled = Setoran::where('status', 'selesai')->sum('total_uang_diterima');
        $todaySettled = Setoran::where('status', 'selesai')
            ->whereDate('tanggal_setor', today())
            ->sum('total_uang_diterima');
        
        return view('admin.settlement.history', compact('settlements', 'petugasList', 'totalSettled', 'todaySettled'));
    }
}
