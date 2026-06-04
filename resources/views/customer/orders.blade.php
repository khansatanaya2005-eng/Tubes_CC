<x-app-layout>
    <x-slot name="header">
        {{ __('My Orders') }}
    </x-slot>

    <div class="bg-luxury-pearl rounded-2xl shadow-sm border border-luxury-gold/30 overflow-hidden">
        <div class="p-6 border-b border-luxury-gold/20">
            <h4 class="text-xl font-serif font-bold text-luxury-charcoal">Order History</h4>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-luxury-gold/20">
                <thead class="bg-luxury-ivory/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">Order ID</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">Time</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">Items</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">Payment</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-widest">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-luxury-pearl divide-y divide-luxury-gold/10">
                    @forelse ($myOrders as $transaksi)
                        <tr class="hover:bg-luxury-ivory/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-luxury-gold">
                                #{{ str_pad($transaksi->id_penjualan, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $transaksi->waktu_transaksi->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4 text-sm text-slate-800">
                                <ul class="list-disc pl-5">
                                    @foreach($transaksi->detailPenjualans as $detail)
                                        <li>{{ $detail->produk->nama_produk ?? 'Unknown' }} (x{{ $detail->jumlah_produk }})</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-medium">{{ $transaksi->metode_pembayaran }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-luxury-charcoal text-right">Rp {{ number_format($transaksi->total_harga_penjualan, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-8 text-center text-sm text-slate-500 italic">You have no previous orders.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
