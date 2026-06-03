{{-- resources/views/admin/produk/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Produk') }}: {{ $produk->nama_produk }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- Penting: enctype untuk upload file --}}
                    <form method="POST" action="{{ route('admin.produk.update', $produk->id_produk) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @include('admin.produk._form', ['tombol_submit' => 'Update Data Produk'])
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>