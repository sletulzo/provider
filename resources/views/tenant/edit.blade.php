<form method="POST" action="{{ route('tenants.update', ['tenant' => $tenant->id]) }}" class="form-modal">
    @csrf

    <h2 class="form-modal__title">Modifier la société</h2>

    <div class="form-modal__body">
        <div>
            <label for="name">Nom <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ $tenant->name }}" placeholder="Nom de la société" required>
        </div>

        <div>
            <label for="adress">Adresse <span class="text-red-500">*</span></label>
            <input type="text" name="adress" id="adress" value="{{ $tenant->adress }}" placeholder="Adresse de la société" required>
        </div>

        <div>
            <label for="email">Email <span class="text-red-500">*</span></label>
            <input type="text" name="email" id="email" value="{{ $tenant->smtp_email }}" placeholder="Email" required>
        </div>

        <div>
            <label for="smtp_password">Mot de passe <span class="text-red-500">*</span></label>
            <input type="text" name="smtp_password" id="smtp_password" value="{{ $tenant->smtp_password }}" placeholder="Mot de passe" required>
        </div>

        <label class="toggle-field">
            <div class="toggle-wrapper">
                <input type="checkbox" id="notify-toggle" class="toggle-input" name="is_locked" {{ $tenant->is_locked ? 'checked' : '' }}>
                <span class="toggle-label">
                    <span class="toggle-ball"></span>
                </span>
            </div>
            <span class="toggle-text">Société bloquée</span>
        </label>
    </div>

    <div class="form-modal__footer">
        <a href="{{ route('tenants.delete', ['tenant' => $tenant->id]) }}" class="btn-delete confirm-delete">Supprimer</a>
        <button type="button" class="btn-default close-modal-all">Annuler</button>
        <button type="submit" class="btn-primary">
            <span class="btn-loader"></span>
            <span class="btn-text">Mettre à jour</span>
        </button>
    </div>
</form>
