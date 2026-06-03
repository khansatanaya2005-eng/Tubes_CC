<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan; // Pastikan model Pelanggan di-import
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelanggans = Pelanggan::orderBy('nama_pelanggan', 'asc')->paginate(10); // Ambil semua pelanggan, urutkan, dan paginasi
        return view('admin.pelanggan.index', compact('pelanggans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pelanggan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'kontak_pelanggan' => 'nullable|string|max:100', // Bisa juga divalidasi format nomor telepon/email jika perlu
        ]);

        Pelanggan::create($request->all());

        return redirect()->route('admin.pelanggan.index')
                         ->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * Kita tidak menggunakan ini untuk sekarang.
     */
    // public function show(Pelanggan $pelanggan)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pelanggan $pelanggan) // Route Model Binding
    {
        return view('admin.pelanggan.edit', compact('pelanggan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pelanggan $pelanggan) // Route Model Binding
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'kontak_pelanggan' => 'nullable|string|max:100',
        ]);

        $pelanggan->update($request->all());

        return redirect()->route('admin.pelanggan.index')
                         ->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelanggan $pelanggan) // Route Model Binding
    {
        // Logika tambahan jika ada relasi yang perlu dicek sebelum hapus
        // Misalnya, cek apakah pelanggan masih punya transaksi aktif
        // Untuk sekarang, kita langsung hapus
        try {
            $pelanggan->delete();
            return redirect()->route('admin.pelanggan.index')
                             ->with('success', 'Pelanggan berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Tangani error jika ada foreign key constraint, dll.
            // Misalnya, jika pelanggan tidak bisa dihapus karena masih terkait dengan penjualan
            // dan di migration onDelete-nya adalah 'restrict'.
            return redirect()->route('admin.pelanggan.index')
                             ->with('error', 'Pelanggan tidak dapat dihapus karena masih memiliki data terkait.');
        }
    }
}