<x-guest-layout>
    <div class="login-container">
        <div class="login-container-left">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <h2>Mot de passe oublié ?</h2>
                <h3>Rentre ton email et nous allons te renvoyer ton mot de passe par email</h3>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" placeholder="Votre adresse email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button>
                        {{ __('Envoyer le lien par email') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        <div class="login-container-right">
            <h1>{{ config('app.name') }}</h1>
        </div>
    </div>
</x-guest-layout>
