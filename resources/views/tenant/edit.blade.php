<form method="POST" action="{{ route('tenants.update', ['tenant' => $tenant->id]) }}" class="form-modal">
    @csrf

    <h2 class="text-lg font-semibold text-gray-800">Modifier la société</h2>

    <!-- Nom -->
    <div>
        <label for="name">Nom <span class="text-red-500">*</span></label>
        <input type="text" name="name" id="name" value="{{ $tenant->name }}" placeholder="Nom de la société" required>
    </div>

    <!-- Adress -->
    <div>
        <label for="name">Adresse <span class="text-red-500">*</span></label>
        <input type="text" name="adress" id="adress" value="{{ $tenant->adress }}" placeholder="Adresse de la société" required>
    </div>

    <!-- Email -->
    <div>
        <label for="email">Email <span class="text-red-500">*</span></label>
        <input type="text" name="email" id="email" value="{{ $tenant->smtp_email }}" placeholder="Email" required>
    </div>

    <!-- Mot de passe -->
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
        <span class="toggle-text">Agence bloquée</span>
    </label>

    <!-- Boutons -->
    <div class="flex justify-end pt-2">
        <a href="{{ route('tenants.delete', ['tenant' => $tenant->id]) }}" class="btn-delete m-r-auto confirm-delete">
            <i class="fa-regular fa-trash-can"></i>
        </a>
        <button type="button" class="btn-default close-modal-up m-r-10">Annuler</button>
        <button type="submit" class="btn-primary">
            <span class="btn-loader"></span>
            <span class="btn-text">Mettre à jour</span>
        </button>
    </div>
</form>
