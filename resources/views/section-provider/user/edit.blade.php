<form method="POST" action="{{ route('provider.users.update', ['user' => $user->id]) }}" class="form-modal">
    @csrf

    <h2 class="form-modal__title">Modifier un client</h2>

    <div class="form-modal__body">
        <div>
            <label for="name">Nom <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ $user->name }}" placeholder="Nom du client" required>
        </div>

        <div>
            <label for="email">Email <span class="text-red-500">*</span></label>
            <input type="text" name="email" id="email" value="{{ $user->email }}" required placeholder="Email du client">
        </div>

        <div class="form-modal__secondary">
            <button type="submit" form="providerUserResetForm" class="btn-default">
                <span class="btn-loader"></span>
                <span class="btn-text"><i class="fa-regular fa-paper-plane"></i> Envoyer lien de création / reset mot de passe</span>
            </button>
        </div>
    </div>

    <div class="form-modal__footer">
        <a href="{{ route('provider.users.delete', ['user' => $user->id]) }}" class="btn-delete confirm-delete">Supprimer</a>
        <button type="button" class="btn-default close-modal-all">Annuler</button>
        <button type="submit" class="btn-primary">
            <span class="btn-loader"></span>
            <span class="btn-text">Mettre à jour</span>
        </button>
    </div>
</form>

<form id="providerUserResetForm" action="{{ route('provider.users.sendReset', $user) }}" method="POST" hidden>
    @csrf
</form>
