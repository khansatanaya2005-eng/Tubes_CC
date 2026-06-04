{{-- resources/views/admin/produk/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        {{ __('Add Culinary Item') }}
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-[20px] shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] border border-slate-100 p-8">
            <div class="mb-8 border-b border-slate-100 pb-6">
                <h3 class="text-2xl font-serif font-bold text-luxury-charcoal">New Menu Item</h3>
                <p class="text-sm text-slate-500 mt-1">Enter the details for the new culinary offering.</p>
            </div>

            <form method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data">
                @include('admin.produk._form', ['tombol_submit' => 'Add Item'])
            </form>
        </div>
    </div>
</x-app-layout>