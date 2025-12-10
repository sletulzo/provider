<form method="POST" action="{{ route('users.update', ['user' => $user->id]) }}" class="form-modal">
    @csrf

    <h2 class="text-lg font-semibold text-gray-800">Modifier un utilisateur</h2>

    <!-- Nom -->
    <div>
        <label for="name">Nom <span class="text-red-500">*</span></label>
        <input type="text" name="name" id="name" value="{{ $user->name }}" placeholder="Nom de l'utilisateur" required>
    </div>

    <!-- Email -->
    <div>
        <label for="email">Email <span class="text-red-500">*</span></label>
        <input type="text" name="email" id="email" value="{{ $user->email }}" required placeholder="Email de l'utilisateur">
    </div>

    <!-- Tenant -->
    <div>
        <label for="tenant_id">Société <span class="text-red-500">*</span></label>
        <select class="form-control" id="tenant_id" name="tenant_id" required>
            <option value="">Choisir dans la liste</option>
            @foreach($tenants as $tenant)
                <option value="{{ $tenant->id }}" {{ $user->tenant_id == $tenant->id ? 'selected' : '' }}>{{ $tenant->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Boutons -->
    <div class="flex justify-end pt-2">
        <a href="{{ route('users.delete', ['user' => $user->id]) }}" class="btn-delete m-r-auto confirm-delete">
            <i class="fa-regular fa-trash-can"></i>
        </a>
        <button type="button" class="btn-default close-modal-up m-r-10">Annuler</button>
        <button type="submit" class="btn-primary">
            <span class="btn-loader"></span>
            <span class="btn-text">Mettre à jour</span>
        </button>
    </div>
</form>

<div class="flex justify-center" style="margin-top: -75px;">
    <form action="{{ route('users.sendReset', $user) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">
            <span class="btn-loader"></span>
            <span class="btn-text">Envoyer lien de création / reset mot de passe</span>
        </button>
    </form>
</div>