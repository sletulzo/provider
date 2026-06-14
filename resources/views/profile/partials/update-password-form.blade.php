<section class="profile-v2__card">
    <div class="profile-v2__card-head">
        <div class="profile-v2__card-icon"><i class="fa-solid fa-lock"></i></div>
        <div>
            <h2 class="profile-v2__card-title">Mot de passe</h2>
            <p class="profile-v2__card-desc">Utilisez un mot de passe long et unique pour sécuriser votre compte.</p>
        </div>
    </div>

    <form method="post" action="{{ route('password.update') }}" class="profile-v2__form">
        @csrf
        @method('put')

        <div class="profile-v2__field">
            <label for="update_password_current_password">Mot de passe actuel</label>
            <input
                type="password"
                id="update_password_current_password"
                name="current_password"
                autocomplete="current-password"
                placeholder="••••••••"
            >
            <x-input-error :messages="$errors->updatePassword->get('current_password')" />
        </div>

        <div class="profile-v2__field">
            <label for="update_password_password">Nouveau mot de passe</label>
            <input
                type="password"
                id="update_password_password"
                name="password"
                autocomplete="new-password"
                placeholder="••••••••"
            >
            <x-input-error :messages="$errors->updatePassword->get('password')" />
        </div>

        <div class="profile-v2__field">
            <label for="update_password_password_confirmation">Confirmer le mot de passe</label>
            <input
                type="password"
                id="update_password_password_confirmation"
                name="password_confirmation"
                autocomplete="new-password"
                placeholder="••••••••"
            >
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" />
        </div>

        <div class="profile-v2__actions">
            <button type="submit" class="btn-primary">
                <span class="btn-loader"></span>
                <span class="btn-text">Mettre à jour le mot de passe</span>
            </button>

            @if (session('status') === 'password-updated')
                <span class="profile-v2__saved" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2500)">
                    <i class="fa-solid fa-check"></i> Mot de passe mis à jour
                </span>
            @endif
        </div>
    </form>
</section>
