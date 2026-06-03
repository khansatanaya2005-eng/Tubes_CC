<aside x-data="{ dataMasterOpen: false }"
     class="w-64 bg-white text-slate-800 flex-shrink-0 flex flex-col h-full shadow-lg lg:shadow-none transition-transform duration-300 ease-in-out lg:translate-x-0 border-r border-slate-200"
     :class="{'translate-x-0 flex fixed lg:static z-30': open, '-translate-x-full hidden lg:flex': !open}"
     x-cloak>

    {{-- Logo dan Judul Sidebar --}}
    <div class="flex items-center justify-center h-16 border-b border-slate-200 flex-shrink-0 px-4">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
            <img src="{{ asset('images/sistracklogo.png') }}" alt="Sistrack Logo" class="h-8 w-auto">
            <span class="text-lg font-semibold text-slate-700">Sistrack CRM</span>
        </a>
    </div>

    {{-- Navigasi di dalam sidebar --}}
    <nav class="flex-1 p-3 space-y-1.5 overflow-y-auto">
        {{-- Link ke Dashboard --}}
        <a href="{{ route('dashboard') }}"
           class="flex items-center space-x-3 py-2 px-3 rounded-md transition-colors duration-200 hover:bg-sky-100 hover:text-sky-700 {{ request()->routeIs('dashboard') ? 'bg-sky-500 text-white hover:bg-sky-500 hover:text-white' : 'text-slate-600' }}">
           {{-- Ganti dengan SVG Icon Anda --}}
           <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span>Dashboard</span>
        </a>

        {{-- Link ke Buat Pesanan --}}
        <a href="{{ route('admin.pesanan.index') }}"
           class="flex items-center space-x-3 py-2 px-3 rounded-md transition-colors duration-200 hover:bg-sky-100 hover:text-sky-700 {{ request()->routeIs('admin.pesanan.index') ? 'bg-sky-500 text-white hover:bg-sky-500 hover:text-white' : 'text-slate-600' }}">
           <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
           <span>Buat Pesanan</span>
        </a>

        {{-- Dropdown untuk Data Master --}}
        <div>
            <button @click="dataMasterOpen = !dataMasterOpen" class="w-full flex justify-between items-center py-2 px-3 rounded-md transition-colors duration-200 hover:bg-sky-100 hover:text-sky-700 {{ request()->routeIs('admin.pelanggan.*') || request()->routeIs('admin.produk.*') ? 'text-sky-600 font-semibold' : 'text-slate-600' }}">
                <span class="flex items-center space-x-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10m16-5H4m16 0l-3 3m3-3l-3-3"></path></svg>
                    <span>Data Master</span>
                </span>
                <svg class="w-4 h-4 transform transition-transform duration-200" :class="{'rotate-180': dataMasterOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="dataMasterOpen" x-transition class="ml-4 mt-1 space-y-1 pl-3 border-l border-slate-300">
                <a href="{{ route('admin.pelanggan.index') }}"
                   class="block py-1.5 px-3 rounded-md text-sm hover:bg-sky-100 hover:text-sky-700 {{ request()->routeIs('admin.pelanggan.*') ? 'bg-sky-100 text-sky-700 font-semibold' : 'text-slate-500' }}">
                    Pelanggan
                </a>
                <a href="{{ route('admin.produk.index') }}"
                   class="block py-1.5 px-3 rounded-md text-sm hover:bg-sky-100 hover:text-sky-700 {{ request()->routeIs('admin.produk.*') ? 'bg-sky-100 text-sky-700 font-semibold' : 'text-slate-500' }}">
                    Produk
                </a>
            </div>
        </div>

        {{-- Link ke Riwayat Penjualan --}}
        <a href="{{ route('admin.riwayatpenjualan.index') }}"
           class="flex items-center space-x-3 py-2 px-3 rounded-md transition-colors duration-200 hover:bg-sky-100 hover:text-sky-700 {{ request()->routeIs('admin.riwayatpenjualan.*') ? 'bg-sky-500 text-white hover:bg-sky-500 hover:text-white' : 'text-slate-600' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span>Riwayat Penjualan</span>
        </a>
    </nav>

    {{-- Footer Sidebar --}}
    <div class="p-3 border-t border-slate-200 space-y-2 flex-shrink-0">
         <a href="{{ route('admin.notifikasi.index') }}"
           class="flex justify-between items-center py-2 px-3 rounded-md transition-colors duration-200 hover:bg-sky-100 hover:text-sky-700 {{ request()->routeIs('admin.notifikasi.index') ? 'bg-sky-500 text-white hover:bg-sky-500 hover:text-white' : 'text-slate-600' }}">
            <span class="flex items-center space-x-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <span>Notifikasi</span>
            </span>
            @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                <span class="bg-red-500 text-white text-xs font-semibold px-1.5 py-0.5 rounded-full">
                    {{ $unreadNotificationsCount }}
                </span>
            @endif
        </a>
        <a href="{{ route('profile.edit') }}"
           class="flex items-center space-x-3 py-2 px-3 rounded-md transition-colors duration-200 hover:bg-sky-100 hover:text-sky-700 {{ request()->routeIs('profile.edit') ? 'bg-sky-500 text-white hover:bg-sky-500 hover:text-white' : 'text-slate-600' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            <span>Profil</span>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); this.closest('form').submit();"
               class="flex items-center space-x-3 w-full text-left py-2 px-3 rounded-md transition-colors duration-200 bg-red-500 text-white hover:bg-red-600">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                <span>Logout</span>
            </a>
        </form>
    </div>
</aside>