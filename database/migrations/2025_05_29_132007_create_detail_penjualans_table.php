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
        Schema::create('detail_penjualans', function (Blueprint $table) {
            $table->id('id_detail_penjualan'); // Primary Key 'id_detail_penjualan'

            // Foreign key ke tabel 'penjualans'
            $table->foreignId('id_penjualan')->constrained('penjualans', 'id_penjualan')->onDelete('cascade');
            // Jika data penjualan induk dihapus, detailnya juga ikut terhapus (cascade)

            // Foreign key ke tabel 'produks'
            $table->foreignId('id_produk')->constrained('produks', 'id_produk')->onDelete('restrict');
            // Jika produk dihapus, idealnya tidak bisa jika masih ada di detail penjualan.
            // Alternatif: onDelete('set null') jika id_produk boleh null dan ada penanganan khusus,
            // atau biarkan restrict agar integritas data harga saat transaksi terjaga.

            $table->integer('jumlah_produk');
            $table->decimal('harga_satuan_saat_transaksi', 10, 2); // Harga produk pada saat transaksi tersebut
            $table->decimal('subtotal_produk', 12, 2); // jumlah_produk * harga_satuan_saat_transaksi

            // Meskipun bisa dihitung, menyimpan subtotal bisa berguna untuk query dan historis.
            // created_at dan updated_at tetap disertakan untuk konsistensi dan jika ada perubahan di masa depan.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penjualans');
    }
};