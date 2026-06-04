<section>
    <header>
        <h2 class="text-2xl font-serif font-bold text-luxury-charcoal">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-2 text-sm text-slate-500">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-widest">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="block w-full h-14 px-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition duration-200 outline-none text-luxury-charcoal" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-red-500 text-sm" />
        </div>

        <div>
            <label for="update_password_password" class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-widest">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" class="block w-full h-14 px-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition duration-200 outline-none text-luxury-charcoal" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-red-500 text-sm" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-widest">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="block w-full h-14 px-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold transition duration-200 outline-none text-luxury-charcoal" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-red-500 text-sm" />
        </div>

        <div class="flex items-center gap-6 pt-4">
            <button type="submit" class="h-14 px-8 bg-luxury-charcoal text-luxury-ivory text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-black transition-colors shadow-md">
                {{ __('Update Security') }}
            </button>

            @if (session('status') === 'password-updated')
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
