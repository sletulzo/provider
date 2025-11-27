<form method="POST" action="{{ route('tenants.store') }}" class="space-y-5">
    @csrf

    <h2 class="text-lg font-semibold text-gray-800">Créer une société</h2>

    <!-- Nom -->
    <div>
        <label for="name">Nom <span class="text-red-500">*</span></label>
        <input type="text" name="name" id="name" placeholder="Nom de la société" required>
    </div>

    <!-- Domaine -->
    <div>
        <label for="email">Domaine</label>
        <input type="text" name="domain" id="domain" placeholder="Domaine">
    </div>

    <label class="toggle-field">
        <div class="toggle-wrapper">
            <input type="checkbox" id="notify-toggle" class="toggle-input" name="is_locked">
            <span class="toggle-label">
                <span class="toggle-ball"></span>
            </span>
        </div>
        <span class="toggle-text">Agence bloquée</span>
    </label>

    <!-- Boutons -->
    <div class="flex justify-end pt-2">
        <button type="button"
                class="close-modal px-4 py-2 text-sm text-gray-600 hover:text-gray-800 rounded-lg transition">
            Annuler
        </button>
        <button type="submit"
                class="btn-primary">
            Enregistrer
        </button>
    </div>
</form>
