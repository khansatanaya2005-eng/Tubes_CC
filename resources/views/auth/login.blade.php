<x-guest-layout>
    <div class="mb-10 text-center lg:text-left">
        <h2 class="text-3xl font-serif font-bold text-luxury-charcoal mb-2">Welcome Back</h2>
        <p class="text-sm text-slate-500 font-medium">Please sign in to your executive account.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-widest">{{ __('Email Address') }}</label>
            <input id="email" class="block w-full h-14 px-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition duration-200 outline-none text-luxury-charcoal" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-widest">{{ __('Password') }}</label>
            <input id="password" class="block w-full h-14 px-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition duration-200 outline-none text-luxury-charcoal" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-luxury-gold/50 text-luxury-gold shadow-sm focus:ring-luxury-gold cursor-pointer" name="remember">
                <span class="ms-3 text-sm text-slate-600 group-hover:text-luxury-charcoal transition">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-luxury-gold hover:text-luxury-charcoal transition duration-200" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-luxury-ivory bg-luxury-charcoal hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-luxury-charcoal transition-all duration-300 transform hover:scale-[1.02]">
                {{ __('SIGN IN') }}
            </button>
        </div>
        
        <!-- Registration Link -->
        <div class="text-center mt-6">
            <p class="text-sm text-slate-600">
                Don't have an account? 
                <a href="{{ route('register') }}" class="font-bold text-luxury-gold hover:text-luxury-charcoal transition duration-200">Request Access</a>
            </p>
        </div>
    </form>
</x-guest-layout>
