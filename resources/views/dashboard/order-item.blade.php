@php ($status = $order->getStatus())

<a wire:navigate href="{{ route('orders.edit', ['order' => $order->id]) }}" class="dashboard-orders-item">
    <div class="dashboard-orders-item-title">
        <div>{{ $order->provider?->name }}</div>
        <span>CMD-{{ $order->id }} · {{ carbon($order->created_at)->format('d/m/Y') }}@if (!$user->is_only_order) · {{ $order->user?->name }}@endif</span>
    </div>
    <div class="dashboard-orders-item-meta">
        <span>{{ $order->lines_count }} article{{ $order->lines_count > 1 ? 's' : '' }}</span>
        @if ($order->getTotal() > 0)
            <span>{{ price($order->getTotal(), 2) }} €</span>
        @endif
    </div>
    <div class="dashboard-orders-item-status" style="color: {{ $status['color'] }}; background-color: {{ $status['color'] }}29">{{ $status['label'] }}</div>
</a>
