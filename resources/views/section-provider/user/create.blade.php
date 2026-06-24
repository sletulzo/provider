<x-form-page
    :back="route('provider.users')"
    eyebrow="Clients"
    title="Nouveau client"
    subtitle="Ajoutez un client pouvant passer commande auprès de vous."
    icon="fa-regular fa-circle-user"
>
    <form method="POST" action="{{ route('provider.users.store') }}" class="form-page__form">
        @csrf

        <div class="form-page__card">
            <div class="form-page__card-head">
                <h2 class="form-page__card-title"><i class="fa-regular fa-id-badge"></i> Identité</h2>
                <p class="form-page__card-desc">Coordonnées du client.</p>
            </div>

            <div class="form-page__grid">
                <div class="form-field">
                    <label for="name" class="form-field__label">Nom <span class="req">*</span></label>
                    <input type="text" name="name" id="name" placeholder="Nom du client" required>
                </div>

                <div class="form-field">
                    <label for="email" class="form-field__label">Email <span class="req">*</span></label>
                    <input type="text" name="email" id="email" required placeholder="Email du client">
                </div>
            </div>
        </div>

        <div class="form-page__footer">
            <a wire:navigate href="{{ route('provider.users') }}" class="btn-default">Annuler</a>
            <button type="submit" class="btn-primary">
                <span class="btn-loader"></span>
                <span class="btn-text">Créer le client</span>
            </button>
        </div>
    </form>
</x-form-page>
