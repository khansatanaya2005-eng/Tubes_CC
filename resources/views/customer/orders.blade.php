<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <span>{{ __('Table Order Status') }}</span>
            <span class="text-sm font-bold text-luxury-gold uppercase tracking-widest bg-luxury-gold/10 px-4 py-1.5 rounded-full border border-luxury-gold/20">
                Table {{ session('nomor_meja', 'GUEST') }}
            </span>
        </div>
    </x-slot>

    <div class="bg-white rounded-[20px] shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-100">
            <h4 class="text-2xl font-serif font-bold text-luxury-charcoal">Your Recent Orders</h4>
            <p class="text-slate-500 text-sm mt-2">Track the culinary creations ordered for your table today.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-8 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-widest">Order ID</th>
                        <th class="px-8 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-widest">Time</th>
                        <th class="px-8 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-widest">Items</th>
                        <th class="px-8 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-widest">Payment</th>
                        <th class="px-8 py-5 text-right text-xs font-bold text-slate-400 uppercase tracking-widest">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-50">
                    @forelse ($myOrders as $transaksi)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-8 py-5 whitespace-nowrap text-sm font-bold text-luxury-gold">
                                #{{ str_pad($transaksi->id_penjualan, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap text-sm font-medium text-slate-600">{{ $transaksi->waktu_transaksi->format('H:i') }}</td>
                            <td class="px-8 py-5 text-sm text-slate-800">
                                <ul class="space-y-1">
                                    @foreach($transaksi->detailPenjualans as $detail)
                                        <li class="font-serif"><span class="font-bold text-luxury-charcoal">{{ $detail->jumlah_produk }}x</span> {{ $detail->produk->nama_produk ?? 'Unknown Dish' }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap text-sm text-slate-500 font-medium tracking-wide">{{ $transaksi->metode_pembayaran }}</td>
                            <td class="px-8 py-5 whitespace-nowrap text-sm font-bold text-luxury-charcoal text-right">Rp {{ number_format($transaksi->total_harga_penjualan, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-8 py-12 text-center text-sm font-medium text-slate-400">No orders have been placed for this table yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(count($myOrders) > 0)
        <div class="p-6 bg-slate-50 flex justify-between items-center">
            <span class="text-sm text-slate-500">Please prepare payment when ready to checkout.</span>
            <form action="{{ route('pelanggan.meja.clear') }}" method="POST">
                @csrf
                <button type="submit" class="px-6 py-2.5 bg-luxury-charcoal text-luxury-ivory text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-black transition-colors shadow-md">
                    Finish & Leave Table
                </button>
            </form>
        </div>
        @endif
    </div>
</x-app-layout>
