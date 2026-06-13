<x-app-layout>
    <div class="dashboard dashboard-v2">
        <div class="dashboard-v2__header">
            <div>
                <p class="dashboard-v2__context">Espace client</p>
                <h1 class="dashboard-v2__title">Bonjour, {{ $user->name }}</h1>
            </div>
            <a href="{{ route('indents') }}" class="dashboard-v2__cart-btn" aria-label="Panier">
                <i class="fa-solid fa-cart-shopping">
                    @if ($stats['cart_items'] > 0)
                        <span class="bubble">{{ $stats['cart_items'] }}</span>
                    @endif
                </i>
            </a>
        </div>

        <x-search-bar placeholder="Produit, fournisseur…" data-search="dashboard" />

        <div class="dashboard-v2__hero">
            <div class="dashboard-v2__hero-inner">
                <div>
                    <div class="dashboard-v2__hero-label">Commandes ce mois</div>
                    <div class="dashboard-v2__hero-value">{{ $stats['orders_this_month'] }}</div>
                    @if ($stats['orders_previous_month'] > 0)
                        <div class="dashboard-v2__hero-sub {{ $stats['orders_evolution'] >= 0 ? 'dashboard-v2__hero-sub--up' : 'dashboard-v2__hero-sub--down' }}">
                            {{ $stats['orders_evolution'] > 0 ? '+' : '' }}{{ $stats['orders_evolution'] }} % vs {{ carbon()->subMonth()->translatedFormat('F') }}
                        </div>
                    @else
                        <div class="dashboard-v2__hero-sub">{{ carbon()->translatedFormat('F Y') }}</div>
                    @endif
                </div>
                <div class="dashboard-v2__hero-icon"><i class="fa-solid fa-cart-shopping"></i></div>
            </div>
        </div>

        <div class="dashboard-v2__stats">
            <a wire:navigate href="{{ route('indents') }}" @class(['dashboard-v2__stat', 'dashboard-v2__stat--active' => $stats['cart_items'] > 0])>
                <div class="dashboard-v2__stat-label">Panier en cours</div>
                <div class="dashboard-v2__stat-value">{{ $stats['cart_items'] }}</div>
                <div class="dashboard-v2__stat-sub">{{ $stats['cart_providers'] }} fournisseur{{ $stats['cart_providers'] > 1 ? 's' : '' }}</div>
            </a>
            <div class="dashboard-v2__stat">
                <div class="dashboard-v2__stat-label">Montant du mois</div>
                <div class="dashboard-v2__stat-value"><x-price :amount="$stats['monthly_spend']" /></div>
                <div class="dashboard-v2__stat-sub">{{ carbon()->translatedFormat('F Y') }}</div>
            </div>
        </div>

        <div class="dashboard-v2__body-grid">
            <div>
                @if ($draftCarts->isNotEmpty())
                    <x-section-title :href="route('indents')" action="Catalogue">Paniers à finaliser</x-section-title>
                    @foreach ($draftCarts as $cart)
                        <div class="dashboard-v2__cart-card">
                            <x-avatar :name="$cart['provider']->name" />
                            <div class="dashboard-v2__cart-card-body">
                                <div class="dashboard-v2__cart-card-name">{{ $cart['provider']->name }}</div>
                                <div class="dashboard-v2__cart-card-sub">
                                    {{ $cart['items_count'] }} article{{ $cart['items_count'] > 1 ? 's' : '' }} · <x-price :amount="$cart['total']" />
                                </div>
                            </div>
                            <a href="{{ route('indent.shop-cart', ['provider' => $cart['provider']->id]) }}" class="btn-primary ajax-modal-up">Finaliser</a>
                        </div>
                    @endforeach
                @endif

                <x-section-title :href="route('indents')" action="Catalogue">Commander rapidement</x-section-title>
                <div @class(['dashboard-v2__providers', 'dashboard-v2__providers-grid' => $providers->count() <= 4])>
                    @forelse($providers as $provider)
                        @php ($cartQty = $provider->sumOrderWaitings())
                        <a wire:navigate href="{{ route('indent.products', ['provider' => $provider->id]) }}" @class(['dashboard-v2__provider', 'dashboard-v2__provider--active' => $cartQty > 0])>
                            <x-avatar :name="$provider->name" />
                            <span class="dashboard-v2__provider-name">{{ $provider->name }}</span>
                            @if ($cartQty > 0)
                                <span class="dashboard-v2__provider-badge">{{ $cartQty }}</span>
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
            </div>

            <div>
                <x-section-title :href="$products->count() ? route('products') : null" :action="$products->count() ? 'Voir tous' : null">Produits les plus commandés</x-section-title>
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
        </div>
    </div>
</x-app-layout>
