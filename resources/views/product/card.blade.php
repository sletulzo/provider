<a href="{{ route('products.edit', ['product' => $product->id]) }}" data-method="GET" class="card-mobile ajax-modal-up" data-size="large">
    <div class="card-mobile-icon">
        <i class="fa-solid fa-cube"></i>
    </div>
    <div class="card-mobile-content">
        <div class="card-mobile-content-left">
            <div class="card-mobile-content-name">{{ $product->name }}</div>
            <div class="card-mobile-content-subname">{{ $product->unity?->name }}</div>
        </div>
        <div class="card-mobile-content-right">
            <div class="card-mobile-content-price">{{ $product->id }}€</div>
            @if ($product->quantity_min)
                <div class="card-mobile-content-quantity">Quantité min : {{ $product->quantity_min }}</div>
            @endif
        </div>
    </div>
</a>