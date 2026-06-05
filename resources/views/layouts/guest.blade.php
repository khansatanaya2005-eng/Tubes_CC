<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-luxury-ivory">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TraciF - Sales Intelligence Platform') }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700|playfair-display:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-luxury-charcoal antialiased h-full overflow-hidden">
    <div class="min-h-screen flex h-full">
        <!-- Left Side: Luxury Visual -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-luxury-ivory via-white to-[#F0EBE1] relative flex-col justify-between p-16 overflow-hidden">
            
            <div class="relative z-10 flex flex-col">
                <span class="text-5xl font-playfair font-bold text-luxury-charcoal tracking-[-0.03em]">TraciF</span>
                <span class="text-sm font-sans font-normal text-luxury-charcoal opacity-70 mt-1">Sales Intelligence Platform</span>
            </div>
            
            <div class="relative z-10 mb-12">
                <h1 class="text-[3.5rem] font-playfair font-bold text-luxury-charcoal leading-[1.1] mb-6 tracking-tight">
                    Welcome to <span class="text-luxury-gold">TraciF.</span><br>
                    <span class="text-[1.75rem] font-sans font-light text-slate-500 tracking-wide mt-4 block leading-snug">
                        Premium Fine Dining<br>
                        Management System.
                    </span>
                </h1>
                <div class="w-16 h-1 bg-luxury-gold rounded-full mt-8"></div>
            </div>
        </div>

        <!-- Right Side: Auth Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 bg-white overflow-y-auto shadow-[-20px_0_40px_-15px_rgba(0,0,0,0.05)] z-20">
            <div class="w-full max-w-md">
                <div class="lg:hidden mb-12 text-center flex flex-col items-center">
                    <span class="text-4xl font-playfair font-bold text-luxury-charcoal tracking-[-0.03em]">TraciF</span>
                    <span class="text-xs font-sans font-normal text-luxury-charcoal opacity-70 mt-1">Sales Intelligence Platform</span>
                </div>
                
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
