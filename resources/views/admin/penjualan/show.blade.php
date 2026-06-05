<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaction Receipt #') }}{{ str_pad($penjualan->id_penjualan, 5, '0', STR_PAD_LEFT) }}
        </h2>
    </x-slot>

    <div class="py-12 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 lg:px-8">
            <!-- Header Actions -->
            <div class="mb-6 flex items-center justify-between">
                <a href="{{ route('admin.riwayatpenjualan.index') }}" class="inline-flex items-center text-xs font-semibold text-slate-500 hover:text-luxury-charcoal transition-colors">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back
                </a>
                <button onclick="window.print()" class="inline-flex items-center justify-center px-5 py-2.5 bg-luxury-charcoal text-white text-xs font-bold rounded-xl hover:bg-black transition-all shadow-md active:scale-95 print:hidden">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Print Receipt
                </button>
            </div>

            <!-- Receipt Card -->
            <div class="bg-white rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] overflow-hidden border border-gray-100 print:shadow-none print:border print:border-gray-300 relative">
                

                
                <!-- Receipt Header -->
                <div class="bg-luxury-charcoal p-8 lg:p-10 relative overflow-hidden flex items-center justify-between">
                    <!-- Left Side: Brand -->
                    <div class="relative z-10">
                        <h2 class="text-5xl font-playfair font-bold text-white tracking-tight leading-none mb-2">TraciF.</h2>
                        <p class="text-luxury-gold text-xs font-bold uppercase tracking-widest">Premium Fine Dining</p>
                    </div>
                    
                    <!-- Right Side: Receipt Number -->
                    <div class="text-right relative z-10">
                        <span class="block text-luxury-gold text-xs uppercase font-bold tracking-widest mb-1">Official Receipt</span>
                        <span class="block text-2xl font-bold text-white tracking-wider leading-none">#{{ str_pad($penjualan->id_penjualan, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>

                <!-- Main Receipt Content -->
                <div class="px-8 lg:px-12 py-10">
                    <!-- Transaction Details -->
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="font-semibold text-gray-500 uppercase">Date</span>
                            <span class="font-bold text-gray-800">{{ $penjualan->waktu_transaksi->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="font-semibold text-gray-500 uppercase">Payment</span>
                            <span class="font-bold text-green-700 bg-green-50 px-3 py-1 rounded uppercase">{{ $penjualan->metode_pembayaran }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="font-semibold text-gray-500 uppercase">Guest</span>
                            <span class="font-bold text-gray-800">{{ $penjualan->pelanggan->nama_pelanggan ?? 'Walk-in' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="font-semibold text-gray-500 uppercase">Served By</span>
                            <span class="font-bold text-gray-800">{{ $penjualan->admin->nama_lengkap ?? 'System' }}</span>
                        </div>
                    </div>

                    @if($penjualan->catatan_penjualan)
                        <div class="mt-4 p-3 bg-amber-50 rounded-lg border border-amber-100">
                            <p class="text-xs font-semibold text-amber-600 uppercase tracking-wider mb-1 flex items-center">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Catatan Khusus
                            </p>
                            <p class="text-sm text-gray-700 italic">{{ $penjualan->catatan_penjualan }}</p>
                        </div>
                    @endif

                    <!-- Top Dashed Separator -->
                    <div class="py-10">
                        <div class="border-t-2 border-dashed border-gray-300"></div>
                    </div>

                    <!-- Order Items -->
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-6 text-center">Order Details</p>
                    
                    <div class="space-y-5 mb-8">
                        @foreach($penjualan->detailPenjualans as $detail)
                            <div class="flex justify-between items-start text-base">
                                <div class="flex-1 pr-4">
                                    <p class="font-bold text-gray-800 leading-tight mb-1">{{ $detail->produk->nama_produk ?? 'Deleted Item' }}</p>
                                    <p class="text-sm text-gray-500">{{ $detail->jumlah_produk }} x {{ number_format($detail->harga_satuan_saat_transaksi, 0, ',', '.') }}</p>
                                </div>
                                <p class="font-bold text-gray-800 text-lg">{{ number_format($detail->subtotal_produk, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="py-8">
                        <div class="border-t-2 border-dashed border-gray-300 pt-8">
                            <div class="flex justify-between items-end">
                                <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total</p>
                                <p class="text-4xl font-bold text-gray-900">Rp {{ number_format($penjualan->total_harga_penjualan, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer & Barcode -->
                <div class="bg-gray-50 px-8 lg:px-12 py-10 text-center border-t border-gray-100 relative">


                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Thank You For Dining With Us</p>
                    
                    <!-- Fake Barcode -->
                    <div class="flex justify-center items-center h-16 w-full max-w-md mx-auto opacity-30 mt-6">
                        <div class="w-1 h-full bg-gray-800 mr-1"></div>
                        <div class="w-2 h-full bg-gray-800 mr-0.5"></div>
                        <div class="w-1 h-full bg-gray-800 mr-1.5"></div>
                        <div class="w-3 h-full bg-gray-800 mr-1"></div>
                        <div class="w-1 h-full bg-gray-800 mr-0.5"></div>
                        <div class="w-4 h-full bg-gray-800 mr-1"></div>
                        <div class="w-0.5 h-full bg-gray-800 mr-1"></div>
                        <div class="w-2 h-full bg-gray-800 mr-1.5"></div>
                        <div class="w-1 h-full bg-gray-800 mr-0.5"></div>
                        <div class="w-2 h-full bg-gray-800 mr-1"></div>
                        <div class="w-3 h-full bg-gray-800 mr-1"></div>
                        <div class="w-1 h-full bg-gray-800"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>