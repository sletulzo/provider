<x-guest-layout>
    <div class="login-container">
        <div class="login-container-left">
            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <h2>Réinitialisation de mot de passe</h2>
                <h3>Rentre ton email et ton nouveau mot de passe.</h3>

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" placeholder="Votre adresse email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Mot de passe')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" placeholder="Nouveau mot de passe" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirmation du mot de passe')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                        type="password"
                                        placeholder="Confirmation du nouveau mot de passe"
                                        name="password_confirmation" required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button>
                        {{ __('Réinitialiser mon mot de passe') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        <div class="login-container-right">
            <h1>{{ config('app.name') }}</h1>
        </div>
    </div>
</x-guest-layout>
