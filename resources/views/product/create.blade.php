<x-form-page
    :back="route('products')"
    eyebrow="Produits"
    title="Nouveau produit"
    subtitle="Ajoutez un produit à votre catalogue pour pouvoir le commander."
    icon="fa-regular fa-lemon"
>
    <form method="POST" action="{{ route('products.store') }}" class="form-page__form">
        @csrf

        <div class="form-page__card">
            <div class="form-page__card-head">
                <h2 class="form-page__card-title"><i class="fa-solid fa-cube"></i> Informations</h2>
                <p class="form-page__card-desc">Nom du produit, unité de mesure et fournisseur associé.</p>
            </div>

            <div class="form-page__grid">
                <div class="form-field form-field--full">
                    <label for="name" class="form-field__label">Nom <span class="req">*</span></label>
                    <input type="text" name="name" id="name" required placeholder="Nom du produit">
                </div>

                <div class="form-field">
                    <label for="unity_id" class="form-field__label">Unité <span class="req">*</span></label>
                    <select name="unity_id" id="unity_id" required>
                        <option value="">Choisir l'unité</option>
                        @foreach($unities as $unity)
                            <option value="{{ $unity->id }}">{{ $unity->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-field">
                    <label for="provider_id" class="form-field__label">Fournisseur <span class="req">*</span></label>
                    <select name="provider_id" id="provider_id" required>
                        <option value="">Choisir un fournisseur</option>
                        @foreach($providers as $provider)
                            <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="form-page__card">
            <div class="form-page__card-head">
                <h2 class="form-page__card-title"><i class="fa-solid fa-sliders"></i> Commande &amp; tarif</h2>
                <p class="form-page__card-desc">Paramètres de quantité et prix unitaire du produit.</p>
            </div>

            <div class="form-page__grid">
                <div class="form-field">
                    <label for="quantity_min" class="form-field__label">Quantité minimum</label>
                    <input type="number" name="quantity_min" id="quantity_min" placeholder="0">
                </div>

                <div class="form-field">
                    <label for="quantity_step" class="form-field__label">Quantité étape</label>
                    <input type="number" name="quantity_step" id="quantity_step" placeholder="1">
                    <p class="form-field__hint">L'ajout de quantité se fera par tranche de ce nombre.</p>
                </div>

                <div class="form-field">
                    <label for="price" class="form-field__label">Prix unitaire</label>
                    <input type="number" name="price" id="price" step="0.01" placeholder="0,00">
                </div>
            </div>
        </div>

        <div class="form-page__footer">
            <a wire:navigate href="{{ route('products') }}" class="btn-default">Annuler</a>
            <button type="submit" class="btn-primary">
                <span class="btn-loader"></span>
                <span class="btn-text">Enregistrer le produit</span>
            </button>
        </div>
    </form>
</x-form-page>
