<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\PesananBaruNotification;
use App\Models\User;

class StoreController extends Controller
{
    // 1. Table Input Landing Page
    public function mejaInput()
    {
        return view('customer.meja');
    }

    // 2. Set Table Session
    public function setMeja(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'nomor_meja' => 'required|string|max:10'
        ]);

        // Register table as a guest customer if not exists
        $pelanggan = Pelanggan::firstOrCreate(
            ['nama_pelanggan' => $request->nama_pelanggan],
            ['kontak_pelanggan' => 'Meja ' . $request->nomor_meja]
        );

        session([
            'nomor_meja' => $request->nomor_meja,
            'nama_pelanggan' => $request->nama_pelanggan,
            'id_pelanggan' => $pelanggan->id_pelanggan
        ]);
        return redirect()->route('pelanggan.katalog');
    }

    // 3. Clear Table Session
    public function clearMeja()
    {
        session()->forget(['nomor_meja', 'nama_pelanggan', 'id_pelanggan']);
        return redirect()->route('pelanggan.meja');
    }

    public function index()
    {
        if (!session()->has('nomor_meja')) {
            return redirect()->route('pelanggan.meja')->with('error', 'Please enter your table number first.');
        }

        // Ambil produk dan kelompokkan berdasarkan kategori
        // Default kategori jika kosong: 'Lainnya'
        $produksGrouped = Produk::orderBy('nama_produk', 'asc')
            ->get()
            ->groupBy(function($item) {
                return $item->kategori_produk ?: 'Lainnya';
            });
            
        // Susunan kategori khusus agar Makanan dan Minuman terurut rapi
        $categoryOrder = [
            'Main Course', 'Appetizer', 'Dessert', 'Snack',
            'Coffee', 'Non Coffee', 'Tea', 'Signature', 'Mocktails',
            'Lainnya'
        ];

        // Sort grup berdasarkan array order
        $produksGrouped = $produksGrouped->sortBy(function($collection, $key) use ($categoryOrder) {
            $pos = array_search($key, $categoryOrder);
            return $pos === false ? 999 : $pos;
        });

        return view('customer.katalog', compact('produksGrouped'));
    }

    // 5. Direct Order (Dine-in Order)
    public function addToCart(Request $request, Produk $produk)
    {
        if (!session()->has('nomor_meja')) {
            return redirect()->route('pelanggan.meja')->with('error', 'Session expired. Please enter table number.');
        }

        $request->validate([
            'jumlah' => 'required|integer|min:1'
        ]);

        $pelanggan = Pelanggan::find(session('id_pelanggan'));

        if (!$pelanggan) {
            return redirect()->route('pelanggan.meja')->with('error', 'Table configuration error.');
        }

        DB::beginTransaction();
        try {
            $totalHarga = $produk->harga_produk * $request->jumlah;

            // Cari transaksi yang belum selesai untuk pelanggan ini hari ini
            $penjualan = Penjualan::where('id_pelanggan', $pelanggan->id_pelanggan)
                ->whereDate('waktu_transaksi', now()->toDateString())
                ->first();

            if (!$penjualan) {
                $penjualan = Penjualan::create([
                    'id_admin' => 1, // Default to main admin
                    'id_pelanggan' => $pelanggan->id_pelanggan,
                    'waktu_transaksi' => now(),
                    'total_harga_penjualan' => 0,
                    'metode_pembayaran' => 'CASH', // Default for dine-in
                    'catatan_penjualan' => 'Dine-in Order from Table ' . session('nomor_meja'),
                ]);
            }

            // Update total transaksi
            $penjualan->increment('total_harga_penjualan', $totalHarga);

            // Cek apakah produk ini sudah ada di transaksi
            $detail = $penjualan->detailPenjualans()->where('id_produk', $produk->id_produk)->first();
            
            if ($detail) {
                // Update jumlah dan subtotal jika sudah ada
                $detail->jumlah_produk += $request->jumlah;
                $detail->subtotal_produk += $totalHarga;
                $detail->save();
            } else {
                // Tambahkan produk baru
                $penjualan->detailPenjualans()->create([
                    'id_produk' => $produk->id_produk,
                    'jumlah_produk' => $request->jumlah,
                    'harga_satuan_saat_transaksi' => $produk->harga_produk,
                    'subtotal_produk' => $totalHarga,
                ]);
            }

            $adminUser = User::where('role', 'admin')->first();
            if ($adminUser) {
                $adminUser->notify(new PesananBaruNotification($penjualan));
            }

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesanan berhasil ditambahkan untuk Table ' . session('nomor_meja') . '.'
                ]);
            }

            return redirect()->route('pelanggan.katalog')->with('success', 'Culinary order placed for Table ' . session('nomor_meja') . '.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan pesanan.'
                ], 500);
            }
            
            return back()->with('error', 'Failed to place order.');
        }
    }

    // 6. View My Orders
    public function orders()
    {
        if (!session()->has('nomor_meja')) {
            return redirect()->route('pelanggan.meja');
        }

        $pelanggan = Pelanggan::find(session('id_pelanggan'));
        $myOrders = collect();

        if ($pelanggan) {
            // Only get today's orders for this table to prevent seeing history from previous days
            $myOrders = Penjualan::with('detailPenjualans.produk')
                                ->where('id_pelanggan', $pelanggan->id_pelanggan)
                                ->whereDate('waktu_transaksi', now()->toDateString())
                                ->orderBy('waktu_transaksi', 'desc')
                                ->get();
        }

        return view('customer.orders', compact('myOrders'));
    }

    // 7. QRIS Payment View
    public function qrisPayment()
    {
        if (!session()->has('nomor_meja')) {
            return redirect()->route('pelanggan.meja');
        }

        $pelanggan = Pelanggan::find(session('id_pelanggan'));
        $myOrders = collect();
        $totalPayment = 0;

        if ($pelanggan) {
            $myOrders = Penjualan::with('detailPenjualans.produk')
                                ->where('id_pelanggan', $pelanggan->id_pelanggan)
                                ->whereDate('waktu_transaksi', now()->toDateString())
                                ->orderBy('waktu_transaksi', 'desc')
                                ->get();
                                
            $totalPayment = $myOrders->sum('total_harga_penjualan');
        }

        return view('customer.qris', compact('myOrders', 'totalPayment'));
    }
    // 8. Process QRIS Payment (Simulation)
    public function qrisPay()
    {
        if (!session()->has('id_pelanggan')) {
            return redirect()->route('pelanggan.meja');
        }

        $pelanggan = Pelanggan::find(session('id_pelanggan'));
        
        if ($pelanggan) {
            // Find active transaction for today
            $penjualan = Penjualan::where('id_pelanggan', $pelanggan->id_pelanggan)
                ->whereDate('waktu_transaksi', now()->toDateString())
                ->first();
                
            if ($penjualan) {
                // Update payment method to QRIS
                $penjualan->update([
                    'metode_pembayaran' => 'QRIS',
                ]);
            }
        }

        // Clear session so table is freed
        session()->forget(['nomor_meja', 'nama_pelanggan', 'id_pelanggan']);
        
        return redirect()->route('pelanggan.meja')->with('success', 'Pembayaran QRIS Berhasil! Terima kasih atas pesanan Anda.');
    }
}
