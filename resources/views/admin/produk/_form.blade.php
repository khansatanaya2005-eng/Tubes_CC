{{-- resources/views/admin/produk/_form.blade.php --}}
@csrf
<div class="mb-6">
    <label for="nama_produk" class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-widest">Item Name</label>
    <input type="text" name="nama_produk" id="nama_produk" 
           value="{{ old('nama_produk', $produk->nama_produk ?? '') }}"
           class="w-full h-14 px-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition duration-200 outline-none text-luxury-charcoal"
           required>
    @error('nama_produk')
        <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p>
    @enderror
</div>

<div class="mb-6 flex gap-6">
    <div class="w-1/2">
        <label for="harga_produk" class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-widest">Price (Rp)</label>
        <input type="number" name="harga_produk" id="harga_produk" step="0.01" min="0"
               value="{{ old('harga_produk', $produk->harga_produk ?? '') }}"
               class="w-full h-14 px-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition duration-200 outline-none text-luxury-charcoal"
               required>
        @error('harga_produk')
            <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p>
        @enderror
    </div>
    
    <div class="w-1/2">
        <label for="kategori_produk" class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-widest">Category</label>
        <select name="kategori_produk" id="kategori_produk"
               class="w-full h-14 px-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition duration-200 outline-none text-luxury-charcoal appearance-none cursor-pointer">
            <option value="" disabled {{ old('kategori_produk', $produk->kategori_produk ?? '') == '' ? 'selected' : '' }}>Select Category</option>
            <optgroup label="Makanan">
                <option value="Main Course" {{ old('kategori_produk', $produk->kategori_produk ?? '') == 'Main Course' ? 'selected' : '' }}>Main Course</option>
                <option value="Dessert" {{ old('kategori_produk', $produk->kategori_produk ?? '') == 'Dessert' ? 'selected' : '' }}>Dessert</option>
                <option value="Snack" {{ old('kategori_produk', $produk->kategori_produk ?? '') == 'Snack' ? 'selected' : '' }}>Snack</option>
                <option value="Appetizer" {{ old('kategori_produk', $produk->kategori_produk ?? '') == 'Appetizer' ? 'selected' : '' }}>Appetizer</option>
            </optgroup>
            <optgroup label="Minuman">
                <option value="Coffee" {{ old('kategori_produk', $produk->kategori_produk ?? '') == 'Coffee' ? 'selected' : '' }}>Coffee</option>
                <option value="Non Coffee" {{ old('kategori_produk', $produk->kategori_produk ?? '') == 'Non Coffee' ? 'selected' : '' }}>Non Coffee</option>
                <option value="Tea" {{ old('kategori_produk', $produk->kategori_produk ?? '') == 'Tea' ? 'selected' : '' }}>Tea</option>
                <option value="Signature" {{ old('kategori_produk', $produk->kategori_produk ?? '') == 'Signature' ? 'selected' : '' }}>Signature</option>
                <option value="Mocktails" {{ old('kategori_produk', $produk->kategori_produk ?? '') == 'Mocktails' ? 'selected' : '' }}>Mocktails</option>
            </optgroup>
        </select>
        @error('kategori_produk')
            <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mb-6">
    <label for="deskripsi_produk" class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-widest">Description</label>
    <textarea name="deskripsi_produk" id="deskripsi_produk" rows="3"
              class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition duration-200 outline-none text-luxury-charcoal resize-none">{{ old('deskripsi_produk', $produk->deskripsi_produk ?? '') }}</textarea>
    @error('deskripsi_produk')
        <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p>
    @enderror
</div>

<div class="mb-8">
    <label for="foto_produk" class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-widest">Item Photo</label>
    <input type="file" name="foto_produk" id="foto_produk"
           class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:uppercase file:tracking-widest file:bg-slate-100 file:text-luxury-charcoal hover:file:bg-slate-200">
    @error('foto_produk')
        <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p>
    @enderror
    @if (isset($produk) && $produk->foto_produk)
        <div class="mt-4 flex items-center gap-4">
            <img src="{{ Storage::url($produk->foto_produk) }}" alt="{{ $produk->nama_produk }}" class="h-16 w-16 object-cover rounded-lg border border-slate-200">
            <span class="text-xs font-medium text-slate-400">Current Photo</span>
        </div>
    @endif
</div>

<div class="flex items-center gap-4 pt-4 border-t border-slate-100">
    <a href="{{ route('admin.produk.index') }}" class="h-14 px-6 flex items-center justify-center bg-slate-100 text-slate-600 text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-slate-200 transition-colors">
        Cancel
    </a>
    <button type="submit" class="flex-1 h-14 bg-luxury-charcoal hover:bg-black text-luxury-ivory text-xs font-bold uppercase tracking-widest rounded-xl transition-colors shadow-md">
        {{ $tombol_submit ?? 'Save Item' }}
    </button>
</div>
