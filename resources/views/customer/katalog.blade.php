<x-app-layout>
    <x-slot name="header">
        {{ __('Browse Products') }}
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @foreach($produks as $produk)
            <div class="bg-luxury-pearl rounded-2xl shadow-sm border border-luxury-gold/30 overflow-hidden group hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                @if($produk->foto_produk)
                    <div class="h-48 overflow-hidden">
                        <img src="{{ Storage::url($produk->foto_produk) }}" alt="{{ $produk->nama_produk }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                @else
                    <div class="h-48 bg-luxury-ivory flex items-center justify-center border-b border-luxury-gold/20">
                        <svg class="w-16 h-16 text-luxury-gold opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                @endif
                
                <div class="p-6">
                    <h3 class="text-xl font-serif font-bold text-luxury-charcoal mb-2">{{ $produk->nama_produk }}</h3>
                    <p class="text-slate-500 text-sm mb-4 line-clamp-2">{{ $produk->deskripsi_produk ?? 'Premium selection.' }}</p>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xl font-bold text-luxury-gold">Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}</span>
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-widest">{{ $produk->stok_produk }} in stock</span>
                    </div>

                    <form action="{{ route('pelanggan.cart.add', $produk->id_produk) }}" method="POST">
                        @csrf
                        <div class="flex items-center space-x-2">
                            <input type="number" name="jumlah" value="1" min="1" max="{{ $produk->stok_produk }}" class="w-20 border-luxury-gold/50 rounded-lg text-sm focus:ring-luxury-gold focus:border-luxury-gold bg-transparent">
                            <button type="submit" class="flex-1 py-2 bg-luxury-charcoal text-luxury-ivory text-xs font-bold uppercase tracking-widest rounded-lg hover:bg-black transition-colors shadow-md text-center">
                                Order Now
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
