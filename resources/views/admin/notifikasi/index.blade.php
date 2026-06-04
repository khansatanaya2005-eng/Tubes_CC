<x-app-layout>
    <x-slot name="header">
        {{ __('Notifications') }}
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-[20px] shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] border border-slate-100 p-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-8 border-b border-slate-100 pb-6">
                <div>
                    <h3 class="text-2xl font-serif font-bold text-luxury-charcoal">System Notifications</h3>
                    <p class="text-sm text-slate-500 mt-1">Alerts, updates, and transaction alerts.</p>
                </div>

                @if(Auth::user()->unreadNotifications()->count() > 0)
                    <form action="{{ route('admin.notifikasi.markAllAsRead') }}" method="POST">
                        @csrf
                        <button type="submit" class="h-12 px-6 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold uppercase tracking-widest rounded-xl transition-colors shadow-sm flex items-center justify-center whitespace-nowrap">
                            Mark All Read
                        </button>
                    </form>
                @endif
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="space-y-4">
                @forelse ($notifikasis as $notifikasi)
                    <a href="{{ route('admin.riwayatpenjualan.show', $notifikasi->data['id_penjualan']) }}" class="block p-5 rounded-xl border transition-all duration-300 {{ $notifikasi->read_at ? 'bg-slate-50 border-slate-100 hover:border-slate-300' : 'bg-white border-luxury-gold shadow-[0_4px_15px_-3px_rgba(200,169,107,0.3)]' }}">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-bold {{ $notifikasi->read_at ? 'text-slate-600' : 'text-luxury-charcoal' }} mb-1">
                                    {{ $notifikasi->data['message'] }}
                                </p>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">
                                    {{ $notifikasi->created_at->diffForHumans() }}
                                </p>
                            </div>
                            @if(!$notifikasi->read_at)
                                <span class="w-2.5 h-2.5 rounded-full bg-luxury-gold mt-1"></span>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="py-12 text-center rounded-[20px] border border-slate-100 bg-slate-50">
                        <svg class="w-12 h-12 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <p class="text-sm font-medium text-slate-500">No new notifications.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $notifikasis->links() }}
            </div>
        </div>
    </div>
</x-app-layout>