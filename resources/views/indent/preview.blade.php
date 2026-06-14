@php
    $defaultContent = "Bonjour {$provider->name},\nMerci de préparer la commande suivante pour livraison selon vos tournées :";
    $defaultSubject = "Commande {$provider->tenant?->name} - " . \Carbon\Carbon::now()->format('d/m/Y');
@endphp

<form
    class="cart-v2 cart-v2--compose"
    method="POST"
    action="{{ route('indent.send', ['provider' => $provider->id]) }}"
>
    @csrf

    <div class="cart-v2__chrome" data-modal-drag-handle>
        <div class="cart-v2__drag">
            <span class="cart-v2__handle" aria-hidden="true"></span>
        </div>

        <div class="cart-v2__hero">
            <div class="cart-v2__hero-main">
                <div class="cart-v2__hero-icon">
                    <i class="fa-regular fa-envelope"></i>
                </div>
                <div class="cart-v2__hero-text">
                    <h2 class="cart-v2__hero-title">Envoyer la commande</h2>
                    <p class="cart-v2__hero-provider">{{ $provider->name }}</p>
                </div>
            </div>
            <button type="button" class="cart-v2__close close-modal-up" aria-label="Fermer">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="cart-v2__summary">
            <span class="cart-v2__pill">{{ $orderCount }} article{{ $orderCount > 1 ? 's' : '' }}</span>
            <span class="cart-v2__pill cart-v2__pill--accent">{{ price($cartTotal, 2) }} €</span>
        </div>
    </div>

    <div class="cart-v2__scroll">
        <div class="cart-v2__recipient">
            <div class="cart-v2__recipient-icon">
                <i class="fa-regular fa-envelope"></i>
            </div>
            <div class="cart-v2__recipient-info">
                <span class="cart-v2__recipient-label">Destinataire</span>
                <div class="cart-v2__recipient-name">{{ $provider->name }}</div>
                <div class="cart-v2__recipient-email">{{ $provider->email }}</div>
            </div>
        </div>

        <div class="cart-v2__mail-card">
            <div class="cart-v2__mail-card-head">
                <span class="cart-v2__mail-card-title">Nouvelle commande</span>
                <span class="cart-v2__mail-card-date">
                    <i class="fa-regular fa-calendar"></i>
                    {{ carbon()->translatedFormat('l j F') }}
                </span>
            </div>

            <div class="cart-v2__field">
                <label class="cart-v2__label" for="order-subject">Objet de l'e-mail</label>
                <input
                    id="order-subject"
                    name="subject"
                    type="text"
                    class="cart-v2__input"
                    value="{{ $defaultSubject }}"
                >
            </div>

            <div class="cart-v2__field">
                <label class="cart-v2__label" for="order-content">Message d'introduction</label>
                <textarea
                    id="order-content"
                    name="content"
                    rows="4"
                    class="cart-v2__textarea"
                >{{ $defaultContent }}</textarea>
            </div>

            <div class="cart-v2__products-block">
                <div class="cart-v2__products-title">Produits commandés</div>
                <div class="cart-v2__products-list">
                    @foreach ($indents as $indent)
                        <div class="cart-v2__product-line">
                            <div class="cart-v2__product-line-info">
                                <span class="cart-v2__product-line-name">{{ $indent->product?->name }}</span>
                                @if ($indent->unity?->name)
                                    <span class="cart-v2__product-line-unit">{{ $indent->unity->name }}</span>
                                @endif
                            </div>
                            <span class="cart-v2__product-line-qty">× {{ $indent->quantity }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="cart-v2__field">
                <label class="cart-v2__label" for="order-footer">Signature</label>
                <textarea
                    id="order-footer"
                    name="footer"
                    rows="3"
                    class="cart-v2__textarea"
                >{{ $provider->getMailContent() }}</textarea>
            </div>
        </div>
    </div>

    <div class="cart-v2__footer cart-v2__footer--actions">
        <a
            href="{{ route('indent.shop-cart', ['provider' => $provider->id]) }}"
            class="btn-default cart-v2__btn-back ajax-modal-up"
        >
            Retour
        </a>
        <button type="submit" class="btn-primary cart-v2__btn-send">
            <span class="btn-loader"></span>
            <span class="btn-text">Envoyer la commande</span>
        </button>
    </div>
</form>
