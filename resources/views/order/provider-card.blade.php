@php ($status = $order->getStatus())

<a href="{{ route('orders.edit', ['order' => $order->id]) }}" class="mobile-card-item" data-target="swiftopen_order_{{ $order->id }}">
    <div class="mobile-card-item-left">
        <div class="mobile-card-item-title">CMD-{{ $order->id }}</div>
        <div class="mobile-card-item-subtitle">{{ $order->user?->name }}</div>
    </div>
    <div class="mobile-card-item-right">
        <span>{{ $order->lines()->sum('quantity') }} articles</span>
    </div>
    <div class="mobile-card-item-status">
        <div class="mobile-card-item-status-item {{ $status['slug'] }}">{{ $status['label'] }}</div>
    </div>
</a>

@if ($status['slug'] == 'waiting')
    <div class="mobile-card-item-response">
        <a href="{{ route('provider.orders.accept', ['order' => $order->id]) }}" class="btn-order accept confirm-validate" data-text="Etes-vous sûr de vouloir accepter cette commande ?" data-type="success">Accepter</a>
        <a href="{{ route('provider.orders.refuse', ['order' => $order->id]) }}" class="btn-order refuse confirm-validate" data-text="Etes-vous sûr de vouloir refuser cette commande ?" data-type="error">Refuser</a>
    </div>
@endif


