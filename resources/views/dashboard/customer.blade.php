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
        
        @php($evolution = $user->getOrdersEvolutionPercentage())
        <div class="dashboard-prices">
            <div class="dashboard-prices-title">Commandes du mois de <b>{{ carbon()->translatedFormat('F') }}</b></div>
            <div class="dashboard-prices-price">{{ $user->getOrdersCurrentMonth() }}</div>
            @if ($user->getOrdersPreviousMonth() > 0)
                <div class="dashboard-prices-percent">
                    {{ $evolution > 0 ? '+' : '' }}{{ $evolution }}% par rapport à {{ carbon()->subMonth()->translatedFormat('F') }}
                </div>
            @endif
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

        @if ($orders->count())
            <div class="dashboard-title">
                Commandes
                <a href="{{ route('orders') }}">Voir toutes</a>
            </div>
            <div class="dashboard-orders">
                @foreach($orders as $order)
                    @php ($status = $order->getStatus())
                    <div class="dashboard-orders-item">
                        <div class="dashboard-orders-item-title">
                            <div>{{ $order->provider?->name }}</div>
                            <span>CMD-{{ $order->id }} - {{ $order->user?->name }}</span>
                        </div>
                        <div class="dashboard-orders-item-price">{{ $order->lines()->count() }} articles</div>
                        <div class="dashboard-orders-item-status" style="color: {{ $status['color'] }}; background-color: {{ $status['color'] }}29">{{ $status['label'] }}</div>
                    </div>
                @endforeach
            </div>
        @endif

        @if ($products->count())
            <div class="dashboard-title">
                Produits populaires
                <a href="{{ route('products') }}">Voir tous</a>
            </div>
            <div class="dashboard-populars">
                @foreach($products as $product)
                    @include('dashboard.product', ['product' => $product, 'provider' => $product->provider])
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
