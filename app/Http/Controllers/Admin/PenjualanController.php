<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penjualan; // Pastikan model Penjualan di-import
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load relasi untuk efisiensi query (N+1 problem)
        $penjualans = Penjualan::with(['pelanggan', 'admin'])
                                ->orderBy('waktu_transaksi', 'desc') // Tampilkan yang terbaru dulu
                                ->paginate(10); 
        
        return view('admin.penjualan.index', compact('penjualans'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Penjualan $penjualan) // Route Model Binding
    {
        // Eager load relasi detailPenjualans beserta produk di setiap detail
        $penjualan->load(['detailPenjualans.produk', 'pelanggan', 'admin']);

        return view('admin.penjualan.show', compact('penjualan'));
    }

    // Method create, store, edit, update, destroy bisa dikomentari atau dihapus 
    // jika PenjualanController ini khusus untuk riwayat dan tidak untuk CRUD langsung.
    // Pembuatan Penjualan akan melalui fitur "Pesanan!" (POS).
    
    // public function create() { /* ... */ }
    // public function store(Request $request) { /* ... */ }
    // public function edit(Penjualan $penjualan) { /* ... */ }
    // public function update(Request $request, Penjualan $penjualan) { /* ... */ }
    // public function destroy(Penjualan $penjualan) { /* ... */ }
}