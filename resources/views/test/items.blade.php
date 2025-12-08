@foreach($products as $product)
    <div class="indent-container-right-item {{ $product->quantity ? 'active' : '' }}">
        <div class="indent-container-right-item-body">
            <div class="indent-container-right-item-icon"><i class="fa-solid fa-cube"></i></div>
            <div class="indent-container-right-item-name">
                <div class="name">{{ $product->name }}</div>
                <div class="description">{{ $product->unity?->name }}</div>
            </div>
            <div class="indent-container-right-item-price">
                <div class="indent-container-right-item-actions">
                    <div class="updown" data-url="{{ route('indent.update.quantity', ['product' => $product->id]) }}">
                        <button data-type="remove" class="trigger-updown"><i class="fa-solid fa-minus"></i></button>
                        <span class="updown-display">{{ $product->quantity ?? 0 }}</span>
                        <button data-type="add" class="trigger-updown"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

<a class="indent-order-popup ajax-modal-up slide-right {{ $orderCount ? 'active' : '' }}" href="{{ route('indent.shop-cart', ['provider' => $provider->id]) }}">
    <i class="fa-solid fa-basket-shopping">
        <span id="indentOrderCount">{{ $orderCount }}</span>
    </i>
    Voir la commande
</a>