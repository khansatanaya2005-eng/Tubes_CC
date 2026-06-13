<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-luxury-ivory">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TraciF - Fine Dining System') }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700|playfair-display:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full font-sans antialiased text-luxury-charcoal bg-luxury-ivory overflow-hidden">
    <div x-data="{ open: false }" class="flex h-screen overflow-hidden bg-[#F4F2EE]">
        
        @if(Auth::check())
            <!-- FIXED SIDEBAR -->
            @include('layouts.partials.admin-sidebar')
        @endif

        <!-- MAIN CONTENT WRAPPER -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            @if(Auth::check())
                <!-- FIXED TOP BAR -->
                @include('layouts.navigation')
            @else
                <!-- GUEST TOP BAR FOR TABLE VIEW -->
                <div class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center px-6 lg:px-10 flex-shrink-0 z-30">
                    <a href="{{ route('pelanggan.katalog') }}" class="flex items-center">
                        <span class="text-2xl font-serif font-bold text-luxury-charcoal tracking-tight">TraciF.</span>
                    </a>
                    <div class="ml-auto flex items-center space-x-4">
                        @if(!request()->routeIs('pelanggan.katalog'))
                            <a href="{{ route('pelanggan.katalog') }}" class="text-sm font-bold text-slate-500 hover:text-luxury-gold uppercase tracking-widest transition-colors">Lihat Menu</a>
                        @else
                            <a href="{{ route('pelanggan.orders') }}" class="text-sm font-bold text-slate-500 hover:text-luxury-gold uppercase tracking-widest transition-colors">Pesanan Meja Saya</a>
                        @endif
                    </div>
                </div>
            @endif

            <!-- SCROLLABLE CONTENT -->
            <main class="flex-1 overflow-y-auto p-6 lg:p-10 transition-all duration-300 relative">
                
                <!-- Flash Notification using Alpine.js -->
                <div x-data="{ show: {{ session('success') ? 'true' : 'false' }}, message: '{{ session('success') }}', progress: '100%' }" 
                     @notify.window="message = $event.detail; show = true; progress = '100%'; setTimeout(() => progress = '0%', 100); setTimeout(() => show = false, 3000)"
                     x-show="show"
                     style="display: none;"
                     x-init="if(show) { setTimeout(() => progress = '0%', 100); setTimeout(() => show = false, 3000) }"
                     x-transition:enter="transform ease-out duration-300 transition"
                     x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                     x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed bottom-10 right-10 z-50 max-w-sm w-full bg-white rounded-xl shadow-2xl border border-slate-100 pointer-events-auto overflow-hidden">
                    <div class="p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3 w-0 flex-1 pt-0.5">
                                <p class="text-sm font-bold text-luxury-charcoal">Berhasil!</p>
                                <p class="mt-1 text-sm text-slate-500" x-text="message"></p>
                            </div>
                            <div class="ml-4 flex-shrink-0 flex">
                                <button @click="show = false" class="bg-white rounded-md inline-flex text-slate-400 hover:text-slate-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                    <span class="sr-only">Close</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="h-1 bg-emerald-500" style="transition: width 3000ms linear;" :style="`width: ${progress};`"></div>
                </div>

                @if (isset($header))
                    <div class="mb-8">
                        <h1 class="font-serif text-4xl font-bold text-luxury-charcoal tracking-[-0.02em]">
                            {{ $header }}
                        </h1>
                    </div>
                @endif
                
                <div class="max-w-[1440px] mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>