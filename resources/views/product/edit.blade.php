<form method="POST" action="{{ route('products.update', ['product' => $product->id]) }}" id="createFournisseurForm" class="space-y-5">
    @csrf

    <h2 class="text-lg font-semibold text-gray-800">Modifier le produit</h2>

    <!-- Nom -->
    <div>
        <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
        <input type="text" name="name" id="name" value="{{ $product->name }}" required
               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
               placeholder="Nom du produit">
    </div>

    <!-- Email -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Unité</label>
        <select class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" name="unity_id" required>
            <option value="">Choisir l'unité</option>
            @foreach($unities as $unity)
                <option value="{{ $unity->id }}" {{ $product->unity_id == $unity->id ? 'selected' : '' }}>{{ $unity->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Téléphone -->
    <div>
        <label for="telephone" class="block text-sm font-medium text-gray-700 mb-1">Fournisseur</label>
        <select class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" name="provider_id" required>
            <option value="">Choisir un fournisseur</option>
            @foreach($providers as $provider)
                <option value="{{ $provider->id }}" {{ $product->provider_id == $provider->id ? 'selected' : '' }}>{{ $provider->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Boutons -->
    <div class="flex justify-end pt-2">
        <button type="button"
                class="close-modal px-4 py-2 text-sm text-gray-600 hover:text-gray-800 rounded-lg transition">
            Annuler
        </button>
        <button type="submit"
                class="ml-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition">
            Enregistrer
        </button>
    </div>
</form>
