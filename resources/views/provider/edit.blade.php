<form method="POST" action="{{ route('providers.update', ['provider' => $provider->id]) }}" id="createFournisseurForm" class="form-modal">
    @csrf

    <h2 class="form-modal__title">Mettre à jour un fournisseur</h2>

    <div class="form-modal__body">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ $provider->name }}" required
                   placeholder="Nom du fournisseur">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ $provider->email }}"
                   placeholder="exemple@mail.com">
        </div>

        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
            <input type="text" name="phone" id="phone" value="{{ $provider->phone }}"
                   placeholder="+33 6 12 34 56 78">
        </div>

        <div>
            <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Commentaire</label>
            <textarea name="comment" id="comment" rows="3"
                      placeholder="Notes ou remarques...">{!! $provider->comment !!}</textarea>
        </div>

        <div>
            <label for="email_content" class="block text-sm font-medium text-gray-700 mb-1">Contenu de l'e-mail</label>
            <textarea name="email_content" id="email_content" rows="3"
                      placeholder="Contenu de l'e-mail...">{!! $provider->email_content !!}</textarea>
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
                    <button
                        type="button"
                        class="provider-prices-share-send"
                        id="sendProviderPricesLink"
                        data-url="{{ route('providers.send-prices-link', ['provider' => $provider->id]) }}"
                    >
                        <i class="fa-regular fa-envelope"></i> Envoyer le lien par e-mail
                    </button>
                @else
                    <p class="provider-prices-share-meta">Ajoutez un e-mail pour envoyer le lien au fournisseur.</p>
                @endif
            </div>
        @endif
    </div>

    @if (!Auth::user()->is_only_order)
        <div class="form-modal__footer">
            <a href="{{ route('providers.delete', ['provider' => $provider->id]) }}" class="btn-delete confirm-delete">Supprimer</a>
            <button type="button" class="btn-default close-modal-all">Annuler</button>
            <button type="submit" class="btn-primary">
                <span class="btn-loader"></span>
                <span class="btn-text">Mettre à jour</span>
            </button>
        </div>
    @endif
</form>

<script>
    (function () {
        var copyBtn = document.getElementById('copyProviderPricesUrl');
        var urlInput = document.getElementById('providerPricesUrl');

        if (copyBtn && urlInput) {
            copyBtn.addEventListener('click', function () {
                urlInput.select();
                urlInput.setSelectionRange(0, 99999);
                navigator.clipboard.writeText(urlInput.value).then(function () {
                    copyBtn.innerHTML = '<i class="fa-solid fa-check"></i> Copié';
                    setTimeout(function () {
                        copyBtn.innerHTML = '<i class="fa-regular fa-copy"></i> Copier';
                    }, 2000);
                });
            });
        }

        var sendBtn = document.getElementById('sendProviderPricesLink');
        var form = document.getElementById('createFournisseurForm');

        if (sendBtn && form) {
            sendBtn.addEventListener('click', function () {
                if (!confirm('Envoyer le lien de mise à jour des tarifs par e-mail ?')) {
                    return;
                }

                var token = form.querySelector('input[name="_token"]').value;

                fetch(sendBtn.dataset.url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html',
                    },
                    body: '_token=' + encodeURIComponent(token),
                }).then(function (response) {
                    if (response.redirected) {
                        window.location.href = response.url;
                    }
                });
            });
        }
    })();
</script>
