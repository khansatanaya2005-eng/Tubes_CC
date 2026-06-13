<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <span>{{ __('Status Pesanan Meja') }}</span>
            <span class="text-sm font-bold text-luxury-gold uppercase tracking-widest bg-luxury-gold/10 px-4 py-1.5 rounded-full border border-luxury-gold/20">
                {{ session('nama_pelanggan', 'TAMU') }} - Meja {{ session('nomor_meja', '') }}
            </span>
        </div>
    </x-slot>

    <div class="bg-white rounded-[20px] shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-100">
            <h4 class="text-2xl font-sans font-bold text-luxury-charcoal">Pesanan Anda</h4>
            <p class="text-slate-500 text-sm mt-2">Lacak kreasi kuliner yang dipesan untuk meja Anda hari ini.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-8 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-widest">Produk</th>
                        <th class="px-8 py-5 text-center text-xs font-bold text-slate-400 uppercase tracking-widest">Harga Satuan</th>
                        <th class="px-8 py-5 text-center text-xs font-bold text-slate-400 uppercase tracking-widest">Jumlah</th>
                        <th class="px-8 py-5 text-right text-xs font-bold text-slate-400 uppercase tracking-widest">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-50">
                    @forelse ($myOrders as $transaksi)
                        @foreach($transaksi->detailPenjualans as $detail)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-8 py-5 whitespace-nowrap text-sm font-bold text-luxury-charcoal">
                                {{ $detail->produk->nama_produk ?? 'Hidangan Tidak Dikenal' }}
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap text-sm text-center text-slate-500 font-medium">
                                Rp {{ number_format($detail->harga_satuan_saat_transaksi, 0, ',', '.') }}
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap text-sm font-bold text-center text-luxury-gold">
                                {{ $detail->jumlah_produk }}x
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap text-sm font-bold text-luxury-charcoal text-right">
                                Rp {{ number_format($detail->subtotal_produk, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-16 text-center">
                                <svg class="w-12 h-12 mx-auto text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                <span class="text-sm font-medium text-slate-400">Belum ada pesanan yang dibuat untuk meja ini.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if(count($myOrders) > 0)
                <tfoot class="bg-slate-50 border-t border-slate-100">
                    <tr>
                        <td colspan="3" class="px-8 py-5 text-right text-xs font-bold text-slate-500 uppercase tracking-widest">Total Keseluruhan</td>
                        <td class="px-8 py-5 text-right text-lg font-bold text-luxury-gold">
                            Rp {{ number_format($myOrders->sum('total_harga_penjualan'), 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
        @if(count($myOrders) > 0)
        <div class="p-6 bg-slate-50 flex flex-col sm:flex-row justify-between items-center gap-4 sm:gap-0">
            <span class="text-sm text-slate-500 text-center sm:text-left">Silakan pilih metode pembayaran untuk menyelesaikan pesanan Anda.</span>
            <div class="flex items-center space-x-3">
                <form action="{{ route('pelanggan.meja.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-5 py-2.5 bg-slate-200 text-slate-600 text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-slate-300 transition-colors shadow-sm whitespace-nowrap">
                        Bayar di Kasir
                    </button>
                </form>
                <a href="{{ route('pelanggan.qris') }}" class="px-5 py-2.5 bg-luxury-charcoal text-luxury-ivory text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-black transition-colors shadow-md whitespace-nowrap inline-flex items-center">
                    Bayar Langsung
                </a>
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
