<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Détail commande') }}</h2>
    </x-slot>

    <div class="order-detail">
        <div class="order-detail-top">
            <div class="flex-between">
                <div class="order-detail-top-number">CMD-{{ $order->id }}</div>
                <div class="order-detail-top-status" style="background-color: {{ $status['color'] }}26; border-color: {{ $status['color'] }}; color: {{ $status['color'] }}">{{ $status['label'] }}</div>
            </div>
            <div class="order-detail-provider">{{ $order->provider?->name }}</div>
            <div class="order-detail-date">Passée le {{ carbon($order->created_at)->format('d/m/Y à H:i') }}</div>
        </div>

        <div class="order-detail-title">Produits commandés</div>

        <div class="order-detail-products">
            @foreach($order->lines as $line)
                <div class="order-detail-products-item">
                    <div class="order-detail-products-item-icon">
                        <i class="fa-solid fa-cube"></i>
                    </div>
                    <div class="order-detail-products-item-content">
                        <div class="order-detail-products-item-content-left">
                            <div class="order-detail-products-item-content-name">Glace chocolat</div>
                            <div class="order-detail-products-item-content-subname">Qte : {{ $line->quantity }}</div>
                        </div>
                        <div class="order-detail-products-item-content-right">25,00 €</div>
                    </div>
                </div>
            @endforeach
            <div class="order-detail-products-total"></div>
        </div>

        <div class="order-detail-title">Informations de livraison</div>


        @if (auth()->user()->isProvider())
            <a href="{{ route('provider.orders.accept', ['order' => $order->id]) }}" class="btn-order accept confirm-validate" data-text="Etes-vous sûr de vouloir accepter cette commande ?" data-type="success">Confirmer la commande</a>
            <a href="{{ route('provider.orders.refuse', ['order' => $order->id]) }}" class="btn-order refuse confirm-validate" data-text="Etes-vous sûr de vouloir refuser cette commande ?" data-type="error">Refuser la commande</a>
        @endif
    </div>
</x-app-layout>
