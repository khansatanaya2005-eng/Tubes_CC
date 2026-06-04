<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * Nama tabel yang terhubung dengan model ini.
     */
    protected $table = 'produks';

    /**
     * Primary key untuk model ini.
     */
    protected $primaryKey = 'id_produk';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     */
    protected $fillable = [
        'nama_produk',
        'harga_produk',
        'foto_produk',
        'deskripsi_produk',
        'kategori_produk',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logFillable()
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }

    /**
     * Atribut yang harus dikonversi ke tipe data tertentu.
     * Ini berguna untuk memastikan harga_produk selalu berupa float/decimal.
     */
    protected $casts = [
        'harga_produk' => 'decimal:2', // Mengkonversi ke desimal dengan 2 angka di belakang koma
    ];

    public function detailPenjualans(): HasMany
    {
        return $this->hasMany(DetailPenjualan::class, 'id_produk', 'id_produk');
    }
}