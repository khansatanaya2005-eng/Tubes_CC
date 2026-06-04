{{-- resources/views/admin/pesanan/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        {{ __('Dine-in Orders') }}
    </x-slot>

    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- CULINARY MENU -->
        <div class="lg:w-2/3">
            <div class="mb-6">
                <h3 class="text-xl font-serif font-bold text-luxury-charcoal">Culinary Menu</h3>
                <p class="text-sm text-slate-500">Select items to add to the table's order.</p>
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

            <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse ($produks as $produk)
                    <div class="group relative bg-white border border-slate-100 rounded-2xl p-6 transition-all duration-300 hover:border-luxury-gold hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] flex flex-col justify-between h-full">
                        <div>
                            <p class="text-[10px] font-bold text-luxury-gold uppercase tracking-widest mb-2">{{ $produk->kategori_produk ?? 'Chef Special' }}</p>
                            <h4 class="text-lg font-serif font-bold text-luxury-charcoal leading-tight mb-2">{{ $produk->nama_produk }}</h4>
                        </div>
                        
                        <div class="mt-6 flex items-center justify-between">
                            <span class="text-sm font-bold text-slate-500">Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}</span>
                            <form action="{{ route('admin.pesanan.addToCart', $produk->id_produk) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 border border-slate-200 text-luxury-charcoal hover:bg-luxury-gold hover:border-luxury-gold hover:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center bg-white rounded-[20px] border border-slate-100">
                        <p class="text-slate-500 font-medium">No culinary items available.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- ACTIVE ORDER CART -->
        <div class="lg:w-1/3">
            <div class="sticky top-6 bg-white rounded-[24px] shadow-[0_8px_40px_-12px_rgba(0,0,0,0.1)] p-8 border border-slate-100 flex flex-col max-h-[calc(100vh-3rem)]">
                
                <!-- Receipt Header -->
                <div class="mb-6 flex flex-col items-center justify-center shrink-0 border-b-2 border-dashed border-slate-200 pb-6">
                    <h3 class="text-3xl font-serif font-bold text-luxury-charcoal leading-tight">TraciF.</h3>
                    <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] mt-1">Dine-in Ticket</p>
                    
                    @if (!empty($cart))
                        <form action="{{ route('admin.pesanan.clearCart') }}" method="POST" class="absolute top-8 right-8">
                            @csrf
                            <button type="submit" class="text-slate-300 hover:text-red-500 transition-colors" title="Void Ticket">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Receipt Items -->
                <div class="flex-1 overflow-y-auto scrollbar-hide -mx-2 px-2 space-y-4">
                    @forelse ($cart ?? [] as $id => $item)
                        <div class="flex items-start justify-between group">
                            <div class="flex-1 pr-4">
                                <h4 class="text-sm font-bold text-luxury-charcoal mb-0.5">{{ $item['nama'] }}</h4>
                                <span class="text-slate-500 text-xs font-medium">Rp {{ number_format($item['harga'], 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center space-x-2 bg-slate-50 rounded-full px-2 py-1 border border-slate-100">
                                <form action="{{ route('admin.pesanan.updateCart') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_produk" value="{{ $id }}">
                                    <input type="hidden" name="jumlah" value="{{ $item['jumlah'] - 1 }}">
                                    <button type="submit" class="w-6 h-6 flex items-center justify-center rounded-full hover:bg-slate-200 text-slate-400 hover:text-luxury-charcoal transition-colors" {{ $item['jumlah'] <= 1 ? 'disabled' : '' }}>
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                    </button>
                                </form>
                                <span class="text-xs font-bold w-4 text-center text-luxury-charcoal">{{ $item['jumlah'] }}</span>
                                <form action="{{ route('admin.pesanan.updateCart') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_produk" value="{{ $id }}">
                                    <input type="hidden" name="jumlah" value="{{ $item['jumlah'] + 1 }}">
                                    <button type="submit" class="w-6 h-6 flex items-center justify-center rounded-full hover:bg-slate-200 text-slate-400 hover:text-luxury-charcoal transition-colors">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="h-full flex flex-col items-center justify-center text-center text-slate-400">
                            <svg class="w-12 h-12 mb-4 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <p class="text-xs font-bold uppercase tracking-widest">Ticket is empty</p>
                        </div>
                    @endforelse
                </div>

                <!-- Receipt Footer / Checkout -->
                @if (!empty($cart))
                    <div class="mt-6 pt-6 border-t-2 border-dashed border-slate-200 shrink-0">
                        <div class="flex justify-between items-end mb-6">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Amount</span>
                            <span class="text-2xl font-serif font-bold text-luxury-charcoal">Rp {{ number_format($totalHargaKeranjang ?? 0, 0, ',', '.') }}</span>
                        </div>

                        <form action="{{ route('admin.pesanan.storeOrder') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <input type="text" name="nama_pelanggan" placeholder="Guest Name / Table No." class="w-full h-12 px-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition duration-200 outline-none text-luxury-charcoal placeholder-slate-400 text-sm font-medium">
                            </div>
                            <div>
                                <textarea name="catatan_penjualan" rows="2" placeholder="Special requests or allergies..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition duration-200 outline-none text-luxury-charcoal placeholder-slate-400 text-sm font-medium resize-none"></textarea>
                            </div>
                            <button type="submit" class="w-full h-14 bg-luxury-charcoal text-white font-bold uppercase tracking-widest text-xs rounded-xl hover:bg-black transition-colors shadow-lg mt-2">
                                Complete Order
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

    </div>
</x-app-layout>