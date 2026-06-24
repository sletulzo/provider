<x-form-page
    :back="route('provider.users')"
    eyebrow="Clients"
    :title="$user->name"
    subtitle="Modifiez les informations de ce client."
    icon="fa-regular fa-circle-user"
>
    <form method="POST" action="{{ route('provider.users.update', ['user' => $user->id]) }}" class="form-page__form">
        @csrf

        <div class="form-page__card">
            <div class="form-page__card-head">
                <h2 class="form-page__card-title"><i class="fa-regular fa-id-badge"></i> Identité</h2>
                <p class="form-page__card-desc">Coordonnées du client.</p>
            </div>

            <div class="form-page__grid">
                <div class="form-field">
                    <label for="name" class="form-field__label">Nom <span class="req">*</span></label>
                    <input type="text" name="name" id="name" value="{{ $user->name }}" placeholder="Nom du client" required>
                </div>

                <div class="form-field">
                    <label for="email" class="form-field__label">Email <span class="req">*</span></label>
                    <input type="text" name="email" id="email" value="{{ $user->email }}" required placeholder="Email du client">
                </div>
            </div>
        </div>

        <div class="form-page__card">
            <div class="form-page__card-head">
                <h2 class="form-page__card-title"><i class="fa-solid fa-key"></i> Mot de passe</h2>
                <p class="form-page__card-desc">Envoyez un e-mail permettant au client de définir ou réinitialiser son mot de passe.</p>
            </div>

            <div class="form-page__inline-action">
                <button type="submit" form="providerUserResetForm" class="btn-default">
                    <span class="btn-loader"></span>
                    <span class="btn-text"><i class="fa-regular fa-paper-plane"></i> Envoyer le lien de création / réinitialisation</span>
                </button>
            </div>
        </div>

        <div class="form-page__footer">
            <a href="{{ route('provider.users.delete', ['user' => $user->id]) }}" class="btn-delete confirm-delete">Supprimer</a>
            <a wire:navigate href="{{ route('provider.users') }}" class="btn-default">Annuler</a>
            <button type="submit" class="btn-primary">
                <span class="btn-loader"></span>
                <span class="btn-text">Mettre à jour</span>
            </button>
        </div>
    </form>

    <form id="providerUserResetForm" action="{{ route('provider.users.sendReset', $user) }}" method="POST" hidden>
        @csrf
    </form>
</x-form-page>
