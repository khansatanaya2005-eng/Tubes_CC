{{-- resources/views/admin/pelanggan/_form.blade.php --}}
@csrf
<div class="mb-4">
    <label for="nama_pelanggan" class="block text-sm font-medium text-gray-700 mb-1">Nama Pelanggan</label>
    <input type="text" name="nama_pelanggan" id="nama_pelanggan" 
           value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan ?? '') }}"
           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('nama_pelanggan') border-red-500 @enderror"
           required>
    @error('nama_pelanggan')
        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
    @enderror
</div>

<div class="mb-6">
    <label for="kontak_pelanggan" class="block text-sm font-medium text-gray-700 mb-1">Kontak Pelanggan (Telepon/Email)</label>
    <input type="text" name="kontak_pelanggan" id="kontak_pelanggan"
           value="{{ old('kontak_pelanggan', $pelanggan->kontak_pelanggan ?? '') }}"
           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('kontak_pelanggan') border-red-500 @enderror">
    @error('kontak_pelanggan')
        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
    @enderror
</div>

<div>
    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:shadow-outline">
        {{ $tombol_submit ?? 'Simpan' }}
    </button>
</div>