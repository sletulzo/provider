<div class="mobile-card-item swiftopen-toggle {{ $order->isValid() ? 'active' : '' }}" data-target="swiftopen_order_{{ $order->id }}">
    <div class="mobile-card-item-left">
        <div class="mobile-card-item-icon">
            <i class="fa-solid fa-cart-shopping"></i>
        </div>
    </div>
    <div class="mobile-card-item-right">
        <div class="mobile-card-item-status">
            <div class="mobile-card-item-status-item {{ $order->is_sent ? 'active' : '' }}">{{ $order->is_sent ? 'Envoyée' : 'En attente' }}</div>
            <div class="mobile-card-item-status-item {{ $order->is_accepted ? 'active' : '' }}">{{ $order->is_accepted ? 'Acceptée' : 'En attente' }}</div>
        </div>
        <div class="mobile-card-item-title">{{ $order->provider->name }} ●<span>Commande n°{{ $order->id }}</span></div>
        <div class="mobile-card-item-content">
            <div class="mobile-card-item-content-item">
                <i class="fa-regular fa-lemon"></i>
                <span>{{ $order->lines()->sum('quantity') }} articles</span>
            </div>
            <div class="mobile-card-item-content-item">
                <i class="fa-regular fa-calendar"></i>
                {{ carbon($order->created_at)->format('d/m/Y à H:i') }}
            </div>
        </div>
    </div>

    <div class="swiftopen-content" id="swiftopen_order_{{ $order->id }}">
        <div class="mobile-card-item-products">
            @foreach($order->lines as $line)
                <div class="mobile-card-item-products-item">
                    <i class="fa-regular fa-lemon"></i>
                    <b>{{ $line->product?->name }}</b>
                    <div style="margin-left: auto;">x{{ $line->quantity }}</div>
                    <div>{{ $line->unity?->name }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>

