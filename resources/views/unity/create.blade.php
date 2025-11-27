<form method="POST" action="{{ route('unities.store') }}" id="createFournisseurForm" class="space-y-5">
    @csrf

    <h2 class="text-lg font-semibold text-gray-800">Créer une unité</h2>

    <!-- Nom -->
    <div>
        <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
        <input type="text" name="name" id="name" required
               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
               placeholder="Nom de l'unité">
    </div>

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
