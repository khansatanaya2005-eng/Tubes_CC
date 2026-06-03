<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelanggan extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     * Laravel biasanya bisa menebak jika nama model adalah bentuk singular dari nama tabel (Pelanggan -> pelanggans).
     * Namun, jika berbeda, atau untuk kejelasan, bisa didefinisikan secara eksplisit.
     */
    protected $table = 'pelanggans';

    /**
     * Primary key untuk model ini.
     * Defaultnya adalah 'id'. Kita ganti karena menggunakan 'id_pelanggan'.
     */
    protected $primaryKey = 'id_pelanggan';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * Ini penting untuk keamanan saat membuat atau mengupdate record.
     */
    protected $fillable = [
        'nama_pelanggan',
        'kontak_pelanggan',
    ];

    /**
     * Atribut yang harusnya berupa tipe tanggal (date/datetime).
     * `created_at` dan `updated_at` sudah otomatis ditangani Eloquent jika ada kolomnya.
     */
    // protected $dates = []; // Kosongkan jika hanya created_at dan updated_at

    public function penjualans(): HasMany
    {
        return $this->hasMany(Penjualan::class, 'id_pelanggan', 'id_pelanggan');
    }
}