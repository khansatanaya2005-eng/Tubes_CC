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
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id('id_pelanggan'); // Primary Key, Auto Increment, dengan nama kolom 'id_pelanggan'
            $table->string('nama_pelanggan');
            $table->string('kontak_pelanggan')->nullable(); // Kontak bisa nomor telepon atau email, boleh kosong
            $table->timestamps(); // Otomatis membuat kolom `created_at` dan `updated_at`
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};