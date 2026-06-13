@php ($status = $order->getStatus())

<div class="dashboard-v2__order-card">
    <x-avatar :name="$order->user?->name ?? 'Client'" size="md" />
    <div class="dashboard-v2__order-card-body">
        <div class="dashboard-v2__order-card-name">{{ $order->user?->name ?? 'Client' }}</div>
        <div class="dashboard-v2__order-card-meta">
            CMD-{{ $order->id }} · {{ carbon($order->created_at)->format('d/m/Y') }} · {{ $order->lines_count }} article{{ $order->lines_count > 1 ? 's' : '' }}
        </div>
    </div>
    <div class="dashboard-v2__order-card-side">
        @if ($order->getTotal() > 0)
            <span class="dashboard-v2__order-card-amount"><x-price :amount="$order->getTotal()" /></span>
        @endif
        @if ($order->isPending())
            <a href="{{ route('provider.orders.respond', $order) }}" class="btn-primary">Traiter</a>
        @else
            <span class="status-badge status-badge--{{ $status['slug'] }}">{{ $status['label'] }}</span>
        @endif
    </div>
</div>
