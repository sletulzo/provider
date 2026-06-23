<x-app-layout>
    <div class="indent-v2">
        <div class="indent-v2__top">
            <div class="indent-v2__top-row">
                <a wire:navigate href="{{ route('indents') }}" class="indent-v2__back" aria-label="Retour"><i class="fa-solid fa-arrow-left"></i></a>
                <div>
                    <div class="indent-v2__provider-name">{{ $provider->name }}</div>
                    @if ($provider->email)
                        <div class="indent-v2__provider-email">{{ $provider->email }}</div>
                    @endif
                </div>
            </div>
            @if ($provider->comment)
                <div class="indent-v2__provider-description">
                    <i class="fa-regular fa-message"></i>
                    <span>{!! nl2br(e($provider->comment)) !!}</span>
                </div>
            @endif
            @if (($shippingCost ?? 0) > 0)
                <div class="indent-v2__provider-shipping">
                    <i class="fa-solid fa-truck"></i>
                    <span>Frais de port : {{ price($shippingCost, 2) }} €</span>
                </div>
            @endif
            <div style="margin-top: 12px;">
                <x-search-bar placeholder="Rechercher un produit…" id="indentProductSearch" />
            </div>
        </div>

        <div class="indent-v2__filters" aria-hidden="true">
            <span class="indent-v2__filter indent-v2__filter--active">Tous</span>
        </div>

        <div class="indent-v2__products" id="indentProductList">
            @include('indent.items')
        </div>

        <a
            href="{{ route('indent.shop-cart', ['provider' => $provider->id]) }}"
            @class(['indent-v2__sticky-cart', 'ajax-modal-up', 'active' => ($orderCount ?? 0) > 0])
        >
            <div>
                <div class="indent-v2__sticky-cart-label">Panier · {{ $orderCount ?? 0 }} article{{ ($orderCount ?? 0) > 1 ? 's' : '' }}</div>
                <div class="indent-v2__sticky-cart-total">{{ price($cartTotal ?? 0, 2) }} €</div>
            </div>
            <span class="btn-primary indent-v2__sticky-cart-action">Voir le panier</span>
        </a>
    </div>
</x-app-layout>
