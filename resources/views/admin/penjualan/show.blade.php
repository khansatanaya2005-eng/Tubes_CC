{{-- resources/views/admin/penjualan/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        {{ __('Transaction Receipt #') }}{{ str_pad($penjualan->id_penjualan, 5, '0', STR_PAD_LEFT) }}
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('admin.riwayatpenjualan.index') }}" class="inline-flex items-center text-sm font-bold uppercase tracking-widest text-slate-500 hover:text-luxury-gold transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to History
            </a>
            <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-luxury-charcoal text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-black transition-colors shadow-md">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Print Receipt
            </button>
        </div>

            <div class="bg-white rounded-[24px] shadow-xl overflow-hidden print:shadow-none print:border print:border-slate-200">
            <!-- Receipt Header -->
            <div class="bg-luxury-charcoal p-12 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1.5 bg-luxury-gold"></div>
                <div class="absolute inset-0 opacity-5 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-white via-transparent to-transparent bg-[length:16px_16px]"></div>
                
                <h2 class="text-4xl font-serif font-bold text-white tracking-tight mb-2 relative z-10">TraciF.</h2>
                <p class="text-luxury-gold text-[10px] font-bold uppercase tracking-[0.3em] mb-8 relative z-10">Premium Hospitality</p>
                
                <div class="inline-block bg-white/10 backdrop-blur-md rounded-xl px-10 py-5 border border-white/10 relative z-10">
                    <p class="text-white/60 text-[10px] uppercase tracking-widest mb-1.5">Official Receipt</p>
                    <p class="text-3xl font-bold text-white tracking-widest">#{{ str_pad($penjualan->id_penjualan, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>

            <!-- Transaction Details -->
            <div class="px-12 py-10 border-b-2 border-dashed border-slate-200 bg-slate-50/50">
                <div class="grid grid-cols-2 gap-y-8 gap-x-12">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Date & Time</p>
                        <p class="text-sm font-bold text-luxury-charcoal">{{ $penjualan->waktu_transaksi->format('F d, Y - H:i') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Payment</p>
                        <p class="text-sm font-bold text-luxury-charcoal uppercase">{{ $penjualan->metode_pembayaran }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Guest / Table</p>
                        <p class="text-sm font-bold text-luxury-charcoal">{{ $penjualan->pelanggan->nama_pelanggan ?? 'Walk-in' }}</p>
                        @if($penjualan->pelanggan && $penjualan->pelanggan->kontak_pelanggan)
                            <p class="text-xs text-slate-500 mt-0.5">{{ $penjualan->pelanggan->kontak_pelanggan }}</p>
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Served By</p>
                        <p class="text-sm font-bold text-luxury-charcoal">{{ $penjualan->admin->nama_lengkap ?? 'System' }}</p>
                    </div>
                </div>

                @if($penjualan->catatan_penjualan)
                    <div class="mt-8 p-4 bg-white rounded-xl border border-slate-200">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Special Notes</p>
                        <p class="text-sm text-luxury-charcoal italic leading-relaxed">{{ $penjualan->catatan_penjualan }}</p>
                    </div>
                @endif
            </div>

            <!-- Order Items -->
            <div class="px-12 py-10">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6 border-b-2 border-slate-100 pb-3">Order Details</p>
                
                <div class="space-y-5 mb-10">
                    @foreach($penjualan->detailPenjualans as $detail)
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-bold text-luxury-charcoal mb-0.5">{{ $detail->produk->nama_produk ?? 'Deleted Item' }}</p>
                                <p class="text-xs font-medium text-slate-500">{{ $detail->jumlah_produk }} x Rp {{ number_format($detail->harga_satuan_saat_transaksi, 0, ',', '.') }}</p>
                            </div>
                            <p class="text-sm font-bold text-luxury-charcoal">Rp {{ number_format($detail->subtotal_produk, 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="border-t-2 border-dashed border-slate-200 pt-8">
                    <div class="flex justify-between items-end">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Amount</p>
                        <p class="text-4xl font-serif font-bold text-luxury-charcoal">Rp {{ number_format($penjualan->total_harga_penjualan, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-slate-50 px-12 py-8 text-center border-t border-slate-100">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Thank you for dining with us</p>
                <!-- Fake Barcode -->
                <div class="flex justify-center items-center space-x-1 opacity-20">
                    <div class="w-1 h-8 bg-luxury-charcoal"></div>
                    <div class="w-2 h-8 bg-luxury-charcoal"></div>
                    <div class="w-1 h-8 bg-luxury-charcoal"></div>
                    <div class="w-3 h-8 bg-luxury-charcoal"></div>
                    <div class="w-1 h-8 bg-luxury-charcoal"></div>
                    <div class="w-4 h-8 bg-luxury-charcoal"></div>
                    <div class="w-1 h-8 bg-luxury-charcoal"></div>
                    <div class="w-2 h-8 bg-luxury-charcoal"></div>
                    <div class="w-3 h-8 bg-luxury-charcoal"></div>
                    <div class="w-1 h-8 bg-luxury-charcoal"></div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>