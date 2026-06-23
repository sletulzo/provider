<div class="cart-v2">
    <div class="cart-v2__chrome" data-modal-drag-handle>
        <div class="cart-v2__drag">
            <span class="cart-v2__handle" aria-hidden="true"></span>
        </div>

        <div class="cart-v2__hero">
            <div class="cart-v2__hero-main">
                <div class="cart-v2__hero-icon">
                    <i class="fa-solid fa-basket-shopping"></i>
                </div>
                <div class="cart-v2__hero-text">
                    <h2 class="cart-v2__hero-title">Mon panier</h2>
                    <p class="cart-v2__hero-provider">{{ $provider->name }}</p>
                </div>
            </div>
            <button type="button" class="cart-v2__close close-modal-up" aria-label="Fermer">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="cart-v2__summary">
            <span class="cart-v2__pill">{{ $orderCount }} article{{ $orderCount > 1 ? 's' : '' }}</span>
            <span class="cart-v2__pill cart-v2__pill--accent">{{ $indents->count() }} réf.</span>
            @if ($provider->email)
                <span class="cart-v2__pill cart-v2__pill--muted">{{ $provider->email }}</span>
            @endif
            @if (($shippingCost ?? 0) > 0)
                <span class="cart-v2__pill cart-v2__pill--muted">
                    <i class="fa-solid fa-truck"></i> {{ price($shippingCost, 2) }} € port
                </span>
            @endif
        </div>

        @if ($provider->comment)
            <div class="cart-v2__provider-note">
                <i class="fa-regular fa-message"></i>
                <span>{!! nl2br(e($provider->comment)) !!}</span>
            </div>
        @endif
    </div>

    <div class="cart-v2__body">
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
    </div>

    <div class="cart-v2__footer">
        <div class="cart-v2__total">
            @if (($shippingCost ?? 0) > 0)
                <span class="cart-v2__total-label">Sous-total {{ price($cartSubtotal ?? 0, 2) }} € · Port {{ price($shippingCost, 2) }} €</span>
            @else
                <span class="cart-v2__total-label">Total</span>
            @endif
            <strong class="cart-v2__total-value">{{ price($cartTotal, 2) }} €</strong>
        </div>
        <a
            href="{{ route('indent.preview', ['provider' => $provider->id]) }}"
            class="btn-primary cart-v2__cta ajax-modal-up"
            data-size="large"
        >
            Passer la commande
        </a>
    </div>
</div>
