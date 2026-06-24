<x-form-page
    :back="route('providers')"
    eyebrow="Fournisseurs"
    :title="$provider->name"
    subtitle="Modifiez les informations de ce fournisseur."
    icon="fa-solid fa-truck"
>
    <form method="POST" action="{{ route('providers.update', ['provider' => $provider->id]) }}" id="providerForm" class="form-page__form">
        @csrf

        <div class="form-page__card">
            <div class="form-page__card-head">
                <h2 class="form-page__card-title"><i class="fa-regular fa-address-card"></i> Coordonnées</h2>
                <p class="form-page__card-desc">Identité et moyens de contact du fournisseur.</p>
            </div>

            <div class="form-page__grid">
                <div class="form-field form-field--full">
                    <label for="name" class="form-field__label">Nom <span class="req">*</span></label>
                    <input type="text" name="name" id="name" value="{{ $provider->name }}" required placeholder="Nom du fournisseur">
                </div>

                <div class="form-field">
                    <label for="email" class="form-field__label">Email</label>
                    <input type="email" name="email" id="email" value="{{ $provider->email }}" placeholder="exemple@mail.com">
                </div>

                <div class="form-field">
                    <label for="phone" class="form-field__label">Téléphone</label>
                    <input type="text" name="phone" id="phone" value="{{ $provider->phone }}" placeholder="+33 6 12 34 56 78">
                </div>

                <div class="form-field">
                    <label for="shipping_cost" class="form-field__label">Frais de port</label>
                    <input
                        type="number"
                        name="shipping_cost"
                        id="shipping_cost"
                        min="0"
                        step="0.01"
                        inputmode="decimal"
                        value="{{ number_format(($provider->shipping_cost ?? 0) / 100, 2, '.', '') }}"
                        placeholder="0,00"
                    >
                    <p class="form-field__hint">Ajoutés automatiquement au total des commandes.</p>
                </div>
            </div>
        </div>

        <div class="form-page__card">
            <div class="form-page__card-head">
                <h2 class="form-page__card-title"><i class="fa-regular fa-comment-dots"></i> Communication</h2>
                <p class="form-page__card-desc">Textes affichés pendant la commande et dans l'e-mail envoyé au fournisseur.</p>
            </div>

            <div class="form-page__grid">
                <div class="form-field form-field--full">
                    <label for="comment" class="form-field__label">Description fournisseur</label>
                    <textarea name="comment" id="comment" rows="3" placeholder="Infos visibles pendant la commande...">{!! $provider->comment !!}</textarea>
                </div>

                <div class="form-field form-field--full">
                    <label for="email_content" class="form-field__label">Contenu de l'e-mail</label>
                    <textarea name="email_content" id="email_content" rows="3" placeholder="Contenu de l'e-mail...">{!! $provider->email_content !!}</textarea>
                </div>
            </div>
        </div>

        <div class="form-page__card">
            <div class="form-page__card-head">
                <h2 class="form-page__card-title"><i class="fa-solid fa-boxes-stacked"></i> Gestion des stocks</h2>
                <p class="form-page__card-desc">Activez le suivi des quantités disponibles pour ce fournisseur.</p>
            </div>

            <label class="toggle-field">
                <div class="toggle-wrapper">
                    <input type="checkbox" id="is_stock" class="toggle-input" name="is_stock" {{ $provider->is_stock ? 'checked' : '' }}>
                    <span class="toggle-label">
                        <span class="toggle-ball"></span>
                    </span>
                </div>
                <span class="toggle-text">Activer la gestion des stocks</span>
            </label>
        </div>

        @if (!Auth::user()->is_only_order)
            <div class="form-page__card">
                <div class="form-page__card-head">
                    <h2 class="form-page__card-title"><i class="fa-solid fa-tags"></i> Tarifs fournisseur</h2>
                    <p class="form-page__card-desc">
                        Partagez ce lien sécurisé pour que le fournisseur mette à jour ses prix.
                        Lien valable 30 jours.
                        @if ($provider->prices_updated_at)
                            Dernière mise à jour : {{ $provider->prices_updated_at->format('d/m/Y à H:i') }}.
                        @else
                            Aucune mise à jour enregistrée pour le moment.
                        @endif
                    </p>
                </div>

                <div class="provider-prices-share-row">
                    <input type="text" id="providerPricesUrl" value="{{ $pricesUrl }}" readonly>
                    <button type="button" class="provider-prices-share-copy" id="copyProviderPricesUrl" data-target="providerPricesUrl">
                        <i class="fa-regular fa-copy"></i> Copier
                    </button>
                </div>

                @if ($provider->email)
                    <button
                        type="button"
                        class="provider-prices-share-send"
                        id="sendProviderPricesLink"
                        data-url="{{ route('providers.send-prices-link', ['provider' => $provider->id]) }}"
                        data-form="providerForm"
                    >
                        <i class="fa-regular fa-envelope"></i> Envoyer le lien par e-mail
                    </button>
                @else
                    <p class="provider-prices-share-meta">Ajoutez un e-mail pour pouvoir envoyer le lien au fournisseur.</p>
                @endif
            </div>
        @endif

        @if (!Auth::user()->is_only_order)
            <div class="form-page__footer">
                <a href="{{ route('providers.delete', ['provider' => $provider->id]) }}" class="btn-delete confirm-delete">Supprimer</a>
                <a wire:navigate href="{{ route('providers') }}" class="btn-default">Annuler</a>
                <button type="submit" class="btn-primary">
                    <span class="btn-loader"></span>
                    <span class="btn-text">Mettre à jour</span>
                </button>
            </div>
        @endif
    </form>
</x-form-page>
