{{-- resources/views/admin/produk/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        {{ __('Menu Kuliner') }}
    </x-slot>

    <div class="bg-white rounded-[20px] shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] border border-slate-100 p-8">
        
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-8 border-b border-slate-100 pb-6">
            <div>
                <h3 class="text-2xl font-sans font-bold text-luxury-charcoal">Basis Data Menu</h3>
                <p class="text-sm text-slate-500 mt-1">Kelola penawaran kuliner, harga, dan kategori.</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                <form action="{{ route('admin.produk.index') }}" method="GET" class="relative w-full sm:w-64">
                    <input type="text" name="search" placeholder="Cari menu..." 
                           class="w-full h-12 pl-10 pr-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition duration-200 outline-none text-luxury-charcoal text-sm"
                           value="{{ $search ?? '' }}">
                    <div class="absolute left-4 top-3.5 text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </form>
                <a href="{{ route('admin.produk.create') }}" class="h-12 px-6 bg-luxury-charcoal hover:bg-black text-luxury-ivory text-xs font-bold uppercase tracking-widest rounded-xl transition-colors shadow-md flex items-center justify-center whitespace-nowrap">
                    + Tambah Menu
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 text-red-700 border border-red-200 rounded-xl flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <div class="overflow-x-auto rounded-xl border border-slate-100">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">Nama Item</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">Kategori</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">Harga</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($produks as $index => $produk)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <span class="font-sans font-bold text-luxury-charcoal text-base">{{ $produk->nama_produk }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                    {{ $produk->kategori_produk ?? 'Tanpa Kategori' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-slate-600">Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.produk.edit', $produk->id_produk) }}" class="text-slate-400 hover:text-luxury-gold transition-colors" title="Ubah">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.produk.destroy', $produk->id_produk) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus menu ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-slate-400 hover:text-red-500 transition-colors" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center">
                                <svg class="w-12 h-12 mx-auto text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                <p class="text-sm font-medium text-slate-400">
                                    @if ($search)
                                        Tidak ada menu yang cocok dengan "{{ $search }}".
                                    @else
                                        Tidak ada item kuliner tersedia.
                                    @endif
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $produks->links() }}
        </div>
    </div>
</x-app-layout>
