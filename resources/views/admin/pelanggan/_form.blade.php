{{-- resources/views/admin/pelanggan/_form.blade.php --}}
@csrf
<div class="mb-6">
    <label for="nama_pelanggan" class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-widest">Guest Name</label>
    <input type="text" name="nama_pelanggan" id="nama_pelanggan" 
           value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan ?? '') }}"
           class="w-full h-14 px-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition duration-200 outline-none text-luxury-charcoal"
           required>
    @error('nama_pelanggan')
        <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p>
    @enderror
</div>

<div class="mb-8">
    <label for="kontak_pelanggan" class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-widest">Contact Details (Phone/Email)</label>
    <input type="text" name="kontak_pelanggan" id="kontak_pelanggan"
           value="{{ old('kontak_pelanggan', $pelanggan->kontak_pelanggan ?? '') }}"
           class="w-full h-14 px-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition duration-200 outline-none text-luxury-charcoal">
    @error('kontak_pelanggan')
        <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p>
    @enderror
</div>

<div class="flex items-center gap-4 pt-4 border-t border-slate-100">
    <a href="{{ route('admin.pelanggan.index') }}" class="h-14 px-6 flex items-center justify-center bg-slate-100 text-slate-600 text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-slate-200 transition-colors">
        Cancel
    </a>
    <button type="submit" class="flex-1 h-14 bg-luxury-charcoal hover:bg-black text-luxury-ivory text-xs font-bold uppercase tracking-widest rounded-xl transition-colors shadow-md">
        {{ $tombol_submit ?? 'Save Guest' }}
    </button>
</div>
