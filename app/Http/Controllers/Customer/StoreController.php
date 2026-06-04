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
            'nomor_meja' => 'required|string|max:10'
        ]);

        // Register table as a generic guest customer if not exists
        Pelanggan::firstOrCreate(
            ['nama_pelanggan' => 'Table ' . $request->nomor_meja],
            ['kontak_pelanggan' => 'Meja ' . $request->nomor_meja]
        );

        session(['nomor_meja' => $request->nomor_meja]);
        return redirect()->route('pelanggan.katalog');
    }

    // 3. Clear Table Session
    public function clearMeja()
    {
        session()->forget('nomor_meja');
        return redirect()->route('pelanggan.meja');
    }

    // 4. Catalog (Culinary Menu)
    public function index()
    {
        if (!session()->has('nomor_meja')) {
            return redirect()->route('pelanggan.meja')->with('error', 'Please enter your table number first.');
        }

        $produks = Produk::orderBy('nama_produk', 'asc')->get();
        return view('customer.katalog', compact('produks'));
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

        $pelanggan = Pelanggan::where('nama_pelanggan', 'Table ' . session('nomor_meja'))->first();

        if (!$pelanggan) {
            return redirect()->route('pelanggan.meja')->with('error', 'Table configuration error.');
        }

        DB::beginTransaction();
        try {
            $totalHarga = $produk->harga_produk * $request->jumlah;

            $penjualan = Penjualan::create([
                'id_admin' => 1, // Default to main admin
                'id_pelanggan' => $pelanggan->id_pelanggan,
                'waktu_transaksi' => now(),
                'total_harga_penjualan' => $totalHarga,
                'metode_pembayaran' => 'CASH', // Default for dine-in until checkout
                'catatan_penjualan' => 'Dine-in Order from Table ' . session('nomor_meja'),
            ]);

            $penjualan->detailPenjualans()->create([
                'id_produk' => $produk->id_produk,
                'jumlah_produk' => $request->jumlah,
                'harga_satuan_saat_transaksi' => $produk->harga_produk,
                'subtotal_produk' => $totalHarga,
            ]);

            $adminUser = User::where('role', 'admin')->first();
            if ($adminUser) {
                $adminUser->notify(new PesananBaruNotification($penjualan));
            }

            DB::commit();

            return redirect()->route('pelanggan.katalog')->with('success', 'Culinary order placed for Table ' . session('nomor_meja') . '.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to place order.');
        }
    }

    // 6. View My Orders
    public function orders()
    {
        if (!session()->has('nomor_meja')) {
            return redirect()->route('pelanggan.meja');
        }

        $pelanggan = Pelanggan::where('nama_pelanggan', 'Table ' . session('nomor_meja'))->first();
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
}
