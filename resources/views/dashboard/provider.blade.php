<x-app-layout>
    <x-slot name="headerActions">
        <a href="{{ route('orders') }}" class="table-wrapper-action relative">
            <i class="fa-solid fa-cart-shopping">
                @if ($stats['orders_pending'] > 0)
                    <span class="bubble">{{ $stats['orders_pending'] }}</span>
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

            <a wire:navigate href="{{ route('orders') }}" class="dashboard-stat-card {{ $stats['orders_pending'] > 0 ? 'dashboard-stat-card--alert' : '' }}">
                <div class="dashboard-stat-icon"><i class="fa-regular fa-clock"></i></div>
                <div class="dashboard-stat-content">
                    <div class="dashboard-stat-label">À traiter</div>
                    <div class="dashboard-stat-value">{{ $stats['orders_pending'] }}</div>
                    <div class="dashboard-stat-sub">En attente de réponse</div>
                </div>
            </a>

            <div class="dashboard-stat-card">
                <div class="dashboard-stat-icon"><i class="fa-solid fa-euro-sign"></i></div>
                <div class="dashboard-stat-content">
                    <div class="dashboard-stat-label">Chiffre d'affaires</div>
                    <div class="dashboard-stat-value"><x-price :amount="$stats['monthly_revenue']" /></div>
                    <div class="dashboard-stat-sub">{{ carbon()->translatedFormat('F Y') }}</div>
                </div>
            </div>
        </div>

        @if ($pendingOrders->isNotEmpty())
            <div class="dashboard-title">
                Commandes à traiter
                <a href="{{ route('orders') }}">Voir toutes</a>
            </div>
            <div class="dashboard-orders dashboard-orders--pending">
                @foreach ($pendingOrders as $order)
                    @include('dashboard.provider-order-item', ['order' => $order])
                @endforeach
            </div>
        @endif

        <div class="dashboard-title">Accès rapide</div>

        <div class="dashboard-providers">
            <a wire:navigate href="{{ route('products') }}" class="dashboard-providers-item">
                <div class="image"><i class="fa-regular fa-lemon"></i></div>
                <div class="name">Produits</div>
                @if ($stats['products_count'] > 0)
                    <span class="dashboard-providers-badge">{{ $stats['products_count'] }}</span>
                @endif
            </a>
            <a wire:navigate href="{{ route('provider.users') }}" class="dashboard-providers-item">
                <div class="image"><i class="fa-solid fa-users-line"></i></div>
                <div class="name">Clients</div>
                @if ($stats['clients_count'] > 0)
                    <span class="dashboard-providers-badge">{{ $stats['clients_count'] }}</span>
                @endif
            </a>
            <a wire:navigate href="{{ route('orders') }}" class="dashboard-providers-item {{ $stats['orders_pending'] > 0 ? 'dashboard-providers-item--active' : '' }}">
                <div class="image"><i class="fa-solid fa-cart-shopping"></i></div>
                <div class="name">Commandes</div>
                @if ($stats['orders_pending'] > 0)
                    <span class="dashboard-providers-badge">{{ $stats['orders_pending'] }}</span>
                @endif
            </a>
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
</x-app-layout>
