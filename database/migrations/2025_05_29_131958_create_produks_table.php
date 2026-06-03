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
        Schema::create('produks', function (Blueprint $table) {
            $table->id('id_produk'); // Primary Key 'id_produk'
            $table->string('nama_produk');
            $table->decimal('harga_produk', 10, 2); // Untuk harga, gunakan decimal. 10 digit total, 2 di belakang koma
            $table->string('foto_produk')->nullable(); // Path atau URL foto, boleh kosong
            $table->text('deskripsi_produk')->nullable(); // Deskripsi bisa panjang, gunakan text, boleh kosong
            $table->string('kategori_produk')->nullable(); // Kategori produk, boleh kosong
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};