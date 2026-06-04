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
    <div x-data="{ open: false }" class="flex h-screen overflow-hidden bg-[#F4F2EE]">
        
        <!-- FIXED SIDEBAR -->
        @include('layouts.partials.admin-sidebar')

        <!-- MAIN CONTENT WRAPPER -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- FIXED TOP BAR -->
            @include('layouts.navigation')

            <!-- SCROLLABLE CONTENT -->
            <main class="flex-1 overflow-y-auto p-6 lg:p-10 transition-all duration-300">
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