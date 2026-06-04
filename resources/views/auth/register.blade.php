<x-guest-layout>
    <div class="mb-10 text-center lg:text-left">
        <h2 class="text-3xl font-serif font-bold text-luxury-charcoal mb-2">Request Access</h2>
        <p class="text-sm text-slate-500 font-medium">Join our premier fine dining management network.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-widest">{{ __('Full Name') }}</label>
            <input id="name" class="block w-full h-14 px-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition duration-200 outline-none text-luxury-charcoal" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-500 text-sm" />
        </div>

        <!-- Username & Nama Lengkap -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="username" class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-widest">{{ __('Username') }}</label>
                <input id="username" class="block w-full h-14 px-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition duration-200 outline-none text-luxury-charcoal" type="text" name="username" :value="old('username')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('username')" class="mt-1 text-red-500 text-sm" />
            </div>
            <div>
                <label for="nama_lengkap" class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-widest">{{ __('Legal Name') }}</label>
                <input id="nama_lengkap" class="block w-full h-14 px-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition duration-200 outline-none text-luxury-charcoal" type="text" name="nama_lengkap" :value="old('nama_lengkap')" required />
                <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-1 text-red-500 text-sm" />
            </div>
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-widest">{{ __('Email Address') }}</label>
            <input id="email" class="block w-full h-14 px-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition duration-200 outline-none text-luxury-charcoal" type="email" name="email" :value="old('email')" required autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500 text-sm" />
        </div>

        <!-- Password -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="password" class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-widest">{{ __('Password') }}</label>
                <input id="password" class="block w-full h-14 px-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition duration-200 outline-none text-luxury-charcoal" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500 text-sm" />
            </div>
            <div>
                <label for="password_confirmation" class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-widest">{{ __('Confirm') }}</label>
                <input id="password_confirmation" class="block w-full h-14 px-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition duration-200 outline-none text-luxury-charcoal" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-500 text-sm" />
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <button class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-luxury-ivory bg-luxury-charcoal hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-luxury-charcoal transition-all duration-300 transform hover:scale-[1.02]">
                {{ __('CREATE ACCOUNT') }}
            </button>
        </div>
        
        <!-- Login Link -->
        <div class="text-center mt-6">
            <p class="text-sm text-slate-600">
                Already part of the network? 
                <a href="{{ route('login') }}" class="font-bold text-luxury-gold hover:text-luxury-charcoal transition duration-200">Sign In</a>
            </p>
        </div>
    </form>
</x-guest-layout>
