@php ($status = $order->getStatus())

<a href="{{ route('orders.edit', ['order' => $order->id]) }}" class="mobile-card-item" data-target="swiftopen_order_{{ $order->id }}">
    <div class="mobile-card-item-left">
        <div class="mobile-card-item-title">CMD-{{ $order->id }}</div>
        <div class="mobile-card-item-subtitle">{{ $order->provider?->name }} - {{ $order->user?->name }}</div>
    </div>
    <div class="mobile-card-item-right">
        <span class="f-11">{{ $order->lines()->sum('quantity') }} articles</span>
    </div>
    <div class="mobile-card-item-status">
        <div class="mobile-card-item-status-item {{ $status['slug'] }}">{{ $status['label'] }}</div>
    </div>
</a>