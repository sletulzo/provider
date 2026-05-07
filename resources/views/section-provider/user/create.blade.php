<form method="POST" action="{{ route('provider.users.store') }}" class="form-modal">
    @csrf

    <h2 class="text-lg font-semibold text-gray-800">Créer un client</h2>

    <!-- Nom -->
    <div>
        <label for="name">Nom <span class="text-red-500">*</span></label>
        <input type="text" name="name" id="name" placeholder="Nom du client" required>
    </div>

    <!-- Email -->
    <div>
        <label for="email">Email <span class="text-red-500">*</span></label>
        <input type="text" name="email" id="email" required placeholder="Email du client">
    </div>

    <!-- Boutons -->
    <div class="flex justify-end pt-2">
        <button type="button" class="btn-default close-modal-up m-r-10">Annuler</button>
        <button type="submit" class="btn-primary">
            <span class="btn-loader"></span>
            <span class="btn-text">Enregistrer</span>
        </button>
    </div>
</form>
