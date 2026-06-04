<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Pelanggan;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Fetch recent sales (orders)
        $orders = Penjualan::with('pelanggan', 'detailPenjualans.produk')
            ->orderBy('waktu_transaksi', 'desc')
            ->take(20)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'order',
                    'title' => 'New Order Placed',
                    'description' => 'Table ' . ($item->pelanggan->nama_pelanggan ?? 'Unknown') . ' placed an order for Rp ' . number_format($item->total_harga_penjualan, 0, ',', '.'),
                    'time' => $item->waktu_transaksi,
                    'icon' => 'shopping-bag',
                    'color' => 'luxury-gold'
                ];
            });

        // Fetch recent customer registrations
        $customers = Pelanggan::orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'customer',
                    'title' => 'Guest Registry Updated',
                    'description' => 'Guest ' . $item->nama_pelanggan . ' was added to the registry.',
                    'time' => $item->created_at,
                    'icon' => 'user',
                    'color' => 'slate-400'
                ];
            });

        // Merge and sort
        $activities = $orders->merge($customers)->sortByDesc('time')->values();

        return view('admin.activity-logs', compact('activities'));
    }
}
