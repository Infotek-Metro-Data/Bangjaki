<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\StatusPembayaran;
use App\Models\StatusTagihan;
use App\Notifications\PembayaranStatusNotification;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function index(Request $request)
    {
        $pendingPayments = Pembayaran::with(['tagihan.pelanggan', 'petugas', 'metode'])
            ->whereHas('statusPembayaran', fn($q) => $q->where('kode', 'dikumpulkan'))
            ->latest()
            ->get();
        
        $currentPayment = null;
        
        if ($request->has('show')) {
            $currentPayment = Pembayaran::with(['tagihan.pelanggan', 'petugas', 'metode'])
                ->whereHas('statusPembayaran', fn($q) => $q->where('kode', 'dikumpulkan'))
                ->find($request->show);
        }
        
        return view('admin.verifikasi.index', compact('pendingPayments', 'currentPayment'));
    }

    public function show($id)
    {
        return redirect()->route('admin.verifikasi.index', ['show' => $id]);
    }

    public function approve(Request $request, $id)
    {
        $payment = Pembayaran::with(['tagihan.pelanggan', 'petugas'])->findOrFail($id);
        
        $statusDisetujui = StatusPembayaran::where('kode', 'disetujui')->first();
        $statusLunas = StatusTagihan::where('kode', 'lunas')->first();
        
        $payment->update([
            'status_id' => $statusDisetujui->id,
            'diverifikasi_oleh' => auth()->id(),
            'diverifikasi_pada' => now(),
        ]);
        
        $payment->tagihan->update(['status_id' => $statusLunas->id]);
        
        if ($payment->petugas) {
            $payment->petugas->notify(new PembayaranStatusNotification(
                'disetujui',
                $payment->tagihan->pelanggan->nama ?? 'Pelanggan',
                $payment->jumlah_bayar
            ));
        }
        
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Pembayaran disetujui!']);
        }
        
        return redirect()->route('admin.verifikasi.index')->with('success', 'Pembayaran berhasil disetujui!');
    }

    public function reject(Request $request, $id)
    {
        $payment = Pembayaran::with(['tagihan.pelanggan', 'petugas'])->findOrFail($id);
        $alasan = $request->input('alasan', 'Ditolak oleh admin');
        
        $statusDitolak = StatusPembayaran::where('kode', 'ditolak')->first();
        $statusBelumBayar = StatusTagihan::where('kode', 'belum_bayar')->first();
        
        $payment->update([
            'status_id' => $statusDitolak->id,
            'diverifikasi_oleh' => auth()->id(),
            'diverifikasi_pada' => now(),
            'catatan' => $alasan,
        ]);
        
        $payment->tagihan->update(['status_id' => $statusBelumBayar->id]);
        
        if ($payment->petugas) {
            $payment->petugas->notify(new PembayaranStatusNotification(
                'ditolak',
                $payment->tagihan->pelanggan->nama ?? 'Pelanggan',
                $payment->jumlah_bayar,
                $alasan
            ));
        }
        
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Pembayaran ditolak!']);
        }
        
        return redirect()->route('admin.verifikasi.index')->with('success', 'Pembayaran ditolak!');
    }
}
