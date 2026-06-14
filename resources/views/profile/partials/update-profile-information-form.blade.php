<section class="profile-v2__card">
    <div class="profile-v2__card-head">
        <div class="profile-v2__card-icon"><i class="fa-regular fa-user"></i></div>
        <div>
            <h2 class="profile-v2__card-title">Informations personnelles</h2>
            <p class="profile-v2__card-desc">Nom et adresse e-mail de votre compte.</p>
        </div>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="profile-v2__form">
        @csrf
        @method('patch')

        <div class="profile-v2__field">
            <label for="name">Nom</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $user->name) }}"
                required
                autocomplete="name"
                placeholder="Votre nom"
            >
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div class="profile-v2__field">
            <label for="email">E-mail</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', $user->email) }}"
                required
                autocomplete="username"
                placeholder="votre@email.com"
            >
            <x-input-error :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <p class="profile-v2__hint">
                    Votre adresse e-mail n'est pas vérifiée.
                    <button form="send-verification" type="submit" class="profile-v2__link">
                        Renvoyer l'e-mail de vérification
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="profile-v2__success">Un nouveau lien de vérification a été envoyé.</p>
                @endif
            @endif
        </div>

        <div class="profile-v2__actions">
            <button type="submit" class="btn-primary">
                <span class="btn-loader"></span>
                <span class="btn-text">Enregistrer</span>
            </button>

            @if (session('status') === 'profile-updated')
                <span class="profile-v2__saved" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2500)">
                    <i class="fa-solid fa-check"></i> Enregistré
                </span>
            @endif
        </div>
    </form>
</section>
