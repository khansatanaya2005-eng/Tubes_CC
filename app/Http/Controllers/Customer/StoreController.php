<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\PesananBaruNotification;
use App\Models\User;

class StoreController extends Controller
{
    public function index()
    {
        $produks = Produk::orderBy('nama_produk', 'asc')->get();
        return view('customer.katalog', compact('produks'));
    }

    public function addToCart(Request $request, Produk $produk)
    {
        // Simple direct order logic for Pelanggan (to avoid complex cart sessions for now)
        // Usually, SaaS apps use a cart session. We'll simplify to "Order Now".
        // Wait, the route says cart/add, let's implement a simple direct checkout or session cart.
        
        $request->validate([
            'jumlah' => 'required|integer|min:1'
        ]);

        $pelanggan = Pelanggan::firstOrCreate(
            ['nama_pelanggan' => Auth::user()->name],
            ['kontak_pelanggan' => Auth::user()->email]
        );

        DB::beginTransaction();
        try {
            $totalHarga = $produk->harga_produk * $request->jumlah;

            $penjualan = Penjualan::create([
                'id_admin' => 1, // Default to main admin to process it
                'id_pelanggan' => $pelanggan->id_pelanggan,
                'waktu_transaksi' => now(),
                'total_harga_penjualan' => $totalHarga,
                'metode_pembayaran' => 'TRANSFER',
                'catatan_penjualan' => 'Ordered via Customer Portal',
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

            return redirect()->route('dashboard')->with('success', 'Your order has been placed successfully. Awaiting processing.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to place order.');
        }
    }

    public function orders()
    {
        $pelanggan = Pelanggan::where('nama_pelanggan', Auth::user()->name)->first();
        $myOrders = collect();

        if ($pelanggan) {
            $myOrders = Penjualan::with('detailPenjualans.produk')
                                ->where('id_pelanggan', $pelanggan->id_pelanggan)
                                ->orderBy('waktu_transaksi', 'desc')
                                ->get();
        }

        return view('customer.orders', compact('myOrders'));
    }
}
