<x-guest-layout>

    <div class="login-container">
        <div class="login-container-left">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="login-container-mobile">
                    <div class="login-container-logo"></div>
                    <div class="login-container-title">{{ config('app.name') }}</div>
                </div>

                <h2>Content de te revoir</h2>
                <h3>Merci de rentrer ton email et ton mot de passe pour te connecter</h3>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" placeholder="Votre adresse email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" placeholder="Votre mot de passe" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
                    </label>
                </div>

                <x-primary-button class="m-t-15">
                    {{ __('Connexion') }}
                </x-primary-button>

                @if (Route::has('password.request'))
                    <div class="align-center m-t-15">
                        <a class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                            {{ __('Mot de passe oublié?') }}
                        </a>
                    </div>
                @endif
            </form>
        </div>
        <div class="login-container-right">
            <h1>{{ config('app.name') }}</h1>
        </div>
    </div>

</x-guest-layout>
