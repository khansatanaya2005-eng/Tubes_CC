<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <span>{{ __('Culinary Menu') }}</span>
            <span class="text-sm font-bold text-luxury-gold uppercase tracking-widest bg-luxury-gold/10 px-4 py-1.5 rounded-full border border-luxury-gold/20">
                Table {{ session('nomor_meja', 'GUEST') }}
            </span>
        </div>
    </x-slot>

    <!-- Hero Banner -->
    <div class="relative w-full h-[240px] md:h-[320px] rounded-3xl overflow-hidden mb-12 shadow-2xl">
        <div class="absolute inset-0 bg-luxury-charcoal">
            <!-- Subtle pattern overlay -->
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-white via-transparent to-transparent bg-[length:20px_20px]"></div>
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
        <div class="absolute inset-0 p-8 md:p-12 flex flex-col justify-end">
            <span class="text-luxury-gold text-xs font-bold uppercase tracking-[0.3em] mb-3">Welcome to TraciF</span>
            <h2 class="text-3xl md:text-5xl font-serif font-bold text-white tracking-[-0.02em] leading-tight mb-2">Exquisite Culinary<br>Experience</h2>
            <p class="text-white/70 text-sm md:text-base max-w-xl">Curated seasonal menus prepared with the finest ingredients by our master chefs.</p>
        </div>
        <div class="absolute top-8 right-8">
            <span class="inline-flex items-center space-x-2 bg-black/40 backdrop-blur-md border border-white/10 px-4 py-2 rounded-full text-white shadow-xl">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-xs font-bold uppercase tracking-widest">Table {{ session('nomor_meja', 'GUEST') }}</span>
            </span>
        </div>
    </div>

    <!-- Menu Grid -->
    <div class="flex items-center justify-between mb-8">
        <h3 class="text-2xl font-serif font-bold text-luxury-charcoal">Our Selection</h3>
        <div class="h-px flex-1 bg-slate-200 mx-6"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
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
                        <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></span>
                        Available
                    </div>

                    <form action="{{ route('pelanggan.cart.add', $produk->id_produk) }}" method="POST">
                        @csrf
                        <div class="flex items-center space-x-3">
                            <input type="number" name="jumlah" value="1" min="1" class="w-20 h-12 text-center border-slate-200 rounded-xl focus:ring-luxury-gold focus:border-luxury-gold bg-slate-50 text-luxury-charcoal font-bold outline-none transition-all">
                            <button type="submit" class="flex-1 h-12 bg-luxury-charcoal hover:bg-black text-luxury-ivory text-xs font-bold uppercase tracking-widest rounded-xl transition-all duration-300 shadow-md flex items-center justify-center space-x-2">
                                <span>Place Order</span>
                                <svg class="w-4 h-4 text-luxury-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
