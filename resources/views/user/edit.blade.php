<form method="POST" action="{{ route('users.update', ['user' => $user->id]) }}" class="space-y-5">
    @csrf

    <h2 class="text-lg font-semibold text-gray-800">Créer un utilisateur</h2>

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

    <!-- Boutons -->
    <div class="flex justify-end pt-2">
        <button type="button"
                class="close-modal px-4 py-2 text-sm text-gray-600 hover:text-gray-800 rounded-lg transition">
            Annuler
        </button>
        <button type="submit"
                class="ml-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition">
            Enregistrer
        </button>
    </div>
</form>
