<x-guest-layout>
    <div class="mb-10 text-center lg:text-left">
        <h2 class="text-3xl font-serif font-bold text-luxury-charcoal mb-2">Reset Password</h2>
        <p class="text-sm text-slate-500 font-medium">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-luxury-charcoal mb-2 uppercase tracking-wide">{{ __('Email Address') }}</label>
            <input id="email" class="block w-full px-4 py-3 bg-transparent border border-luxury-gold/50 rounded-xl focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition duration-200" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
        </div>

        <div class="pt-2">
            <button class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-luxury-ivory bg-luxury-charcoal hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-luxury-charcoal transition-all duration-300 transform hover:scale-[1.02]">
                {{ __('EMAIL PASSWORD RESET LINK') }}
            </button>
        </div>
        
        <!-- Login Link -->
        <div class="text-center mt-6">
            <a href="{{ route('login') }}" class="text-sm font-bold text-luxury-gold hover:text-luxury-charcoal transition duration-200">Return to Sign In</a>
        </div>
    </form>
</x-guest-layout>
