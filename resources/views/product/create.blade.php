<form method="POST" action="{{ route('products.store') }}" id="createFournisseurForm" class="space-y-5">
    @csrf

    <h2 class="text-lg font-semibold text-gray-800">Créer un produit</h2>

    <!-- Nom -->
    <div>
        <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
        <input type="text" name="name" id="name" required
               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
               placeholder="Nom du produit">
    </div>

    <!-- Email -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Unité <span class="text-red-500">*</span></label>
        <select class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" name="unity_id" required>
            <option value="">Choisir l'unité</option>
            @foreach($unities as $unity)
                <option value="{{ $unity->id }}">{{ $unity->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Téléphone -->
    <div>
        <label for="telephone" class="block text-sm font-medium text-gray-700 mb-1">Fournisseur <span class="text-red-500">*</span></label>
        <select class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" name="provider_id" required>
            <option value="">Choisir un fournisseur</option>
            @foreach($providers as $provider)
                <option value="{{ $provider->id }}">{{ $provider->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Quantity -->
    <div class="flex" style="gap: 10px">
        <div class="col-6">
            <label for="quantity_min" class="block text-sm font-medium text-gray-700 mb-1">Quantité minimum</label>
            <input type="number" name="quantity_min" id="quantity_min"
               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
               placeholder="Quantité minimum">
        </div>
        <div class="col-6">
            <label for="quantity_step" class="block text-sm font-medium text-gray-700 mb-1">Quantité étape</label>
            <input type="number" name="quantity_step" id="quantity_step"
               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
               placeholder="L'ajout de quantité se fera par ce nombre">
        </div>
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
