<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <span>{{ __('Culinary Menu') }}</span>
            <span class="text-sm font-bold text-luxury-gold uppercase tracking-widest bg-luxury-gold/10 px-4 py-1.5 rounded-full border border-luxury-gold/20">
                Table {{ session('nomor_meja', 'GUEST') }}
            </span>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($produks as $produk)
            <div class="bg-white rounded-[20px] shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] border border-slate-100 p-8 flex flex-col justify-between group hover:shadow-[0_8px_30px_-10px_rgba(184,148,91,0.15)] hover:border-luxury-gold/30 transition-all duration-300 relative overflow-hidden">
                <!-- Decorative Corner -->
                <div class="absolute top-0 right-0 w-16 h-16 bg-gradient-to-bl from-luxury-gold/10 to-transparent rounded-bl-[40px] opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                <div class="mb-8">
                    <div class="flex items-start justify-between mb-3">
                        <h3 class="text-2xl font-serif font-bold text-luxury-charcoal group-hover:text-luxury-gold transition-colors duration-300">{{ $produk->nama_produk }}</h3>
                        <span class="text-lg font-bold text-luxury-gold shrink-0 ml-4">Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}</span>
                    </div>
                    <div class="w-12 h-0.5 bg-luxury-gold/30 mb-4 group-hover:w-20 transition-all duration-500"></div>
                    <p class="text-slate-500 text-sm leading-relaxed">{{ $produk->deskripsi_produk ?? 'An exquisite culinary creation crafted with the finest seasonal ingredients, offering a symphony of delicate flavors.' }}</p>
                </div>

                <div>
                    <div class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-4 flex items-center">
                        <span class="w-2 h-2 rounded-full {{ $produk->stok_produk > 0 ? 'bg-emerald-500' : 'bg-red-500' }} mr-2"></span>
                        {{ $produk->stok_produk > 0 ? 'Available (' . $produk->stok_produk . ' portions)' : 'Sold Out' }}
                    </div>

                    @if($produk->stok_produk > 0)
                        <form action="{{ route('pelanggan.cart.add', $produk->id_produk) }}" method="POST">
                            @csrf
                            <div class="flex items-center space-x-3">
                                <input type="number" name="jumlah" value="1" min="1" max="{{ $produk->stok_produk }}" class="w-20 h-12 text-center border-slate-200 rounded-xl focus:ring-luxury-gold focus:border-luxury-gold bg-slate-50 text-luxury-charcoal font-bold outline-none transition-all">
                                <button type="submit" class="flex-1 h-12 bg-luxury-charcoal hover:bg-black text-luxury-ivory text-xs font-bold uppercase tracking-widest rounded-xl transition-all duration-300 shadow-md flex items-center justify-center space-x-2">
                                    <span>Place Order</span>
                                    <svg class="w-4 h-4 text-luxury-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </button>
                            </div>
                        </form>
                    @else
                        <button disabled class="w-full h-12 bg-slate-100 text-slate-400 text-xs font-bold uppercase tracking-widest rounded-xl cursor-not-allowed">
                            Currently Unavailable
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
