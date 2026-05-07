<x-app-layout>
    <div class="dashboard">
        <h2>Bonjour, <b>{{ $user->name }}👋</b></h2>

        <div class="dashboard-prices">
            <div class="dashboard-prices-title">Chiffre d'affaires</div>
            <div class="dashboard-prices-price">12 450,00 €</div>
            <div class="dashboard-prices-percent">+12% ce mois</div>
            <div class="dashboard-prices-image">
                <img src="{{ Vite::asset('resources/images/chart.png') }}">
            </div>
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
