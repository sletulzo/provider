<form method="POST" action="{{ route('unities.update', ['unity' => $unity->id]) }}" id="createFournisseurForm" class="form-modal">
    @csrf

    <h2 class="form-modal__title">Modifier l'unité</h2>

    <div class="form-modal__body">
        <div>
            <label for="name">Nom <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ $unity->name }}" required placeholder="Nom de l'unité">
        </div>
    </div>

    @if (!Auth::user()->is_only_order)
        <div class="form-modal__footer">
            <a href="{{ route('unities.delete', ['unity' => $unity->id]) }}" class="btn-delete confirm-delete">Supprimer</a>
            <button type="button" class="btn-default close-modal-all">Annuler</button>
            <button type="submit" class="btn-primary">
                <span class="btn-loader"></span>
                <span class="btn-text">Mettre à jour</span>
            </button>
        </div>
    @endif
</form>
