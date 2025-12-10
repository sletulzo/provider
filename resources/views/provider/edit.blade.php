<form method="POST" action="{{ route('providers.update', ['provider' => $provider->id]) }}" id="createFournisseurForm" class="form-modal">
    @csrf

    <h2 class="text-lg font-semibold text-gray-800">Mettre à jour un fournisseur</h2>

    <!-- Nom -->
    <div>
        <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
        <input type="text" name="name" id="name" value="{{ $provider->name }}" required
               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
               placeholder="Nom du fournisseur">
    </div>

    <!-- Email -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" name="email" id="email" value="{{ $provider->email }}"
               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
               placeholder="exemple@mail.com">
    </div>

    <!-- Téléphone -->
    <div>
        <label for="telephone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
        <input type="text" name="phone" id="phone" value="{{ $provider->phone }}"
               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
               placeholder="+33 6 12 34 56 78">
    </div>

    <!-- Commentaire -->
    <div>
        <label for="commentaire" class="block text-sm font-medium text-gray-700 mb-1">Commentaire</label>
        <textarea name="comment" id="comment" rows="3"
                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                  placeholder="Notes ou remarques...">{!! $provider->comment !!}</textarea>
    </div>

    <div>
        <label for="commentaire" class="block text-sm font-medium text-gray-700 mb-1">Contenu de l'email</label>
        <textarea name="email_content" id="email_content" rows="3"
                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                  placeholder="Contenu de l'email...">{!! $provider->email_content !!}</textarea>
    </div>

    <!-- Boutons -->
    <div class="flex justify-end pt-2">
        <a href="{{ route('providers.delete', ['provider' => $provider->id]) }}" class="btn-delete m-r-auto confirm-delete">
            <i class="fa-regular fa-trash-can"></i>
        </a>
        <button type="button" class="btn-default close-modal-up m-r-10">Annuler</button>
        <button type="submit" class="btn-primary">
            <span class="btn-loader"></span>
            <span class="btn-text">Mettre à jour</span>
        </button>
    </div>
</form>
