{{-- resources/views/admin/pelanggan/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        {{ __('Guest Registry') }}
    </x-slot>

    <div class="bg-white rounded-[20px] shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] border border-slate-100 p-8">
        
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-8 border-b border-slate-100 pb-6">
            <div>
                <h3 class="text-2xl font-sans font-bold text-luxury-charcoal">Data Pelanggan</h3>
                <p class="text-sm text-slate-500 mt-1">Daftar pelanggan yang telah terdaftar dari akses meja.</p>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 text-red-700 border border-red-200 rounded-xl flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <div class="overflow-x-auto rounded-xl border border-slate-100">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">No</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">Nama</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">No Meja</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">Tanggal Pesanan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($pelanggans as $index => $pelanggan)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-400">{{ $pelanggans->firstItem() + $index }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-sans font-bold text-luxury-charcoal text-base">{{ $pelanggan->nama_pelanggan }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-slate-600">{{ $pelanggan->kontak_pelanggan ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-500">{{ $pelanggan->created_at->format('d M Y, H:i') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <svg class="w-12 h-12 mx-auto text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <p class="text-sm font-medium text-slate-400">Belum ada data pelanggan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $pelanggans->links() }}
        </div>
    </div>
</x-app-layout>
