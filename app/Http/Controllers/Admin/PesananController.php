<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan; // <--- TAMBAHKAN INI
use App\Models\Penjualan; // <--- TAMBAHKAN INI
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <--- TAMBAHKAN INI
use Illuminate\Support\Facades\DB;   // <--- TAMBAHKAN INI
use App\Models\User; // Pastikan User di-import
use App\Notifications\PesananBaruNotification;

class PesananController extends Controller
{
    // ... (method index, addToCart, updateCart, removeFromCart, clearCart sudah ada dari langkah sebelumnya) ...
    public function index()
    {
        $produks = Produk::orderBy('nama_produk', 'asc')->get();
        $cart = session()->get('cart', []);

        $totalHargaKeranjang = 0;
        foreach ($cart as $item) {
            $totalHargaKeranjang += $item['harga'] * $item['jumlah'];
        }

        return view('admin.pesanan.index', compact('produks', 'cart', 'totalHargaKeranjang'));
    }

    public function addToCart(Produk $produk)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$produk->id_produk])) {
            $cart[$produk->id_produk]['jumlah']++;
        } else {
            $cart[$produk->id_produk] = [ "nama" => $produk->nama_produk, "jumlah" => 1, "harga" => $produk->harga_produk, "foto" => $produk->foto_produk ];
        }
        session()->put('cart', $cart);
        return redirect()->route('admin.pesanan.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function updateCart(Request $request)
    {
        $request->validate(['id_produk' => 'required', 'jumlah' => 'required|numeric|min:1']);
        $cart = session()->get('cart');
        if (isset($cart[$request->id_produk])) {
            $cart[$request->id_produk]['jumlah'] = $request->jumlah;
            session()->put('cart', $cart);
            return redirect()->route('admin.pesanan.index')->with('success', 'Jumlah produk berhasil diperbarui.');
        }
        return redirect()->route('admin.pesanan.index')->with('error', 'Produk tidak ditemukan di keranjang.');
    }

    public function removeFromCart(Request $request)
    {
        $request->validate(['id_produk' => 'required']);
        $cart = session()->get('cart');
        if (isset($cart[$request->id_produk])) {
            unset($cart[$request->id_produk]);
            session()->put('cart', $cart);
            return redirect()->route('admin.pesanan.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
        }
        return redirect()->route('admin.pesanan.index')->with('error', 'Produk tidak ditemukan di keranjang.');
    }

    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->route('admin.pesanan.index')->with('success', 'Keranjang berhasil dikosongkan.');
    }


    /**
     * Menyimpan pesanan dari keranjang ke database.
     */
    public function storeOrder(Request $request)
    {
        // 1. Validasi data input pelanggan
        $request->validate([
            'nama_pelanggan' => 'nullable|string|max:255',
            'kontak_pelanggan' => 'nullable|string|max:100',
            'catatan_penjualan' => 'nullable|string',
        ]);

        // 2. Ambil data keranjang dari session
        $cart = session()->get('cart');

        // Jika keranjang kosong, kembalikan dengan error
        if (!$cart || empty($cart)) {
            return redirect()->route('admin.pesanan.index')->with('error', 'Keranjang belanja kosong!');
        }

        try {
            // 3. Mulai Database Transaction
            $penjualan = DB::transaction(function () use ($request, $cart) {

                // Handle Pelanggan (Cari atau Buat Baru)
                $pelangganId = null;
                if ($request->filled('nama_pelanggan')) {
                    $pelanggan = Pelanggan::firstOrCreate(
                        ['nama_pelanggan' => $request->nama_pelanggan],
                        ['kontak_pelanggan' => $request->kontak_pelanggan]
                    );
                    $pelangganId = $pelanggan->id_pelanggan;
                }

                // Hitung total harga final dari keranjang
                $totalHarga = 0;
                foreach ($cart as $item) {
                    $totalHarga += $item['harga'] * $item['jumlah'];
                }

                // 4. Buat record di tabel 'penjualans'
                $penjualan = Penjualan::create([
                    'id_admin' => Auth::id(),
                    'id_pelanggan' => $pelangganId,
                    'waktu_transaksi' => now(),
                    'total_harga_penjualan' => $totalHarga,
                    'metode_pembayaran' => 'CASH', // Anda bisa membuat ini dinamis jika perlu
                    'catatan_penjualan' => $request->catatan_penjualan,
                ]);

                // 5. Buat record di tabel 'detail_penjualans' untuk setiap item
                foreach ($cart as $id_produk => $item) {
                    $penjualan->detailPenjualans()->create([
                        'id_produk' => $id_produk,
                        'jumlah_produk' => $item['jumlah'],
                        'harga_satuan_saat_transaksi' => $item['harga'],
                        'subtotal_produk' => $item['harga'] * $item['jumlah'],
                    ]);

                    // Opsional: Kurangi stok produk
                    // $produk = Produk::find($id_produk);
                    // $produk->stok_produk -= $item['jumlah'];
                    // $produk->save();
                }

                return $penjualan; // Kembalikan objek penjualan jika berhasil
            });

            // -- BAGIAN YANG DIPINDAHKAN DAN DIPERBAIKI --
            // 6. Jika transaksi berhasil, kirim notifikasi
            // Cari user admin untuk dikirimi notifikasi.
            // Anda bisa sesuaikan logika ini, misalnya mengirim ke semua admin.
            $adminUser = \App\Models\User::find(1);
            if ($adminUser) {
                $adminUser->notify(new \App\Notifications\PesananBaruNotification($penjualan));
            }
            // -- SELESAI BAGIAN YANG DIPERBAIKI --

            // 7. Jika transaksi dan notifikasi berhasil, kosongkan keranjang
            session()->forget('cart');

            // 8. Redirect ke halaman detail penjualan yang baru dibuat dengan pesan sukses
            return redirect()->route('admin.riwayatpenjualan.show', $penjualan->id_penjualan)
                             ->with('success', 'Transaksi berhasil disimpan!');

        } catch (\Exception $e) {
            // Jika terjadi error selama transaksi, kembalikan dengan pesan error
            // Error ini akan menangkap kegagalan dari DB::transaction atau dari pengiriman notifikasi
            \Log::error('Gagal menyimpan transaksi: ' . $e->getMessage()); // Catat error ke log
            return redirect()->route('admin.pesanan.index')->with('error', 'Terjadi kesalahan saat menyimpan transaksi.');
        }
    }
}