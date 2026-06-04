<nav class="bg-luxury-charcoal border-b border-luxury-gold/30 shadow-lg flex-shrink-0 z-50">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Left Side: Hamburger & Brand -->
            <div class="flex items-center">
                <!-- Mobile Hamburger -->
                <button @click="open = ! open" class="inline-flex lg:hidden items-center justify-center p-2 rounded-md text-luxury-gold hover:text-luxury-champagne focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                
                <!-- Brand -->
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 ml-2 lg:ml-0 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-luxury-gold group-hover:text-luxury-champagne transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.7 10.3a2.41 2.41 0 0 0 0 3.41l7.59 7.59a2.41 2.41 0 0 0 3.41 0l7.59-7.59a2.41 2.41 0 0 0 0-3.41l-7.59-7.59a2.41 2.41 0 0 0-3.41 0Z"/><path d="m2 12 10 10"/><path d="m22 12-10 10"/><path d="m12 2 10 10"/><path d="m2 12 10-10"/></svg>
                    <div class="flex flex-col">
                        <span class="text-2xl font-serif font-bold text-luxury-pearl leading-tight tracking-wide group-hover:text-luxury-ivory transition-colors">TraciF</span>
                        <span class="text-[9px] text-luxury-gold uppercase tracking-widest hidden sm:block">Sales Intelligence</span>
                    </div>
                </a>
            </div>

            <!-- Right Side: Profile & Role Badge -->
            <div class="flex items-center space-x-4">
                <!-- Search Icon (Placeholder) -->
                <button class="hidden sm:flex text-luxury-gold hover:text-luxury-champagne transition p-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>

                <!-- Notifications -->
                <a href="{{ route('admin.notifikasi.index') }}" class="relative p-2 text-luxury-gold hover:text-luxury-champagne transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                        <span class="absolute top-1 right-1 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-luxury-charcoal"></span>
                    @endif
                </a>

                <!-- Role Badge -->
                <span class="hidden sm:inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider bg-luxury-gold/10 text-luxury-gold border border-luxury-gold/50 shadow-[0_0_10px_rgba(200,169,107,0.2)]">
                    {{ Auth::user()->role }}
                </span>

                <!-- Profile Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center space-x-2 px-3 py-2 border-l border-luxury-gold/30 text-sm leading-4 font-medium text-luxury-ivory bg-transparent hover:text-luxury-gold focus:outline-none transition ease-in-out duration-150 pl-4 ml-2">
                            <span>{{ Auth::user()->name }}</span>
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=C8A96B&background=1A1A1A" alt="Avatar" class="h-8 w-8 rounded-full border border-luxury-gold/50 ml-2">
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-luxury-ivory hover:text-luxury-gold font-medium">
                            {{ __('Profile Settings') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="hover:bg-luxury-ivory hover:text-red-600 font-medium text-red-500">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>