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
        Schema::table('users', function (Blueprint $table) {
            $table->index('email');
        });
        Schema::table('produks', function (Blueprint $table) {
            $table->index('nama_produk');
        });
        Schema::table('penjualans', function (Blueprint $table) {
            $table->index('waktu_transaksi');
            $table->index('id_pelanggan');
            $table->index('id_admin');
        });
        Schema::table('detail_penjualans', function (Blueprint $table) {
            $table->index('id_produk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['email']);
        });
        Schema::table('produks', function (Blueprint $table) {
            $table->dropIndex(['nama_produk']);
        });
        Schema::table('penjualans', function (Blueprint $table) {
            $table->dropIndex(['waktu_transaksi']);
            $table->dropIndex(['id_pelanggan']);
            $table->dropIndex(['id_admin']);
        });
        Schema::table('detail_penjualans', function (Blueprint $table) {
            $table->dropIndex(['id_produk']);
        });
    }
};
