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
</head>
<body class="font-sans text-luxury-charcoal antialiased h-full overflow-hidden">
    <div class="min-h-screen flex h-full">
        <!-- Left Side: Luxury Visual -->
        <div class="hidden lg:flex lg:w-1/2 bg-luxury-charcoal relative flex-col justify-between p-16 overflow-hidden">
            <!-- Background Image with Overlay -->
            <div class="absolute inset-0 bg-cover bg-center opacity-40 mix-blend-overlay" style="background-image: url('https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?auto=format&fit=crop&q=80&w=2070')"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-luxury-charcoal via-luxury-charcoal/60 to-transparent"></div>
            
            <div class="relative z-10 flex items-center space-x-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-luxury-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.7 10.3a2.41 2.41 0 0 0 0 3.41l7.59 7.59a2.41 2.41 0 0 0 3.41 0l7.59-7.59a2.41 2.41 0 0 0 0-3.41l-7.59-7.59a2.41 2.41 0 0 0-3.41 0Z"/><path d="m2 12 10 10"/><path d="m22 12-10 10"/><path d="m12 2 10 10"/><path d="m2 12 10-10"/></svg>
                <div class="flex flex-col">
                    <span class="text-3xl font-serif font-bold text-luxury-pearl tracking-widest uppercase">TraciF</span>
                    <span class="text-[10px] text-luxury-champagne uppercase tracking-[0.3em]">Sales Intelligence</span>
                </div>
            </div>
            
            <div class="relative z-10 mb-12">
                <h1 class="text-5xl font-serif font-bold text-luxury-pearl leading-tight mb-6 tracking-wide">Elevate your<br>culinary business.</h1>
                <p class="text-lg text-luxury-champagne max-w-md font-light tracking-wide leading-relaxed">The premier Sales Intelligence Platform designed exclusively for premium hospitality and fine dining management.</p>
            </div>
        </div>

        <!-- Right Side: Auth Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 bg-luxury-ivory overflow-y-auto">
            <div class="w-full max-w-md">
                <div class="lg:hidden mb-12 text-center flex flex-col items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-luxury-gold mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.7 10.3a2.41 2.41 0 0 0 0 3.41l7.59 7.59a2.41 2.41 0 0 0 3.41 0l7.59-7.59a2.41 2.41 0 0 0 0-3.41l-7.59-7.59a2.41 2.41 0 0 0-3.41 0Z"/><path d="m2 12 10 10"/><path d="m22 12-10 10"/><path d="m12 2 10 10"/><path d="m2 12 10-10"/></svg>
                    <span class="text-3xl font-serif font-bold text-luxury-charcoal tracking-widest uppercase">TraciF</span>
                    <span class="text-xs text-luxury-gold uppercase tracking-[0.2em] mt-2">Sales Intelligence</span>
                </div>
                
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
