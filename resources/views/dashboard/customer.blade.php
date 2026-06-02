<x-app-layout>
    <x-slot name="headerActions">
        <a href="{{ route('indents') }}" class="table-wrapper-action relative">
            <i class="fa-solid fa-cart-shopping">
                @if (Auth::user()->tenant && Auth::user()->tenant->countOrdersWaiting())
                    <span class="bubble">{{ Auth::user()->tenant->countOrdersWaiting() }}</span>
                @endif
            </i>
        </a>
    </x-slot>

    <div class="dashboard">
        <h2>Bonjour, <b>{{ $user->name }}👋</b></h2>

        <div class="dashboard-prices">
            <div class="dashboard-prices-title">Produits commandés</div>
            <div class="dashboard-prices-price">{{ $user->getOrdersProducts() }}</div>
            <div class="dashboard-prices-percent">{{ $user->getOrders()->count() }} commandes</div>
            <div class="dashboard-prices-image">
                <img src="{{ Vite::asset('resources/images/chart.png') }}">
            </div>
        </div>

        <div class="dashboard-title">
            Fournisseurs
            <a href="{{ route('indents') }}">Voir tous</a>
        </div>

        <div class="dashboard-providers">
            @foreach($providers as $provider)
                <a wire:navigate href="{{ route('indent.products', ['provider' => $provider->id]) }}" class="dashboard-providers-item">
                    <div class="image"><i class="fa-regular fa-address-book"></i></div>
                    <div class="name">{{ $provider->name }}</div>
                </a>
            @endforeach
        </div>

        <div class="dashboard-title">
            Commandes
            <a href="{{ route('orders') }}">Voir toutes</a>
        </div>
        <div class="dashboard-orders">
            @foreach($orders as $order)
                @php ($status = $order->getStatus())
                <div class="dashboard-orders-item">
                    <div class="dashboard-orders-item-title">
                        <div>CMD-{{ $order->id }}</div>
                        <span>{{ $order->user?->name }}</span>
                    </div>
                    <div class="dashboard-orders-item-price">{{ $order->lines()->count() }} articles</div>
                    <div class="dashboard-orders-item-status" style="color: {{ $status['color'] }}; background-color: {{ $status['color'] }}29">{{ $status['label'] }}</div>
                </div>
            @endforeach
        </div>

        <div class="dashboard-title">
            Produits populaires
            <a href="{{ route('products') }}">Voir tous</a>
        </div>
        <div class="dashboard-populars">
            @foreach($products as $product)
                @include('product.card', ['product' => $product, 'provider' => $product->provider])
            @endforeach
        </div>
    </div>
</x-app-layout>
