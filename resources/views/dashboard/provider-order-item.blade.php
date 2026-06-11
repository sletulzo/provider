@php ($status = $order->getStatus())

<a wire:navigate href="{{ route('orders.edit', ['order' => $order->id]) }}" class="dashboard-orders-item">
    <div class="dashboard-orders-item-title">
        <div>{{ $order->user?->name ?? 'Client' }}</div>
        <span>CMD-{{ $order->id }} · {{ carbon($order->created_at)->format('d/m/Y') }}</span>
    </div>
    <div class="dashboard-orders-item-meta">
        <span>{{ $order->lines_count }} article{{ $order->lines_count > 1 ? 's' : '' }}</span>
        @if ($order->getTotal() > 0)
            <span><x-price :amount="$order->getTotal()" /></span>
        @endif
    </div>
    <div class="dashboard-orders-item-status status-badge status-badge--{{ $status['slug'] }}">{{ $status['label'] }}</div>
</a>
