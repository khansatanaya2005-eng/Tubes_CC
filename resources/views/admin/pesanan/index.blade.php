{{-- resources/views/admin/pesanan/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Pesanan Baru (Kasir)') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded-md">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 border border-red-300 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-8">

                <div class="lg:w-2/3">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-medium text-gray-700 mb-4">Pilih Produk</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @forelse ($produks as $produk)
                                    <div class="border rounded-lg p-3 flex flex-col items-center text-center">
                                        <img src="{{ $produk->foto_produk ? Storage::url($produk->foto_produk) : 'https://via.placeholder.com/150' }}" 
                                             alt="{{ $produk->nama_produk }}" 
                                             class="w-24 h-24 object-cover rounded-md mb-2">
                                        <h4 class="text-sm font-semibold">{{ $produk->nama_produk }}</h4>
                                        <p class="text-xs text-gray-600 mb-2">Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}</p>

                                        {{-- Form untuk menambah ke keranjang --}}
                                        <form action="{{ route('admin.pesanan.addToCart', $produk->id_produk) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full text-xs bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-2 rounded">
                                                + Tambah
                                            </button>
                                        </form>
                                    </div>
                                @empty
                                    <p class="col-span-4 text-center text-gray-500">Tidak ada produk tersedia.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:w-1/3">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-medium text-gray-700 mb-4">Keranjang</h3>

                            @if (empty($cart))
                                <p class="text-center text-gray-500 my-4">Keranjang kosong.</p>
                            @else
                                {{-- Daftar Item di Keranjang --}}
                                <div class="space-y-2 mb-4">
                                    @foreach ($cart as $id => $item)
                                        <div class="flex justify-between items-center text-sm">
                                            <div>
                                                <p class="font-semibold">{{ $item['nama'] }}</p>
                                                <p class="text-xs text-gray-500">Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                                            </div>
                                            <div class="flex items-center">
                                                {{-- Form untuk update jumlah --}}
                                                <form action="{{ route('admin.pesanan.updateCart') }}" method="POST" class="flex items-center">
                                                    @csrf
                                                    <input type="hidden" name="id_produk" value="{{ $id }}">
                                                    <input type="number" name="jumlah" value="{{ $item['jumlah'] }}" class="w-16 text-center text-xs border-gray-300 rounded-md p-1 mx-2">
                                                    <button type="submit" class="text-xs text-blue-500 hover:underline">Update</button>
                                                </form>
                                                {{-- Form untuk hapus item --}}
                                                <form action="{{ route('admin.pesanan.removeFromCart') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id_produk" value="{{ $id }}">
                                                    <button type="submit" class="ml-2 text-red-500 hover:text-red-700">&times;</button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <hr>
                                <div class="flex justify-between font-bold text-md mt-2">
                                    <span>Total</span>
                                    <span>Rp {{ number_format($totalHargaKeranjang, 0, ',', '.') }}</span>
                                </div>
                            @endif

                            @if (!empty($cart))
                                <hr class="my-4">
                                {{-- Form untuk menyelesaikan pembayaran --}}
                                <form action="{{ route('admin.pesanan.storeOrder') }}" method="POST">
                                    @csrf
                                    <h4 class="text-md font-medium text-gray-700 mb-2">Data Pelanggan</h4>
                                    <div class="mb-2">
                                        <label for="nama_pelanggan" class="text-sm text-gray-600">Nama Pelanggan (Opsional)</label>
                                        <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="w-full text-sm px-2 py-1 border border-gray-300 rounded-md">
                                    </div>
                                    <div class="mb-2">
                                        <label for="kontak_pelanggan" class="text-sm text-gray-600">Kontak Pelanggan (Opsional)</label>
                                        <input type="text" name="kontak_pelanggan" id="kontak_pelanggan" class="w-full text-sm px-2 py-1 border border-gray-300 rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="catatan_penjualan" class="text-sm text-gray-600">Catatan (Opsional)</label>
                                        <textarea name="catatan_penjualan" id="catatan_penjualan" rows="2" class="w-full text-sm px-2 py-1 border border-gray-300 rounded-md"></textarea>
                                    </div>
                                    <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                                        Selesaikan Pembayaran (CASH)
                                    </button>
                                </form>
                                {{-- Form untuk kosongkan keranjang --}}
                                <form action="{{ route('admin.pesanan.clearCart') }}" method="POST" class="mt-2">
                                    @csrf
                                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-4 rounded text-sm">
                                        Kosongkan Keranjang
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>