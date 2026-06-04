<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-luxury-ivory">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TraciF - Sales Intelligence Platform') }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600|cormorant-garamond:500,600,700|playfair-display:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full font-sans antialiased text-luxury-charcoal bg-luxury-ivory overflow-hidden">
    <div x-data="{ open: false }" class="h-full flex flex-col">
        <!-- FIXED TOP BAR -->
        @include('layouts.navigation')

        <div class="flex flex-1 overflow-hidden">
            <!-- FIXED SIDEBAR -->
            @include('layouts.partials.admin-sidebar')

            <!-- SCROLLABLE CONTENT -->
            <main class="flex-1 overflow-y-auto bg-luxury-ivory p-4 sm:p-8 transition-all duration-300">
                @if (isset($header))
                    <header class="bg-luxury-pearl shadow-sm rounded-xl mb-8 border border-luxury-gold/30">
                        <div class="max-w-7xl mx-auto py-5 px-6 font-serif text-3xl font-bold text-luxury-charcoal tracking-wide">
                            {{ $header }}
                        </div>
                    </header>
                @endif
                
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>