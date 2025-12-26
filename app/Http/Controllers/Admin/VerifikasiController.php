<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Notifications\PembayaranStatusNotification;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function index(Request $request)
    {
        $pendingPayments = Pembayaran::with(['tagihan.pelanggan', 'petugas'])
            ->where('status', 'menunggu_admin')
            ->latest()
            ->get();
        
        $currentPayment = null;
        
        if ($request->has('show')) {
            $currentPayment = Pembayaran::with(['tagihan.pelanggan', 'petugas'])
                ->where('status', 'menunggu_admin')
                ->find($request->show);
        }
        
        if (!$currentPayment && $pendingPayments->isNotEmpty()) {
            $currentPayment = $pendingPayments->first();
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
        
        $payment->update([
            'status' => 'disetujui',
            'diverifikasi_oleh' => auth()->id(),
            'diverifikasi_pada' => now(),
        ]);
        
        $payment->tagihan->update(['status' => 'lunas']);
        
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
        
        return back()->with('success', 'Pembayaran berhasil disetujui!');
    }

    public function reject(Request $request, $id)
    {
        $payment = Pembayaran::with(['tagihan.pelanggan', 'petugas'])->findOrFail($id);
        $alasan = $request->input('alasan', 'Ditolak oleh admin');
        
        $payment->update([
            'status' => 'ditolak',
            'diverifikasi_oleh' => auth()->id(),
            'diverifikasi_pada' => now(),
            'catatan' => $alasan,
        ]);
        
        $payment->tagihan->update(['status' => 'belum_bayar']);
        
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
        
        return back()->with('success', 'Pembayaran ditolak!');
    }
}
