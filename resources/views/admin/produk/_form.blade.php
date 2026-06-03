{{-- resources/views/admin/produk/_form.blade.php --}}
@csrf
<div class="mb-4">
    <label for="nama_produk" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
    <input type="text" name="nama_produk" id="nama_produk" 
           value="{{ old('nama_produk', $produk->nama_produk ?? '') }}"
           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('nama_produk') border-red-500 @enderror"
           required>
    @error('nama_produk')
        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label for="harga_produk" class="block text-sm font-medium text-gray-700 mb-1">Harga Produk (Rp)</label>
    <input type="number" name="harga_produk" id="harga_produk" step="0.01" min="0"
           value="{{ old('harga_produk', $produk->harga_produk ?? '') }}"
           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('harga_produk') border-red-500 @enderror"
           required>
    @error('harga_produk')
        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label for="kategori_produk" class="block text-sm font-medium text-gray-700 mb-1">Kategori Produk (Opsional)</label>
    <input type="text" name="kategori_produk" id="kategori_produk"
           value="{{ old('kategori_produk', $produk->kategori_produk ?? '') }}"
           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('kategori_produk') border-red-500 @enderror">
    @error('kategori_produk')
        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label for="deskripsi_produk" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Produk (Opsional)</label>
    <textarea name="deskripsi_produk" id="deskripsi_produk" rows="3"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('deskripsi_produk') border-red-500 @enderror">{{ old('deskripsi_produk', $produk->deskripsi_produk ?? '') }}</textarea>
    @error('deskripsi_produk')
        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
    @enderror
</div>

<div class="mb-6">
    <label for="foto_produk" class="block text-sm font-medium text-gray-700 mb-1">Foto Produk (Opsional)</label>
    <input type="file" name="foto_produk" id="foto_produk"
           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('foto_produk') border-red-500 @enderror">
    @error('foto_produk')
        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
    @enderror
    @if (isset($produk) && $produk->foto_produk)
        <div class="mt-2">
            <img src="{{ Storage::url($produk->foto_produk) }}" alt="{{ $produk->nama_produk }}" class="h-20 w-20 object-cover rounded">
            <p class="text-xs text-gray-500 mt-1">Foto saat ini</p>
             {{-- Untuk menyimpan path foto lama jika tidak ada file baru yang diupload pada proses update --}}
            {{-- <input type="hidden" name="foto_produk_lama" value="{{ $produk->foto_produk }}"> --}}
             {{-- Logika di controller untuk $data['foto_produk'] = $produk->foto_produk; saat update sudah cukup --}}
        </div>
    @endif
</div>

<div>
    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:shadow-outline">
        {{ $tombol_submit ?? 'Simpan Produk' }}
    </button>
</div>