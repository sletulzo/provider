<form method="POST" action="{{ route('products.update', ['product' => $product->id]) }}" id="createFournisseurForm" class="form-modal">
    @csrf

    <h2 class="form-modal__title">Modifier le produit</h2>

    <div class="form-modal__body">
        <div>
            <label for="name">Nom <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ $product->name }}" required placeholder="Nom du produit">
        </div>

        <div>
            <label for="unity_id">Unité</label>
            <select name="unity_id" id="unity_id" required>
                <option value="">Choisir l'unité</option>
                @foreach($unities as $unity)
                    <option value="{{ $unity->id }}" {{ $product->unity_id == $unity->id ? 'selected' : '' }}>{{ $unity->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="provider_id">Fournisseur</label>
            <select name="provider_id" id="provider_id" required>
                <option value="">Choisir un fournisseur</option>
                @foreach($providers as $provider)
                    <option value="{{ $provider->id }}" {{ $product->provider_id == $provider->id ? 'selected' : '' }}>{{ $provider->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex" style="gap: 10px">
            <div class="col-6">
                <label for="quantity_min">Quantité minimum</label>
                <input type="number" name="quantity_min" id="quantity_min" value="{{ $product->quantity_min }}" placeholder="Quantité minimum">
            </div>
            <div class="col-6">
                <label for="quantity_step">Quantité étape</label>
                <input type="number" name="quantity_step" id="quantity_step" value="{{ $product->quantity_step }}" placeholder="L'ajout de quantité se fera par ce nombre">
            </div>
        </div>

        <div>
            <label for="price">Prix unitaire</label>
            <input type="number" name="price" id="price" step="0.01" value="{{ $product->price ? $product->price / 100 : '' }}" placeholder="Prix du produit">
        </div>

        @if (!Auth::user()->is_only_order)
            @if ($product->provider?->is_stock)
                @include('product.stock')
            @endif
        @endif
    </div>

    @if (!Auth::user()->is_only_order)
        <div class="form-modal__footer">
            <a href="{{ route('products.delete', ['product' => $product->id]) }}" class="btn-delete confirm-delete">Supprimer</a>
            <button type="button" class="btn-default close-modal-all">Annuler</button>
            <button type="submit" class="btn-primary">
                <span class="btn-loader"></span>
                <span class="btn-text">Mettre à jour</span>
            </button>
        </div>
    @endif
</form>
