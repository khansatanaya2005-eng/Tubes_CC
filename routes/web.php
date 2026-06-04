<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\PenjualanController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\NotifikasiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

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

// Health Check Endpoint
Route::get('/health', function () {
    try {
        DB::connection()->getPdo();
        $db_status = 'connected';
    } catch (\Exception $e) {
        $db_status = 'disconnected';
    }

    try {
        Cache::store()->get('health_check');
        $cache_status = 'connected';
    } catch (\Exception $e) {
        $cache_status = 'disconnected';
    }

    $storage_status = is_writable(storage_path()) ? 'writable' : 'unwritable';

    return response()->json([
        'status' => 'healthy',
        'database' => $db_status,
        'cache' => $cache_status,
        'storage' => $storage_status,
        'version' => '1.0.0'
    ]);
});

// Grup rute untuk admin yang hanya bisa diakses setelah login
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/admin/executive-overview', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Pelanggan (Admin & Kasir)
    Route::resource('/admin/guest-registry', PelangganController::class)->names([
        'index' => 'admin.pelanggan.index',
        'create' => 'admin.pelanggan.create',
        'store' => 'admin.pelanggan.store',
        'edit' => 'admin.pelanggan.edit',
        'update' => 'admin.pelanggan.update',
        'destroy' => 'admin.pelanggan.destroy',
    ])->except(['show'])->middleware('role:admin,kasir');

    // CRUD Produk (Admin Only)
    Route::resource('/admin/culinary-menu', ProdukController::class)->names([
        'index' => 'admin.produk.index',
        'create' => 'admin.produk.create',
        'store' => 'admin.produk.store',
        'edit' => 'admin.produk.edit',
        'update' => 'admin.produk.update',
        'destroy' => 'admin.produk.destroy',
    ])->except(['show'])->middleware('role:admin');

    // Riwayat Penjualan (Admin & Kasir)
    Route::get('/admin/transaction-log', [PenjualanController::class, 'index'])->name('admin.riwayatpenjualan.index')->middleware('role:admin,kasir');
    Route::get('/admin/transaction-log/{penjualan}', [PenjualanController::class, 'show'])->name('admin.riwayatpenjualan.show')->middleware('role:admin,kasir');

    // Fitur Pesanan / POS (Admin & Kasir)
    Route::middleware('role:admin,kasir')->group(function () {
        Route::get('/admin/dine-in-orders', [PesananController::class, 'index'])->name('admin.pesanan.index');
        Route::post('/admin/dine-in-orders/add-to-cart/{produk}', [PesananController::class, 'addToCart'])->name('admin.pesanan.addToCart');
        Route::post('/admin/dine-in-orders/update-cart', [PesananController::class, 'updateCart'])->name('admin.pesanan.updateCart');
        Route::post('/admin/dine-in-orders/remove-from-cart', [PesananController::class, 'removeFromCart'])->name('admin.pesanan.removeFromCart');
        Route::post('/admin/dine-in-orders/clear-cart', [PesananController::class, 'clearCart'])->name('admin.pesanan.clearCart');
        Route::post('/admin/dine-in-orders/store', [PesananController::class, 'storeOrder'])->name('admin.pesanan.storeOrder');
    });

    // Activity Logs
    Route::get('/admin/activity-logs', [App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('admin.activitylogs.index')->middleware('role:admin');

    // Notifikasi
    Route::get('/admin/notifications', [NotifikasiController::class, 'index'])->name('admin.notifikasi.index')->middleware('role:admin,kasir');
    Route::post('/admin/notifications/mark-all-as-read', [NotifikasiController::class, 'markAllAsRead'])->name('admin.notifikasi.markAllAsRead')->middleware('role:admin,kasir');

    // Profil (bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Customer Journey (Pelanggan - Fine Dining Table System)
Route::get('/meja', [App\Http\Controllers\Customer\StoreController::class, 'mejaInput'])->name('pelanggan.meja');
Route::post('/meja/set', [App\Http\Controllers\Customer\StoreController::class, 'setMeja'])->name('pelanggan.meja.set');
Route::post('/meja/clear', [App\Http\Controllers\Customer\StoreController::class, 'clearMeja'])->name('pelanggan.meja.clear');

Route::middleware(['web'])->group(function () {
    Route::get('/pelanggan/katalog', [App\Http\Controllers\Customer\StoreController::class, 'index'])->name('pelanggan.katalog');
    Route::post('/pelanggan/cart/add/{produk}', [App\Http\Controllers\Customer\StoreController::class, 'addToCart'])->name('pelanggan.cart.add');
    Route::post('/pelanggan/cart/checkout', [App\Http\Controllers\Customer\StoreController::class, 'checkout'])->name('pelanggan.cart.checkout');
    Route::get('/pelanggan/pesanan-saya', [App\Http\Controllers\Customer\StoreController::class, 'orders'])->name('pelanggan.orders');
});


// Baris ini memuat semua rute untuk login, logout, register, dll.
require __DIR__.'/auth.php';