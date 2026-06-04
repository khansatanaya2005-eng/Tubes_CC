<aside 
    class="w-64 bg-luxury-pearl text-luxury-charcoal flex-shrink-0 flex flex-col h-full border-r border-luxury-gold/20 shadow-xl transition-transform duration-300 ease-in-out z-40 absolute lg:static"
    :class="{'translate-x-0': open, '-translate-x-full lg:translate-x-0': !open}"
    x-cloak>

    <div class="flex-1 py-6 px-4 space-y-2 overflow-y-auto custom-scrollbar">
        <!-- Dashboard Link -->
        <a href="{{ route('dashboard') }}"
           class="flex items-center space-x-3 py-3 px-4 rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-luxury-charcoal text-luxury-gold shadow-md transform scale-[1.02]' : 'text-slate-600 hover:bg-luxury-ivory hover:text-luxury-charcoal hover:pl-5' }}">
           <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span class="font-semibold tracking-wide text-sm">
                @if(Auth::user()->role === 'admin') Executive Board
                @elseif(Auth::user()->role === 'kasir') Cashier Desk
                @else Dashboard Saya @endif
            </span>
        </a>

        <hr class="border-luxury-gold/20 my-4 w-4/5 mx-auto">

        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'kasir')
            <!-- Admin / Kasir Only -->
            <div class="px-4 text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 mt-4">POS & Sales</div>
            
            <a href="{{ route('admin.pesanan.index') }}"
               class="flex items-center space-x-3 py-2.5 px-4 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.pesanan.index') ? 'bg-luxury-charcoal text-luxury-gold shadow-md transform scale-[1.02]' : 'text-slate-600 hover:bg-luxury-ivory hover:text-luxury-charcoal hover:pl-5' }}">
               <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
               <span class="font-medium tracking-wide text-sm">Create Order</span>
            </a>

            <a href="{{ route('admin.riwayatpenjualan.index') }}"
               class="flex items-center space-x-3 py-2.5 px-4 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.riwayatpenjualan.*') ? 'bg-luxury-charcoal text-luxury-gold shadow-md transform scale-[1.02]' : 'text-slate-600 hover:bg-luxury-ivory hover:text-luxury-charcoal hover:pl-5' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span class="font-medium tracking-wide text-sm">Sales History</span>
            </a>

            <div class="px-4 text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 mt-6">Management</div>
            
            <a href="{{ route('admin.pelanggan.index') }}"
               class="flex items-center space-x-3 py-2.5 px-4 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.pelanggan.*') ? 'bg-luxury-charcoal text-luxury-gold shadow-md transform scale-[1.02]' : 'text-slate-600 hover:bg-luxury-ivory hover:text-luxury-charcoal hover:pl-5' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span class="font-medium tracking-wide text-sm">Customers</span>
            </a>

            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.produk.index') }}"
                   class="flex items-center space-x-3 py-2.5 px-4 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.produk.*') ? 'bg-luxury-charcoal text-luxury-gold shadow-md transform scale-[1.02]' : 'text-slate-600 hover:bg-luxury-ivory hover:text-luxury-charcoal hover:pl-5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <span class="font-medium tracking-wide text-sm">Products Catalog</span>
                </a>
                
                <div class="px-4 text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 mt-6">System</div>
                
                <a href="#" class="flex items-center space-x-3 py-2.5 px-4 rounded-xl transition-all duration-300 text-slate-600 hover:bg-luxury-ivory hover:text-luxury-charcoal hover:pl-5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span class="font-medium tracking-wide text-sm">Activity Logs</span>
                </a>
            @endif
        @else
            <!-- Pelanggan Only -->
            <div class="px-4 text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 mt-4">Shopping</div>
            
            <a href="{{ route('pelanggan.katalog') }}" class="flex items-center space-x-3 py-2.5 px-4 rounded-xl transition-all duration-300 {{ request()->routeIs('pelanggan.katalog') ? 'bg-luxury-charcoal text-luxury-gold shadow-md transform scale-[1.02]' : 'text-slate-600 hover:bg-luxury-ivory hover:text-luxury-charcoal hover:pl-5' }}">
               <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
               <span class="font-medium tracking-wide text-sm">Browse Products</span>
            </a>
            <a href="{{ route('pelanggan.orders') }}" class="flex items-center space-x-3 py-2.5 px-4 rounded-xl transition-all duration-300 {{ request()->routeIs('pelanggan.orders') ? 'bg-luxury-charcoal text-luxury-gold shadow-md transform scale-[1.02]' : 'text-slate-600 hover:bg-luxury-ivory hover:text-luxury-charcoal hover:pl-5' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                <span class="font-medium tracking-wide text-sm">My Orders</span>
            </a>
        @endif
    </div>
    
    <!-- Footer Section Sidebar -->
    <div class="p-4 border-t border-luxury-gold/20 bg-luxury-ivory">
        <p class="text-xs text-center text-slate-500">
            &copy; {{ date('Y') }} TraciF Hospitality
        </p>
    </div>
</aside>