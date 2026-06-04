<section>
    <header>
        <h2 class="text-2xl font-serif font-bold text-luxury-charcoal">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-2 text-sm text-slate-500">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-widest">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="block w-full h-14 px-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition duration-200 outline-none text-luxury-charcoal" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            <x-input-error class="mt-2 text-red-500 text-sm" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-widest">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="block w-full h-14 px-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition duration-200 outline-none text-luxury-charcoal" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            <x-input-error class="mt-2 text-red-500 text-sm" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-3 text-slate-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-luxury-gold hover:text-luxury-charcoal rounded-md focus:outline-none transition-colors">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-emerald-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-6 pt-4">
            <button type="submit" class="h-14 px-8 bg-luxury-charcoal text-luxury-ivory text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-black transition-colors shadow-md">
                {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-bold text-emerald-600 flex items-center"
                >
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
