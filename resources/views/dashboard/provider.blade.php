<x-app-layout>
    <div class="dashboard dashboard-v2">
        <div class="dashboard-v2__header">
            <div>
                <p class="dashboard-v2__context">Espace fournisseur</p>
                <h1 class="dashboard-v2__title">Bonjour, {{ $user->name }}</h1>
            </div>
            <a wire:navigate href="{{ route('orders') }}" class="dashboard-v2__cart-btn" aria-label="Commandes">
                <i class="fa-solid fa-cart-shopping">
                    @if ($stats['orders_pending'] > 0)
                        <span class="bubble">{{ $stats['orders_pending'] }}</span>
                    @endif
                </i>
            </a>
        </div>

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
            <a wire:navigate href="{{ route('orders') }}" @class(['dashboard-v2__stat', 'dashboard-v2__stat--alert' => $stats['orders_pending'] > 0])>
                <div class="dashboard-v2__stat-top">
                    <span class="dashboard-v2__stat-label">À traiter</span>
                    <span class="dashboard-v2__stat-icon"><i class="fa-solid fa-clock"></i></span>
                </div>
                <div class="dashboard-v2__stat-value">{{ $stats['orders_pending'] }}</div>
                <div class="dashboard-v2__stat-sub">En attente de réponse</div>
            </a>
            <div class="dashboard-v2__stat">
                <div class="dashboard-v2__stat-top">
                    <span class="dashboard-v2__stat-label">Chiffre d'affaires</span>
                    <span class="dashboard-v2__stat-icon"><i class="fa-solid fa-euro-sign"></i></span>
                </div>
                <div class="dashboard-v2__stat-value"><x-price :amount="$stats['monthly_revenue']" /></div>
                <div class="dashboard-v2__stat-sub">{{ carbon()->translatedFormat('F Y') }}</div>
            </div>
        </div>

        <div class="dashboard-v2__body-grid">
            <div>
                @if ($pendingOrders->isNotEmpty())
                    <x-section-title :href="route('orders')" action="Voir toutes">Commandes à traiter</x-section-title>
                    <div class="dashboard-v2__orders-block dashboard-v2__orders-block--pending">
                        @foreach ($pendingOrders as $order)
                            @include('dashboard.provider-order-item', ['order' => $order])
                        @endforeach
                    </div>
                @endif

                <x-section-title>Accès rapide</x-section-title>
                <div class="dashboard-v2__providers dashboard-v2__providers-grid">
                    <a wire:navigate href="{{ route('products') }}" class="dashboard-v2__provider">
                        <x-avatar name="Produits" />
                        <span class="dashboard-v2__provider-name">Produits</span>
                        @if ($stats['products_count'] > 0)
                            <span class="dashboard-v2__provider-badge">{{ $stats['products_count'] }}</span>
                        @endif
                    </a>
                    <a wire:navigate href="{{ route('provider.users') }}" class="dashboard-v2__provider">
                        <x-avatar name="Clients" />
                        <span class="dashboard-v2__provider-name">Clients</span>
                        @if ($stats['clients_count'] > 0)
                            <span class="dashboard-v2__provider-badge">{{ $stats['clients_count'] }}</span>
                        @endif
                    </a>
                    <a wire:navigate href="{{ route('orders') }}" @class(['dashboard-v2__provider', 'dashboard-v2__provider--active' => $stats['orders_pending'] > 0])>
                        <x-avatar name="Commandes" />
                        <span class="dashboard-v2__provider-name">Commandes</span>
                        @if ($stats['orders_pending'] > 0)
                            <span class="dashboard-v2__provider-badge">{{ $stats['orders_pending'] }}</span>
                        @endif
                    </a>
                </div>
            </div>

            <div>
                <x-section-title :href="$products->count() ? route('products') : null" :action="$products->count() ? 'Voir tous' : null">Produits les plus commandés</x-section-title>
                @if ($products->count())
                    <div class="dashboard-populars">
                        @foreach ($products as $product)
                            @include('dashboard.provider-product', ['product' => $product, 'provider' => $product->provider])
                        @endforeach
                    </div>
                @else
                    <x-empty-state
                        compact
                        icon="fa-regular fa-lemon"
                        title="Aucun produit"
                        description="Ajoutez des produits à votre catalogue pour que vos clients puissent commander."
                        action="Ajouter un produit"
                        :href="route('products.create')"
                        modal
                    />
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
