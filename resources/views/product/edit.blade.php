<x-form-page
    :back="route('products')"
    eyebrow="Produits"
    :title="$product->name"
    subtitle="Modifiez les caractéristiques de ce produit."
    icon="fa-regular fa-lemon"
>
    <form method="POST" action="{{ route('products.update', ['product' => $product->id]) }}" class="form-page__form">
        @csrf

        <div class="form-page__card">
            <div class="form-page__card-head">
                <h2 class="form-page__card-title"><i class="fa-solid fa-cube"></i> Informations</h2>
                <p class="form-page__card-desc">Nom du produit, unité de mesure et fournisseur associé.</p>
            </div>

            <div class="form-page__grid">
                <div class="form-field form-field--full">
                    <label for="name" class="form-field__label">Nom <span class="req">*</span></label>
                    <input type="text" name="name" id="name" value="{{ $product->name }}" required placeholder="Nom du produit">
                </div>

                <div class="form-field">
                    <label for="unity_id" class="form-field__label">Unité</label>
                    <select name="unity_id" id="unity_id" required>
                        <option value="">Choisir l'unité</option>
                        @foreach($unities as $unity)
                            <option value="{{ $unity->id }}" {{ $product->unity_id == $unity->id ? 'selected' : '' }}>{{ $unity->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-field">
                    <label for="provider_id" class="form-field__label">Fournisseur</label>
                    <select name="provider_id" id="provider_id" required>
                        <option value="">Choisir un fournisseur</option>
                        @foreach($providers as $provider)
                            <option value="{{ $provider->id }}" {{ $product->provider_id == $provider->id ? 'selected' : '' }}>{{ $provider->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="form-page__card">
            <div class="form-page__card-head">
                <h2 class="form-page__card-title"><i class="fa-solid fa-sliders"></i> Commande &amp; tarif</h2>
                <p class="form-page__card-desc">Paramètres de quantité, prix unitaire et stock du produit.</p>
            </div>

            <div class="form-page__grid">
                <div class="form-field">
                    <label for="quantity_min" class="form-field__label">Quantité minimum</label>
                    <input type="number" name="quantity_min" id="quantity_min" value="{{ $product->quantity_min }}" placeholder="0">
                </div>

                <div class="form-field">
                    <label for="quantity_step" class="form-field__label">Quantité étape</label>
                    <input type="number" name="quantity_step" id="quantity_step" value="{{ $product->quantity_step }}" placeholder="1">
                    <p class="form-field__hint">L'ajout de quantité se fera par tranche de ce nombre.</p>
                </div>

                <div class="form-field">
                    <label for="price" class="form-field__label">Prix unitaire</label>
                    <input type="number" name="price" id="price" step="0.01" value="{{ $product->price ? $product->price / 100 : '' }}" placeholder="0,00">
                </div>

                @if (!Auth::user()->is_only_order)
                    @if ($product->provider?->is_stock)
                        @include('product.stock')
                    @endif
                @endif
            </div>
        </div>

        @if (!Auth::user()->is_only_order)
            <div class="form-page__footer">
                <a href="{{ route('products.delete', ['product' => $product->id]) }}" class="btn-delete confirm-delete">Supprimer</a>
                <a wire:navigate href="{{ route('products') }}" class="btn-default">Annuler</a>
                <button type="submit" class="btn-primary">
                    <span class="btn-loader"></span>
                    <span class="btn-text">Mettre à jour</span>
                </button>
            </div>
        @endif
    </form>
</x-form-page>
