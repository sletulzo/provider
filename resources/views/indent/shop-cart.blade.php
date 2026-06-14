<div class="cart-v2">
    <div class="cart-v2__top">
        <div class="cart-v2__handle" aria-hidden="true"></div>

        <header class="cart-v2__header">
            <div class="cart-v2__header-text">
                <h2 class="cart-v2__title">Mon panier</h2>
                <p class="cart-v2__subtitle">{{ $orderCount }} article{{ $orderCount > 1 ? 's' : '' }}</p>
            </div>
            <div class="cart-v2__header-end">
                <span class="cart-v2__badge">{{ $indents->count() }}</span>
                <button type="button" class="cart-v2__close close-modal-up" aria-label="Fermer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </header>
    </div>

    <div class="cart-v2__provider">
        <div class="cart-v2__provider-icon">
            <i class="fa-solid fa-truck-field"></i>
        </div>
        <div class="cart-v2__provider-info">
            <div class="cart-v2__provider-name">{{ $provider->name }}</div>
            @if ($provider->email)
                <div class="cart-v2__provider-email">{{ $provider->email }}</div>
            @endif
        </div>
    </div>

    <div class="cart-v2__items">
        @foreach ($indents as $indent)
            <div class="cart-v2__item">
                <div class="cart-v2__item-icon">
                    <i class="fa-solid fa-cube"></i>
                </div>
                <div class="cart-v2__item-info">
                    <div class="cart-v2__item-name">{{ $indent->product?->name }}</div>
                    <div class="cart-v2__item-meta">
                        {{ $indent->quantity }} × {{ price($indent->product?->price, 2) }} €
                        @if ($indent->unity?->name)
                            <span class="cart-v2__item-unit">· {{ $indent->unity->name }}</span>
                        @endif
                    </div>
                </div>
                <div class="cart-v2__item-price">{{ price($indent->getPrice(), 2) }} €</div>
            </div>
        @endforeach
    </div>

    <footer class="cart-v2__footer">
        <div class="cart-v2__total">
            <span class="cart-v2__total-label">Total</span>
            <strong class="cart-v2__total-value">{{ price($cartTotal, 2) }} €</strong>
        </div>
        <a
            href="{{ route('indent.preview', ['provider' => $provider->id]) }}"
            class="btn-primary cart-v2__cta ajax-modal-up"
            data-size="large"
        >
            Passer la commande
        </a>
    </footer>
</div>
