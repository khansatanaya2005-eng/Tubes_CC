<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPenjualan extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     */
    protected $table = 'detail_penjualans'; // Laravel akan menebak 'detail_penjualans' dari 'DetailPenjualan', tapi eksplisit lebih baik.

    /**
     * Primary key untuk model ini.
     */
    protected $primaryKey = 'id_detail_penjualan';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     */
    protected $fillable = [
        'id_penjualan',
        'id_produk',
        'jumlah_produk',
        'harga_satuan_saat_transaksi',
        'subtotal_produk',
    ];

    /**
     * Atribut yang harus dikonversi ke tipe data tertentu.
     */
    protected $casts = [
        'harga_satuan_saat_transaksi' => 'decimal:2',
        'subtotal_produk' => 'decimal:2',
        'jumlah_produk' => 'integer',
    ];

    public function penjualan(): BelongsTo
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan', 'id_penjualan');
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}