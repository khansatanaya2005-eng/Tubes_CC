<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TraciF - Premium Fine Dining</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700|playfair-display:400,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-luxury-charcoal flex items-center justify-center min-h-screen relative overflow-hidden">
    
    <!-- Background Decor -->
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-br from-luxury-charcoal via-slate-900 to-black opacity-90"></div>
        <div class="absolute top-1/4 -left-1/4 w-[500px] h-[500px] bg-luxury-gold/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-1/4 -right-1/4 w-[500px] h-[500px] bg-luxury-champagne/10 rounded-full blur-[120px]"></div>
    </div>

    <!-- Main Container -->
    <div class="relative z-10 w-full max-w-md px-6 py-12 bg-white/5 backdrop-blur-md rounded-3xl border border-white/10 shadow-2xl">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-playfair font-bold text-luxury-gold tracking-tight mb-2">TraciF.</h1>
            <p class="text-sm font-light text-white/60 tracking-widest uppercase">Premium Fine Dining</p>
        </div>

        <form method="POST" action="{{ route('pelanggan.meja.set') }}" class="space-y-6">
            @csrf
            
            @if (session('error'))
                <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm font-medium text-center">
                    {{ session('error') }}
                </div>
            @endif

            <div>
                <label for="nomor_meja" class="block text-xs font-bold text-luxury-champagne mb-3 uppercase tracking-widest text-center">Enter Table Number</label>
                <input id="nomor_meja" type="text" name="nomor_meja" 
                    class="block w-full h-16 text-center text-3xl font-sans font-bold bg-white/5 border border-white/10 rounded-2xl focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition duration-200 outline-none text-white placeholder-white/20" 
                    placeholder="e.g. 08" 
                    required autofocus autocomplete="off" />
                <x-input-error :messages="$errors->get('nomor_meja')" class="mt-2 text-red-400 text-sm text-center" />
            </div>

            <button type="submit" class="w-full h-14 bg-luxury-gold hover:bg-luxury-champagne text-luxury-charcoal font-bold rounded-2xl transition-all duration-300 shadow-[0_0_20px_rgba(184,148,91,0.3)] hover:shadow-[0_0_30px_rgba(214,185,122,0.5)] transform hover:-translate-y-0.5 tracking-wider uppercase text-sm flex items-center justify-center space-x-2">
                <span>Access Culinary Menu</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </form>

        <div class="mt-8 text-center">
            <a href="{{ route('login') }}" class="text-xs font-medium text-white/40 hover:text-luxury-gold transition-colors underline underline-offset-4">Staff Access</a>
        </div>
    </div>
</body>
</html>
