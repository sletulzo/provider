<form method="POST" action="{{ route('users.update', ['user' => $user->id]) }}" class="form-modal">
    @csrf

    <h2 class="form-modal__title">Modifier un utilisateur</h2>

    <div class="form-modal__body">
        <div>
            <label for="name">Nom <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ $user->name }}" placeholder="Nom de l'utilisateur" required>
        </div>

        <div>
            <label for="email">Email <span class="text-red-500">*</span></label>
            <input type="text" name="email" id="email" value="{{ $user->email }}" required placeholder="Email de l'utilisateur">
        </div>

        <div>
            <label for="user_type_id">Groupe utilisateur <span class="text-red-500">*</span></label>
            <select class="form-control" id="user_type_id" name="user_type_id" required>
                <option value="">Choisir dans la liste</option>
                @foreach($userTypes as $userType)
                    <option value="{{ $userType->id }}" {{ $user->user_type_id == $userType->id ? 'selected' : '' }}>{{ $userType->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="tenant_id">Société <span class="text-red-500">*</span></label>
            <select class="form-control" id="tenant_id" name="tenant_id" required>
                <option value="">Choisir dans la liste</option>
                @foreach($tenants as $tenant)
                    <option value="{{ $tenant->id }}" {{ $user->tenant_id == $tenant->id ? 'selected' : '' }}>{{ $tenant->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-modal__secondary">
            <button type="submit" form="userResetForm" class="btn-default">
                <span class="btn-loader"></span>
                <span class="btn-text"><i class="fa-regular fa-paper-plane"></i> Envoyer lien de création / reset mot de passe</span>
            </button>
        </div>
    </div>

    <div class="form-modal__footer">
        <a href="{{ route('users.delete', ['user' => $user->id]) }}" class="btn-delete confirm-delete">Supprimer</a>
        <button type="button" class="btn-default close-modal-all">Annuler</button>
        <button type="submit" class="btn-primary">
            <span class="btn-loader"></span>
            <span class="btn-text">Mettre à jour</span>
        </button>
    </div>
</form>

<form id="userResetForm" action="{{ route('users.sendReset', $user) }}" method="POST" hidden>
    @csrf
</form>
