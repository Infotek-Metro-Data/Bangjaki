<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Pengguna;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    private function applyHeaderStyle($sheet, $range)
    {
        $sheet->getStyle($range)->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'F97316'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'E5E7EB'],
                ],
            ],
        ]);
    }

    private function applyDataStyle($sheet, $range)
    {
        $sheet->getStyle($range)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'E5E7EB'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
    }

    private function autoFitColumns($sheet, $columns)
    {
        foreach ($columns as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    public function pelanggan(Request $request): StreamedResponse
    {
        $query = Pelanggan::with('jenisPelanggan');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%")
                  ->orWhere('alamat_lengkap', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('wilayah')) {
            $query->where('wilayah', $request->wilayah);
        }
        
        $pelanggan = $query->latest()->get();
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Pelanggan');
        
        $headers = ['ID', 'Nama', 'Telepon', 'Email', 'Alamat', 'Wilayah', 'Jenis Pelanggan', 'Iuran', 'Status', 'Tgl Registrasi'];
        $sheet->fromArray($headers, null, 'A1');
        $this->applyHeaderStyle($sheet, 'A1:J1');
        $sheet->getRowDimension(1)->setRowHeight(25);
        
        $row = 2;
        foreach ($pelanggan as $p) {
            $sheet->setCellValue("A{$row}", 'PLG-' . str_pad($p->id, 4, '0', STR_PAD_LEFT));
            $sheet->setCellValue("B{$row}", $p->nama);
            $sheet->setCellValue("C{$row}", $p->telepon);
            $sheet->setCellValue("D{$row}", $p->email ?? '-');
            $sheet->setCellValue("E{$row}", $p->alamat_lengkap);
            $sheet->setCellValue("F{$row}", $p->wilayah);
            $sheet->setCellValue("G{$row}", $p->jenisPelanggan->nama_paket ?? '-');
            $sheet->setCellValue("H{$row}", $p->iuran_khusus ?? $p->jenisPelanggan->harga_dasar ?? 0);
            $sheet->setCellValue("I{$row}", ucfirst($p->status));
            $sheet->setCellValue("J{$row}", $p->tanggal_registrasi?->format('d/m/Y') ?? '-');
            $row++;
        }
        
        if ($row > 2) {
            $this->applyDataStyle($sheet, "A2:J" . ($row - 1));
        }
        
        $sheet->getStyle("H2:H" . ($row - 1))->getNumberFormat()->setFormatCode('#,##0');
        
        $this->autoFitColumns($sheet, ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J']);
        
        $filename = 'pelanggan_' . date('Y-m-d_His') . '.xlsx';
        
        return new StreamedResponse(function() use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Cache-Control' => 'max-age=0',
        ]);
    }
    
    public function tagihan(Request $request): StreamedResponse
    {
        $query = Tagihan::with('pelanggan');
        
        if ($request->filled('search')) {
            $query->whereHas('pelanggan', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->filled('bulan')) {
            $query->whereMonth('periode_mulai', $request->bulan);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $tagihan = $query->latest()->get();
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Tagihan');
        
        $headers = ['ID Tagihan', 'Nama Pelanggan', 'Wilayah', 'Periode Mulai', 'Periode Selesai', 'Jumlah Tagihan', 'Jatuh Tempo', 'Status'];
        $sheet->fromArray($headers, null, 'A1');
        $this->applyHeaderStyle($sheet, 'A1:H1');
        $sheet->getRowDimension(1)->setRowHeight(25);
        
        $row = 2;
        foreach ($tagihan as $t) {
            $statusLabel = match($t->status) {
                'lunas' => 'Lunas',
                'belum_bayar' => 'Belum Bayar',
                'menunggu_verifikasi' => 'Menunggu Verifikasi',
                'ditolak' => 'Ditolak',
                default => ucfirst($t->status)
            };
            
            $sheet->setCellValue("A{$row}", 'TGH-' . str_pad($t->id, 5, '0', STR_PAD_LEFT));
            $sheet->setCellValue("B{$row}", $t->pelanggan->nama ?? '-');
            $sheet->setCellValue("C{$row}", $t->pelanggan->wilayah ?? '-');
            $sheet->setCellValue("D{$row}", $t->periode_mulai->format('d/m/Y'));
            $sheet->setCellValue("E{$row}", $t->periode_selesai->format('d/m/Y'));
            $sheet->setCellValue("F{$row}", $t->jumlah_tagihan);
            $sheet->setCellValue("G{$row}", $t->jatuh_tempo->format('d/m/Y'));
            $sheet->setCellValue("H{$row}", $statusLabel);
            
            $statusColor = match($t->status) {
                'lunas' => '10B981',
                'belum_bayar' => 'F59E0B',
                'menunggu_verifikasi' => '3B82F6',
                'ditolak' => 'EF4444',
                default => '6B7280'
            };
            $sheet->getStyle("H{$row}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($statusColor);
            $sheet->getStyle("H{$row}")->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFF'));
            
            $row++;
        }
        
        if ($row > 2) {
            $this->applyDataStyle($sheet, "A2:H" . ($row - 1));
        }
        
        $sheet->getStyle("F2:F" . ($row - 1))->getNumberFormat()->setFormatCode('#,##0');
        
        $this->autoFitColumns($sheet, ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H']);
        
        $filename = 'tagihan_' . date('Y-m-d_His') . '.xlsx';
        
        return new StreamedResponse(function() use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Cache-Control' => 'max-age=0',
        ]);
    }
    
    public function petugas(Request $request): StreamedResponse
    {
        $query = Pengguna::where('peran', 'petugas');
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%");
            });
        }
        
        $petugas = $query->latest()->get();
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Petugas');
        
        $headers = ['ID', 'Nama', 'Email', 'Telepon', 'Nomor Kendaraan', 'Status'];
        $sheet->fromArray($headers, null, 'A1');
        $this->applyHeaderStyle($sheet, 'A1:F1');
        $sheet->getRowDimension(1)->setRowHeight(25);
        
        $row = 2;
        foreach ($petugas as $p) {
            $sheet->setCellValue("A{$row}", 'PTG-' . str_pad($p->id, 4, '0', STR_PAD_LEFT));
            $sheet->setCellValue("B{$row}", $p->nama);
            $sheet->setCellValue("C{$row}", $p->email);
            $sheet->setCellValue("D{$row}", $p->telepon);
            $sheet->setCellValue("E{$row}", $p->nomor_kendaraan ?? '-');
            $sheet->setCellValue("F{$row}", ucfirst($p->status));
            
            $statusColor = match($p->status) {
                'aktif' => '10B981',
                'istirahat' => 'F59E0B',
                default => '6B7280'
            };
            $sheet->getStyle("F{$row}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($statusColor);
            $sheet->getStyle("F{$row}")->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFF'));
            
            $row++;
        }
        
        if ($row > 2) {
            $this->applyDataStyle($sheet, "A2:F" . ($row - 1));
        }
        
        $this->autoFitColumns($sheet, ['A', 'B', 'C', 'D', 'E', 'F']);
        
        $filename = 'petugas_' . date('Y-m-d_His') . '.xlsx';
        
        return new StreamedResponse(function() use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Cache-Control' => 'max-age=0',
        ]);
    }
}
