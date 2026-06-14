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

    <label class="toggle-field">
        <div class="toggle-wrapper">
            <input type="checkbox" id="notify-toggle" class="toggle-input" name="is_stock" {{ $provider->is_stock ? 'checked' : '' }}>
            <span class="toggle-label">
                <span class="toggle-ball"></span>
            </span>
        </div>
        <span class="toggle-text">Activer la gestion des stocks</span>
    </label>

    @if (!Auth::user()->is_only_order)
        <div class="provider-prices-share">
            <span class="provider-prices-share-label"><i class="fa-solid fa-tags"></i> Tarifs fournisseur</span>
            <div class="provider-prices-share-row">
                <input type="text" id="providerPricesUrl" value="{{ $pricesUrl }}" readonly>
                <button type="button" class="provider-prices-share-copy" id="copyProviderPricesUrl">
                    <i class="fa-regular fa-copy"></i> Copier
                </button>
            </div>
            <p class="provider-prices-share-meta">
                Lien valable 30 jours.
                @if ($provider->prices_updated_at)
                    Dernière mise à jour : {{ $provider->prices_updated_at->format('d/m/Y à H:i') }}.
                @else
                    Aucune mise à jour enregistrée pour le moment.
                @endif
            </p>
            @if ($provider->email)
                <form method="POST" action="{{ route('providers.send-prices-link', ['provider' => $provider->id]) }}" class="provider-prices-share-send-form">
                    @csrf
                    <button type="submit" class="provider-prices-share-send">
                        <i class="fa-regular fa-envelope"></i> Envoyer le lien par e-mail
                    </button>
                </form>
            @else
                <p class="provider-prices-share-meta">Ajoutez un e-mail pour envoyer le lien au fournisseur.</p>
            @endif
        </div>

        <script>
            (function () {
                var btn = document.getElementById('copyProviderPricesUrl');
                var input = document.getElementById('providerPricesUrl');
                if (!btn || !input) return;
                btn.addEventListener('click', function () {
                    input.select();
                    input.setSelectionRange(0, 99999);
                    navigator.clipboard.writeText(input.value).then(function () {
                        btn.innerHTML = '<i class="fa-solid fa-check"></i> Copié';
                        setTimeout(function () {
                            btn.innerHTML = '<i class="fa-regular fa-copy"></i> Copier';
                        }, 2000);
                    });
                });
            })();
        </script>
    @endif

    <!-- Boutons -->
    @if (!Auth::user()->is_only_order)
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
    @endif
</form>
