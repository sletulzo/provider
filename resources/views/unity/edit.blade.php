<x-form-page
    :back="route('unities')"
    eyebrow="Unités de produit"
    :title="$unity->name"
    subtitle="Modifiez cette unité de mesure."
    icon="fa-regular fa-lightbulb"
>
    <form method="POST" action="{{ route('unities.update', ['unity' => $unity->id]) }}" class="form-page__form">
        @csrf

        <div class="form-page__card">
            <div class="form-page__grid">
                <div class="form-field form-field--full">
                    <label for="name" class="form-field__label">Nom <span class="req">*</span></label>
                    <input type="text" name="name" id="name" value="{{ $unity->name }}" required placeholder="Nom de l'unité (kg, litre, pièce...)">
                </div>
            </div>
        </div>

        @if (!Auth::user()->is_only_order)
            <div class="form-page__footer">
                <a href="{{ route('unities.delete', ['unity' => $unity->id]) }}" class="btn-delete confirm-delete">Supprimer</a>
                <a wire:navigate href="{{ route('unities') }}" class="btn-default">Annuler</a>
                <button type="submit" class="btn-primary">
                    <span class="btn-loader"></span>
                    <span class="btn-text">Mettre à jour</span>
                </button>
            </div>
        @endif
    </form>
</x-form-page>
