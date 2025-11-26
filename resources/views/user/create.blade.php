<form method="POST" action="{{ route('users.store') }}" class="space-y-5">
    @csrf

    <h2 class="text-lg font-semibold text-gray-800">Créer un utilisateur</h2>

    <!-- Nom -->
    <div>
        <label for="name">Nom <span class="text-red-500">*</span></label>
        <input type="text" name="name" id="name" placeholder="Nom de l'utilisateur" required>
    </div>

    <!-- Email -->
    <div>
        <label for="email">Email <span class="text-red-500">*</span></label>
        <input type="text" name="email" id="email" required placeholder="Email de l'utilisateur">
    </div>

    <!-- Tenant -->
    <div>
        <label for="tenant_id">Société <span class="text-red-500">*</span></label>
        <select class="form-control" id="tenant_id" name="tenant_id" required>
            <option value="">Choisir dans la liste</option>
            @foreach($tenants as $tenant)
                <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Boutons -->
    <div class="flex justify-end pt-2">
        <button type="button"
                class="close-modal px-4 py-2 text-sm text-gray-600 hover:text-gray-800 rounded-lg transition">
            Annuler
        </button>
        <button type="submit"
                class="btn-primary">
            Enregistrer
        </button>
    </div>
</form>
