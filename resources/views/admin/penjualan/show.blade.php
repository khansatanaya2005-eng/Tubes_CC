{{-- resources/views/admin/penjualan/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Transaksi #') }}{{ $penjualan->id_penjualan }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <a href="{{ route('admin.riwayatpenjualan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 text-sm font-medium rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali ke Riwayat
                        </a>
                    </div>

                    <h3 class="text-lg font-semibold text-gray-800">Informasi Transaksi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 mb-6">
                        <div>
                            <p class="text-sm text-gray-600">ID Transaksi: <span class="font-medium text-gray-800">#{{ $penjualan->id_penjualan }}</span></p>
                            <p class="text-sm text-gray-600">Waktu Transaksi: <span class="font-medium text-gray-800">{{ $penjualan->waktu_transaksi->format('d M Y, H:i:s') }}</span></p>
                            <p class="text-sm text-gray-600">Metode Pembayaran: <span class="font-medium text-gray-800">{{ $penjualan->metode_pembayaran }}</span></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Pelanggan: <span class="font-medium text-gray-800">{{ $penjualan->pelanggan->nama_pelanggan ?? 'Umum/Walk-in' }}</span></p>
                            @if($penjualan->pelanggan && $penjualan->pelanggan->kontak_pelanggan)
                            <p class="text-sm text-gray-600">Kontak Pelanggan: <span class="font-medium text-gray-800">{{ $penjualan->pelanggan->kontak_pelanggan }}</span></p>
                            @endif
                            <p class="text-sm text-gray-600">Admin Kasir: <span class="font-medium text-gray-800">{{ $penjualan->admin->name ?? 'N/A' }}</span></p>
                            {{-- Ganti $penjualan->admin->name dengan username atau nama_lengkap jika perlu --}}
                        </div>
                    </div>
                    @if($penjualan->catatan_penjualan)
                    <div class="mb-6">
                         <p class="text-sm text-gray-600">Catatan: <span class="font-medium text-gray-800">{{ $penjualan->catatan_penjualan }}</span></p>
                    </div>
                    @endif

                    <h3 class="text-lg font-semibold text-gray-800 mt-6 mb-2">Detail Item Dibeli</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Harga Satuan (Rp)</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Subtotal (Rp)</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($penjualan->detailPenjualans as $detail)
                                <tr>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">{{ $detail->produk->nama_produk ?? 'Produk Dihapus' }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 text-right">{{ $detail->jumlah_produk }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 text-right">{{ number_format($detail->harga_satuan_saat_transaksi, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 text-right">{{ number_format($detail->subtotal_produk, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="px-4 py-2 text-right text-sm font-semibold text-gray-700 uppercase">Total Keseluruhan</td>
                                    <td class="px-4 py-2 text-right text-sm font-semibold text-gray-900 uppercase">
                                        Rp {{ number_format($penjualan->total_harga_penjualan, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>