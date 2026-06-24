<x-form-page
    :back="route('tenants')"
    eyebrow="Sociétés"
    :title="$tenant->name"
    subtitle="Modifiez la société et sa configuration e-mail."
    icon="fa-regular fa-building"
>
    <form method="POST" action="{{ route('tenants.update', ['tenant' => $tenant->id]) }}" class="form-page__form">
        @csrf

        <div class="form-page__card">
            <div class="form-page__card-head">
                <h2 class="form-page__card-title"><i class="fa-solid fa-house-chimney-user"></i> Société</h2>
                <p class="form-page__card-desc">Coordonnées principales de la société.</p>
            </div>

            <div class="form-page__grid">
                <div class="form-field">
                    <label for="name" class="form-field__label">Nom <span class="req">*</span></label>
                    <input type="text" name="name" id="name" value="{{ $tenant->name }}" placeholder="Nom de la société" required>
                </div>

                <div class="form-field">
                    <label for="adress" class="form-field__label">Adresse <span class="req">*</span></label>
                    <input type="text" name="adress" id="adress" value="{{ $tenant->adress }}" placeholder="Adresse de la société" required>
                </div>
            </div>
        </div>

        <div class="form-page__card">
            <div class="form-page__card-head">
                <h2 class="form-page__card-title"><i class="fa-regular fa-envelope"></i> Configuration e-mail</h2>
                <p class="form-page__card-desc">Identifiants utilisés pour l'envoi des e-mails de la société.</p>
            </div>

            <div class="form-page__grid">
                <div class="form-field">
                    <label for="email" class="form-field__label">Email <span class="req">*</span></label>
                    <input type="text" name="email" id="email" value="{{ $tenant->smtp_email }}" placeholder="Email" required>
                </div>

                <div class="form-field">
                    <label for="smtp_password" class="form-field__label">Mot de passe <span class="req">*</span></label>
                    <input type="text" name="smtp_password" id="smtp_password" value="{{ $tenant->smtp_password }}" placeholder="Mot de passe" required>
                </div>
            </div>
        </div>

        <div class="form-page__card">
            <div class="form-page__card-head">
                <h2 class="form-page__card-title"><i class="fa-solid fa-lock"></i> Accès</h2>
                <p class="form-page__card-desc">Une société bloquée ne peut plus se connecter.</p>
            </div>

            <label class="toggle-field">
                <div class="toggle-wrapper">
                    <input type="checkbox" id="is_locked" class="toggle-input" name="is_locked" {{ $tenant->is_locked ? 'checked' : '' }}>
                    <span class="toggle-label">
                        <span class="toggle-ball"></span>
                    </span>
                </div>
                <span class="toggle-text">Société bloquée</span>
            </label>
        </div>

        <div class="form-page__footer">
            <a href="{{ route('tenants.delete', ['tenant' => $tenant->id]) }}" class="btn-delete confirm-delete">Supprimer</a>
            <a wire:navigate href="{{ route('tenants') }}" class="btn-default">Annuler</a>
            <button type="submit" class="btn-primary">
                <span class="btn-loader"></span>
                <span class="btn-text">Mettre à jour</span>
            </button>
        </div>
    </form>
</x-form-page>
