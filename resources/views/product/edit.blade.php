<form method="POST" action="{{ route('products.update', ['product' => $product->id]) }}" id="createFournisseurForm" class="form-modal" class="space-y-5">
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

     <!-- Quantity -->
    <div class="flex" style="gap: 10px">
        <div class="col-6">
            <label for="quantity_min" class="block text-sm font-medium text-gray-700 mb-1">Quantité minimum</label>
            <input type="number" name="quantity_min" id="quantity_min"
                value="{{ $product->quantity_min }}"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                placeholder="Quantité minimum">
        </div>
        <div class="col-6">
            <label for="quantity_step" class="block text-sm font-medium text-gray-700 mb-1">Quantité étape</label>
            <input type="number" name="quantity_step" id="quantity_step"
                value="{{ $product->quantity_step }}"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                placeholder="L'ajout de quantité se fera par ce nombre">
        </div>
    </div>

    <div>
        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Prix</label>
        <input type="number" name="price" id="price" step="0.01" value="{{ $product->price ? $product->price / 100 : '' }}"
               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
               placeholder="Prix du produit">
    </div>

    <!-- Boutons -->
    <div class="flex justify-end pt-2">
        <a href="{{ route('products.delete', ['product' => $product->id]) }}" class="btn-delete m-r-auto confirm-delete">
            <i class="fa-regular fa-trash-can"></i>
        </a>
        <button type="button" class="btn-default close-modal-up m-r-10">Annuler</button>
        <button type="submit" class="btn-primary">
            <span class="btn-loader"></span>
            <span class="btn-text">Mettre à jour</span>
        </button>
    </div>
</form>
