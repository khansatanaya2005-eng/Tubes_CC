{{-- resources/views/admin/produk/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        {{ __('Edit Culinary Item') }}
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-[20px] shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] border border-slate-100 p-8">
            <div class="mb-8 border-b border-slate-100 pb-6">
                <h3 class="text-2xl font-sans font-bold text-luxury-charcoal">Edit Menu Item</h3>
                <p class="text-sm text-slate-500 mt-1">Updating details for <span class="font-bold text-luxury-gold">{{ $produk->nama_produk }}</span></p>
            </div>

            <form method="POST" action="{{ route('admin.produk.update', $produk->id_produk) }}" enctype="multipart/form-data">
                @method('PUT')
                @include('admin.produk._form', ['tombol_submit' => 'Update Item'])
            </form>
        </div>
    </div>
</x-app-layout>
