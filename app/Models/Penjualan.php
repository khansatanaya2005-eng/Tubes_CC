<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Tambahkan ini
use Illuminate\Database\Eloquent\Relations\HasMany;  // Tambahkan ini

class Penjualan extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     */
    protected $table = 'penjualans';

    /**
     * Primary key untuk model ini.
     */
    protected $primaryKey = 'id_penjualan';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     */
    protected $fillable = [
        'id_admin', // Ini merujuk ke users.id
        'id_pelanggan',
        'waktu_transaksi',
        'total_harga_penjualan',
        'metode_pembayaran',
        'catatan_penjualan',
    ];

    public function admin(): BelongsTo
    {
        // Foreign key di tabel 'penjualans' adalah 'id_admin'
        // Owner key di tabel 'users' adalah 'id' (PK default User model)
        return $this->belongsTo(User::class, 'id_admin', 'id');
    }

    public function pelanggan(): BelongsTo
    {
        // Foreign key di tabel 'penjualans' adalah 'id_pelanggan'
        // Owner key di tabel 'pelanggans' adalah 'id_pelanggan' (PK Pelanggan model)
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function detailPenjualans(): HasMany
    {
        // Foreign key di tabel 'detail_penjualans' adalah 'id_penjualan'
        // Local key di tabel 'penjualans' adalah 'id_penjualan' (PK Penjualan model)
        return $this->hasMany(DetailPenjualan::class, 'id_penjualan', 'id_penjualan');
    }

    /**
     * Atribut yang harus dikonversi ke tipe data tertentu.
     */
    protected $casts = [
        'waktu_transaksi' => 'datetime', // Pastikan waktu_transaksi diperlakukan sebagai objek Carbon (datetime)
        'total_harga_penjualan' => 'decimal:2',
    ];
}