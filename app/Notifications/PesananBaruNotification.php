<?php

namespace App\Notifications;

use App\Models\Penjualan; // Import model Penjualan
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PesananBaruNotification extends Notification
{
    use Queueable;

    protected $penjualan; // Properti untuk menyimpan data penjualan

    /**
     * Create a new notification instance.
     */
    public function __construct(Penjualan $penjualan)
    {
        $this->penjualan = $penjualan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Kita akan menyimpan notifikasi di database
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        // Ambil nama pelanggan dengan aman
        $namaPelanggan = $this->penjualan->pelanggan?->nama_pelanggan ?? 'Pelanggan Umum';

        // Data yang akan disimpan di kolom 'data' (format JSON) pada tabel notifications
        return [
            'id_penjualan' => $this->penjualan->id_penjualan,
            'nama_pelanggan' => $namaPelanggan,
            'total_harga' => $this->penjualan->total_harga_penjualan,
            'message' => "Pesanan baru #{$this->penjualan->id_penjualan} dari {$namaPelanggan} telah masuk.",
            'url' => route('admin.riwayatpenjualan.show', $this->penjualan->id_penjualan),
        ];
    }
}