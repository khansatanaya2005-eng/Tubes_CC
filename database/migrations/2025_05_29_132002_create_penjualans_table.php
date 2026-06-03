<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id('id_penjualan'); // Primary Key 'id_penjualan'

            // Foreign key untuk admin/user yang melakukan transaksi
            // Mengacu pada tabel 'users' yang dibuat oleh Laravel Breeze (PK nya 'id')
            $table->foreignId('id_admin')->constrained('users')->onDelete('cascade');
            // 'constrained('users')' akan otomatis mengacu ke kolom 'id' di tabel 'users'
            // 'onDelete('cascade')' berarti jika user admin dihapus, penjualan terkait juga akan dihapus (opsional, sesuaikan jika logikanya beda)

            // Foreign key untuk pelanggan, boleh null jika penjualan tanpa data pelanggan spesifik
            $table->foreignId('id_pelanggan')->nullable()->constrained('pelanggans', 'id_pelanggan')->onDelete('set null');
            // 'constrained('pelanggans', 'id_pelanggan')' mengacu ke kolom 'id_pelanggan' di tabel 'pelanggans'
            // 'onDelete('set null')' berarti jika pelanggan dihapus, id_pelanggan di penjualan ini akan jadi NULL

            $table->timestamp('waktu_transaksi')->useCurrent(); // Waktu transaksi, defaultnya waktu saat ini
            $table->decimal('total_harga_penjualan', 12, 2); // Total harga, 12 digit total, 2 di belakang koma
            $table->string('metode_pembayaran')->default('CASH'); // Metode pembayaran, default 'CASH' karena hanya itu
            $table->text('catatan_penjualan')->nullable(); // Catatan tambahan untuk penjualan, boleh kosong
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};