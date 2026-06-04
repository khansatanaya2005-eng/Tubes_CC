<aside 
    class="w-[260px] bg-luxury-charcoal flex-shrink-0 flex flex-col h-screen border-r border-white/5 transition-transform duration-300 ease-in-out z-40 fixed lg:relative"
    :class="{'translate-x-0': open, '-translate-x-full lg:translate-x-0': !open}"
    x-cloak>

    <!-- Branding -->
    <div class="h-[72px] flex items-center px-8 border-b border-white/5 flex-shrink-0">
        <a href="{{ route('dashboard') }}" class="flex flex-col group">
            <span class="text-[28px] font-serif font-bold text-luxury-pearl tracking-[-0.03em] leading-none group-hover:text-luxury-gold transition-colors">TraciF</span>
            <span class="text-[10px] font-sans text-luxury-pearl opacity-60 mt-1 uppercase tracking-widest leading-none">Sales Intelligence</span>
        </a>
    </div>

    <!-- Menus -->
    <div class="flex-1 py-6 px-4 space-y-1 overflow-y-auto scrollbar-hide">
        <!-- MAIN Section -->
        <div class="px-4 text-[10px] font-bold text-luxury-gold opacity-80 uppercase tracking-widest mb-3 mt-2">Main</div>
        
        <a href="{{ route('dashboard') }}"
           class="flex items-center space-x-3 py-3 px-4 rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-luxury-gold text-white shadow-md' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
            <span class="font-medium tracking-wide text-sm">Dashboard</span>
        </a>

        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'kasir')
            <!-- OPERATIONS Section -->
            <div class="px-4 text-[10px] font-bold text-luxury-gold opacity-80 uppercase tracking-widest mb-3 mt-8">Operations</div>
            
            <a href="{{ route('admin.pesanan.index') }}"
               class="flex items-center space-x-3 py-3 px-4 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.pesanan.*') ? 'bg-luxury-gold text-white shadow-md' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
               <span class="font-medium tracking-wide text-sm">Create Order</span>
            </a>

            <a href="{{ route('admin.riwayatpenjualan.index') }}"
               class="flex items-center space-x-3 py-3 px-4 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.riwayatpenjualan.*') ? 'bg-luxury-gold text-white shadow-md' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                <span class="font-medium tracking-wide text-sm">Sales History</span>
            </a>

            <!-- CUSTOMERS Section -->
            <div class="px-4 text-[10px] font-bold text-luxury-gold opacity-80 uppercase tracking-widest mb-3 mt-8">Customers</div>
            
            <a href="{{ route('admin.pelanggan.index') }}"
               class="flex items-center space-x-3 py-3 px-4 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.pelanggan.*') ? 'bg-luxury-gold text-white shadow-md' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                <span class="font-medium tracking-wide text-sm">Customer Database</span>
            </a>

            @if(Auth::user()->role === 'admin')
                <!-- SYSTEM Section -->
                <div class="px-4 text-[10px] font-bold text-luxury-gold opacity-80 uppercase tracking-widest mb-3 mt-8">System</div>
                
                <a href="{{ route('admin.produk.index') }}"
                   class="flex items-center space-x-3 py-3 px-4 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.produk.*') ? 'bg-luxury-gold text-white shadow-md' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                    <span class="font-medium tracking-wide text-sm">Products Catalog</span>
                </a>
                
                <a href="#" class="flex items-center space-x-3 py-3 px-4 rounded-xl transition-all duration-300 text-white/60 hover:bg-white/5 hover:text-white">
                    <span class="font-medium tracking-wide text-sm">Activity Logs</span>
                </a>
            @endif
        @else
            <!-- Pelanggan Only -->
            <div class="px-4 text-[10px] font-bold text-luxury-gold opacity-80 uppercase tracking-widest mb-3 mt-8">Shopping</div>
            
            <a href="{{ route('pelanggan.katalog') }}" class="flex items-center space-x-3 py-3 px-4 rounded-xl transition-all duration-300 {{ request()->routeIs('pelanggan.katalog') ? 'bg-luxury-gold text-white shadow-md' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
               <span class="font-medium tracking-wide text-sm">Browse Products</span>
            </a>
            <a href="{{ route('pelanggan.orders') }}" class="flex items-center space-x-3 py-3 px-4 rounded-xl transition-all duration-300 {{ request()->routeIs('pelanggan.orders') ? 'bg-luxury-gold text-white shadow-md' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                <span class="font-medium tracking-wide text-sm">My Orders</span>
            </a>
        @endif
    </div>
    
    <!-- Role Badge Footer -->
    <div class="p-6 border-t border-white/5 bg-black/20">
        <div class="flex items-center justify-between bg-black/40 p-3 rounded-xl border border-white/10">
            <div class="flex flex-col">
                <span class="text-[10px] text-white/50 uppercase tracking-widest">Role Saat Ini</span>
                <span class="text-sm font-bold text-luxury-gold uppercase tracking-widest mt-1">{{ Auth::user()->role }}</span>
            </div>
            <div class="w-8 h-8 rounded-full bg-luxury-gold/20 border border-luxury-gold/30 flex items-center justify-center">
                <svg class="w-4 h-4 text-luxury-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
        </div>
    </div>
</aside>