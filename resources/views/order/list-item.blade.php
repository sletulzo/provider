@php
    $status = $order->getStatus();
    $isProvider = Auth::user()->isProvider();
    $partyName = $isProvider
        ? ($order->user?->name ?? 'Client')
        : ($order->provider?->name ?? '—');
    $itemCount = (int) ($order->lines_qty ?? $order->lines_count ?? $order->lines->sum('quantity'));
@endphp

<a wire:navigate href="{{ route('orders.edit', ['order' => $order->id]) }}" class="orders-list__item">
    <x-avatar :name="$partyName" />
    <div class="orders-list__item-body">
        <div class="orders-list__item-title">{{ $partyName }}</div>
        <div class="orders-list__item-meta">
            CMD-{{ $order->id }}
            · {{ carbon($order->created_at)->format('d/m/Y') }}
            · {{ $itemCount }} article{{ $itemCount > 1 ? 's' : '' }}
        </div>
    </div>
    <div class="orders-list__item-side">
        @if ($order->getTotal() > 0)
            <span class="orders-list__item-amount">{{ price($order->getTotal(), 2) }} €</span>
        @endif
        <span class="status-badge status-badge--{{ $status['slug'] }}">{{ $status['label'] }}</span>
    </div>
    <span class="orders-list__item-chevron" aria-hidden="true"><i class="fa-solid fa-angle-right"></i></span>
</a>
