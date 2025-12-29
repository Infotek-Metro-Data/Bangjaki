<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PembayaranStatusNotification extends Notification
{
    use Queueable;

    protected string $status;
    protected string $namaPelanggan;
    protected int $jumlah;
    protected ?string $alasan;

    public function __construct(string $status, string $namaPelanggan, int $jumlah, ?string $alasan = null)
    {
        $this->status = $status;
        $this->namaPelanggan = $namaPelanggan;
        $this->jumlah = $jumlah;
        $this->alasan = $alasan;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $message = $this->status === 'disetujui'
            ? "Pembayaran untuk {$this->namaPelanggan} sebesar Rp " . number_format($this->jumlah, 0, ',', '.') . " telah disetujui."
            : "Pembayaran untuk {$this->namaPelanggan} sebesar Rp " . number_format($this->jumlah, 0, ',', '.') . " ditolak.";
        
        if ($this->status === 'ditolak' && $this->alasan) {
            $message .= " Alasan: {$this->alasan}";
        }

        return [
            'status' => $this->status,
            'nama_pelanggan' => $this->namaPelanggan,
            'jumlah' => $this->jumlah,
            'alasan' => $this->alasan,
            'message' => $message,
            'icon' => $this->status === 'disetujui' ? 'check_circle' : 'cancel',
            'color' => $this->status === 'disetujui' ? 'green' : 'red',
        ];
    }

    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
