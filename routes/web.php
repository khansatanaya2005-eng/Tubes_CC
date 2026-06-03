<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\PenjualanController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\NotifikasiController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Mengarahkan alamat utama langsung ke halaman login.
Route::get('/', function () {
    return redirect()->route('login');
});

// Grup rute untuk admin yang hanya bisa diakses setelah login
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Pelanggan
    Route::resource('/admin/pelanggan', PelangganController::class)->names([
        'index' => 'admin.pelanggan.index',
        'create' => 'admin.pelanggan.create',
        'store' => 'admin.pelanggan.store',
        'edit' => 'admin.pelanggan.edit',
        'update' => 'admin.pelanggan.update',
        'destroy' => 'admin.pelanggan.destroy',
    ])->except(['show']);

    // CRUD Produk
    Route::resource('/admin/produk', ProdukController::class)->names([
        'index' => 'admin.produk.index',
        'create' => 'admin.produk.create',
        'store' => 'admin.produk.store',
        'edit' => 'admin.produk.edit',
        'update' => 'admin.produk.update',
        'destroy' => 'admin.produk.destroy',
    ])->except(['show']);

    // Riwayat Penjualan
    Route::get('/admin/riwayat-penjualan', [PenjualanController::class, 'index'])->name('admin.riwayatpenjualan.index');
    Route::get('/admin/riwayat-penjualan/{penjualan}', [PenjualanController::class, 'show'])->name('admin.riwayatpenjualan.show');

    // Fitur Pesanan (POS)
    Route::get('/admin/pesanan', [PesananController::class, 'index'])->name('admin.pesanan.index');
    Route::post('/admin/pesanan/add-to-cart/{produk}', [PesananController::class, 'addToCart'])->name('admin.pesanan.addToCart');
    Route::post('/admin/pesanan/update-cart', [PesananController::class, 'updateCart'])->name('admin.pesanan.updateCart');
    Route::post('/admin/pesanan/remove-from-cart', [PesananController::class, 'removeFromCart'])->name('admin.pesanan.removeFromCart');
    Route::post('/admin/pesanan/clear-cart', [PesananController::class, 'clearCart'])->name('admin.pesanan.clearCart');
    Route::post('/admin/pesanan/store', [PesananController::class, 'storeOrder'])->name('admin.pesanan.storeOrder');

    // Notifikasi
    Route::get('/admin/notifikasi', [NotifikasiController::class, 'index'])->name('admin.notifikasi.index');
    Route::post('/admin/notifikasi/mark-all-as-read', [NotifikasiController::class, 'markAllAsRead'])->name('admin.notifikasi.markAllAsRead');

    // Profil (bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Baris ini memuat semua rute untuk login, logout, register, dll.
require __DIR__.'/auth.php';