<x-form-page
    :back="route('unities')"
    eyebrow="Unités de produit"
    title="Nouvelle unité"
    subtitle="Définissez une unité de mesure utilisable par vos produits."
    icon="fa-regular fa-lightbulb"
>
    <form method="POST" action="{{ route('unities.store') }}" class="form-page__form">
        @csrf

        <div class="form-page__card">
            <div class="form-page__grid">
                <div class="form-field form-field--full">
                    <label for="name" class="form-field__label">Nom <span class="req">*</span></label>
                    <input type="text" name="name" id="name" required placeholder="Nom de l'unité (kg, litre, pièce...)">
                </div>
            </div>
        </div>

        <div class="form-page__footer">
            <a wire:navigate href="{{ route('unities') }}" class="btn-default">Annuler</a>
            <button type="submit" class="btn-primary">
                <span class="btn-loader"></span>
                <span class="btn-text">Enregistrer l'unité</span>
            </button>
        </div>
    </form>
</x-form-page>
