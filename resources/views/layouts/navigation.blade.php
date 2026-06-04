<nav class="h-[72px] bg-white/80 backdrop-blur-md border-b border-slate-200 shadow-[0_4px_30px_rgba(0,0,0,0.02)] flex-shrink-0 z-30 sticky top-0">
    <div class="max-w-full mx-auto px-6 lg:px-10 h-full flex justify-between items-center">
        <!-- Left Side: Mobile Hamburger -->
        <div class="flex items-center">
            <button @click="open = ! open" class="inline-flex lg:hidden items-center justify-center p-2 rounded-md text-luxury-charcoal hover:bg-slate-100 transition mr-4">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <!-- Global Search -->
            <div class="hidden sm:flex items-center relative w-64 lg:w-96">
                <svg class="w-4 h-4 absolute left-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" placeholder="Cari menu, produk, pelanggan..." class="w-full h-11 pl-11 pr-4 bg-slate-100/50 border border-slate-200 rounded-full text-sm focus:ring-1 focus:ring-luxury-gold focus:border-luxury-gold transition-colors outline-none text-luxury-charcoal placeholder-slate-400">
            </div>
        </div>

        <!-- Right Side: Profile & Actions -->
        <div class="flex items-center space-x-2 sm:space-x-4">
            
            <!-- Notifications -->
            <a href="{{ route('admin.notifikasi.index') }}" class="relative p-2.5 rounded-full text-slate-500 hover:text-luxury-gold hover:bg-slate-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                    <span class="absolute top-2 right-2 flex h-4 w-4 items-center justify-center rounded-full bg-luxury-gold ring-2 ring-white text-[9px] font-bold text-white">{{ $unreadNotificationsCount }}</span>
                @endif
            </a>
            
            <div class="w-px h-8 bg-slate-200 mx-2"></div>

            <!-- Profile Dropdown -->
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="flex items-center space-x-3 px-2 py-1 bg-transparent hover:bg-slate-100 rounded-full focus:outline-none transition ease-in-out duration-150">
                        <div class="h-9 w-9 rounded-full bg-luxury-gold text-white flex items-center justify-center text-sm font-bold shadow-sm">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <div class="hidden md:flex flex-col items-start mr-2">
                            <span class="text-sm font-bold text-luxury-charcoal leading-tight">{{ Auth::user()->name }}</span>
                            <span class="text-[10px] text-slate-500 capitalize leading-tight mt-0.5">Administrator</span>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </x-slot>
                <x-slot name="content">
                    <div class="px-4 py-3 border-b border-slate-100">
                        <p class="text-sm text-luxury-charcoal font-medium leading-none">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-500 font-normal leading-none mt-2">{{ Auth::user()->email }}</p>
                    </div>
                    <x-dropdown-link :href="route('profile.edit')" class="text-sm">
                        {{ __('Profile Settings') }}
                    </x-dropdown-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="text-sm text-red-600 hover:text-red-700 hover:bg-red-50">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</nav>