<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk; // Pastikan model Produk di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Untuk mengelola file

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) // Tambahkan Request $request
    {
        // Ambil keyword pencarian dari query string
        $search = $request->query('search');

        // Mulai query builder
        $produksQuery = Produk::query();

        if ($search) {
            // Jika ada keyword pencarian, tambahkan kondisi where
            $produksQuery->where('nama_produk', 'like', '%' . $search . '%')
                        ->orWhere('kategori_produk', 'like', '%' . $search . '%');
        }

        // Lanjutkan dengan ordering dan paginasi
        $produks = $produksQuery->orderBy('nama_produk', 'asc')->paginate(10);

        // Penting: tambahkan query string pencarian ke link paginasi
        $produks->appends(['search' => $search]);

        // Kirim data ke view
        return view('admin.produk.index', compact('produks', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.produk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga_produk' => 'required|numeric|min:0',
            'foto_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk gambar
            'deskripsi_produk' => 'nullable|string',
            'kategori_produk' => 'nullable|string|max:100',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto_produk')) {
            // Simpan file gambar ke public/storage/produk_images
            // Pastikan sudah menjalankan `php artisan storage:link`
            $path = $request->file('foto_produk')->store('produk_images', 'public');
            $data['foto_produk'] = $path;
        }

        Produk::create($data);

        return redirect()->route('admin.produk.index')
                         ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        return view('admin.produk.edit', compact('produk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga_produk' => 'required|numeric|min:0',
            'foto_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'deskripsi_produk' => 'nullable|string',
            'kategori_produk' => 'nullable|string|max:100',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto_produk')) {
            // Hapus foto lama jika ada
            if ($produk->foto_produk && Storage::disk('public')->exists($produk->foto_produk)) {
                Storage::disk('public')->delete($produk->foto_produk);
            }
            // Simpan foto baru
            $path = $request->file('foto_produk')->store('produk_images', 'public');
            $data['foto_produk'] = $path;
        } else {
            // Jika tidak ada file baru diupload, jangan ubah path foto_produk yang sudah ada
            // $data['foto_produk'] akan berisi path lama dari $request->all() jika fieldnya hidden
            // atau tidak ada jika fieldnya tidak disertakan saat tidak ada file.
            // Untuk memastikan foto lama tidak terhapus jika tidak ada upload baru:
            $data['foto_produk'] = $produk->foto_produk;
        }
        
        // Jika user menghapus foto tanpa mengganti (misal ada tombol "Hapus Foto")
        // Handle case ini jika diperlukan, misalnya:
        // if ($request->boolean('hapus_foto_lama') && !$request->hasFile('foto_produk')) {
        //     if ($produk->foto_produk && Storage::disk('public')->exists($produk->foto_produk)) {
        //         Storage::disk('public')->delete($produk->foto_produk);
        //     }
        //     $data['foto_produk'] = null;
        // }


        $produk->update($data);

        return redirect()->route('admin.produk.index')
                         ->with('success', 'Data produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        // Hapus foto produk jika ada sebelum menghapus record dari database
        if ($produk->foto_produk && Storage::disk('public')->exists($produk->foto_produk)) {
            Storage::disk('public')->delete($produk->foto_produk);
        }

        try {
            $produk->delete();
            return redirect()->route('admin.produk.index')
                             ->with('success', 'Produk berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Tangani jika produk tidak bisa dihapus karena relasi (misal onDelete='restrict' di detail_penjualans)
             if (str_contains($e->getMessage(), 'constraint violation')) {
                 return redirect()->route('admin.produk.index')
                                 ->with('error', 'Produk tidak dapat dihapus karena masih tercatat dalam transaksi penjualan.');
            }
            return redirect()->route('admin.produk.index')
                             ->with('error', 'Terjadi kesalahan saat menghapus produk.');
        }
    }
}