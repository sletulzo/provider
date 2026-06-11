<x-app-layout>
    <x-slot name="headerActions">
        <a href="{{ route('indents') }}" class="table-wrapper-action relative">
            <i class="fa-solid fa-cart-shopping">
                @if ($stats['cart_items'] > 0)
                    <span class="bubble">{{ $stats['cart_items'] }}</span>
                @endif
            </i>
        </a>
    </x-slot>

    <div class="dashboard">
        <h2>Bonjour, <b>{{ $user->name }}</b></h2>

        <div class="dashboard-stats">
            <div class="dashboard-stat-card dashboard-stat-card--primary">
                <div class="dashboard-stat-icon"><i class="fa-solid fa-cart-shopping"></i></div>
                <div class="dashboard-stat-content">
                    <div class="dashboard-stat-label">Commandes ce mois</div>
                    <div class="dashboard-stat-value">{{ $stats['orders_this_month'] }}</div>
                    @if ($stats['orders_previous_month'] > 0)
                        <div class="dashboard-stat-sub {{ $stats['orders_evolution'] >= 0 ? 'dashboard-stat-sub--up' : 'dashboard-stat-sub--down' }}">
                            {{ $stats['orders_evolution'] > 0 ? '+' : '' }}{{ $stats['orders_evolution'] }}% vs {{ carbon()->subMonth()->translatedFormat('F') }}
                        </div>
                    @endif
                </div>
            </div>

            <a wire:navigate href="{{ route('indents') }}" class="dashboard-stat-card {{ $stats['cart_items'] > 0 ? 'dashboard-stat-card--active' : '' }}">
                <div class="dashboard-stat-icon"><i class="fa-solid fa-basket-shopping"></i></div>
                <div class="dashboard-stat-content">
                    <div class="dashboard-stat-label">Panier en cours</div>
                    <div class="dashboard-stat-value">{{ $stats['cart_items'] }}</div>
                    <div class="dashboard-stat-sub">{{ $stats['cart_providers'] }} fournisseur{{ $stats['cart_providers'] > 1 ? 's' : '' }}</div>
                </div>
            </a>

            <div class="dashboard-stat-card">
                <div class="dashboard-stat-icon"><i class="fa-solid fa-euro-sign"></i></div>
                <div class="dashboard-stat-content">
                    <div class="dashboard-stat-label">Montant du mois</div>
                    <div class="dashboard-stat-value">{{ price($stats['monthly_spend'], 2) }} €</div>
                    <div class="dashboard-stat-sub">{{ carbon()->translatedFormat('F Y') }}</div>
                </div>
            </div>
        </div>

        @if ($draftCarts->isNotEmpty())
            <div class="dashboard-title">
                Paniers à finaliser
                <a href="{{ route('indents') }}">Voir le catalogue</a>
            </div>
            <div class="dashboard-carts">
                @foreach ($draftCarts as $cart)
                    <a href="{{ route('indent.shop-cart', ['provider' => $cart['provider']->id]) }}" class="dashboard-carts-item ajax-modal-up">
                        <div class="dashboard-carts-item-icon"><i class="fa-regular fa-address-book"></i></div>
                        <div class="dashboard-carts-item-content">
                            <div class="dashboard-carts-item-name">{{ $cart['provider']->name }}</div>
                            <div class="dashboard-carts-item-sub">{{ $cart['items_count'] }} article{{ $cart['items_count'] > 1 ? 's' : '' }} · {{ price($cart['total'], 2) }} €</div>
                        </div>
                        <div class="dashboard-carts-item-action">Finaliser <i class="fa-solid fa-angle-right"></i></div>
                    </a>
                @endforeach
            </div>
        @endif

        <div class="dashboard-title">
            Commander rapidement
            <a href="{{ route('indents') }}">Tous les fournisseurs</a>
        </div>

        <div class="dashboard-providers">
            @forelse($providers as $provider)
                @php ($cartQty = $provider->sumOrderWaitings())
                <a wire:navigate href="{{ route('indent.products', ['provider' => $provider->id]) }}" @class(['dashboard-providers-item', 'dashboard-providers-item--active' => $cartQty > 0])>
                    <div class="image"><i class="fa-regular fa-address-book"></i></div>
                    <div class="name">{{ $provider->name }}</div>
                    @if ($cartQty > 0)
                        <span class="dashboard-providers-badge">{{ $cartQty }}</span>
                    @endif
                </a>
            @empty
                <x-empty-state
                    compact
                    icon="fa-regular fa-address-book"
                    title="Aucun fournisseur"
                    :description="Auth::user()->is_only_order
                        ? 'Contactez votre administrateur pour configurer vos fournisseurs.'
                        : 'Ajoutez un fournisseur pour commencer à passer des commandes.'"
                    :action="Auth::user()->is_only_order ? null : 'Ajouter un fournisseur'"
                    :href="Auth::user()->is_only_order ? null : route('providers.create')"
                    :modal="!Auth::user()->is_only_order"
                />
            @endforelse
        </div>

        <div class="dashboard-title">
            Produits les plus commandés
            @if ($products->count())
                <a href="{{ route('products') }}">Voir tous</a>
            @endif
        </div>

        @if ($products->count())
            <div class="dashboard-populars">
                @foreach ($products as $product)
                    @include('dashboard.product', ['product' => $product, 'provider' => $product->provider])
                @endforeach
            </div>
        @else
            <x-empty-state
                compact
                icon="fa-regular fa-lemon"
                title="Aucun produit"
                :description="Auth::user()->is_only_order
                    ? 'Les produits apparaîtront ici une fois configurés par votre administrateur.'
                    : 'Ajoutez des produits à votre catalogue pour les retrouver rapidement.'"
                :action="Auth::user()->is_only_order ? null : 'Ajouter un produit'"
                :href="Auth::user()->is_only_order ? null : route('products.create')"
                :modal="!Auth::user()->is_only_order"
            />
        @endif
    </div>
</x-app-layout>
