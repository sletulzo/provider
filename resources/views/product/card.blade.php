<a href="{{ route('products.edit', ['product' => $product->id]) }}" data-method="GET" class="card-mobile ajax-modal-up" data-size="large">
    <div class="card-mobile-icon">
        <i class="fa-solid fa-cube"></i>
    </div>
    <div class="card-mobile-content">
        <div class="card-mobile-content-left">
            <div class="card-mobile-content-name">{{ $product->name }}</div>
            <div class="card-mobile-content-subname">{{ $product->price ? $product->price / 100 . '€' : '' }}</div>
        </div>
        <div class="card-mobile-content-right">
            <div class="card-mobile-content-stock">
                @if ($provider->is_stock)
                    @php ($stock = $product->getStockLabel())
                    <span style="color: {{ $stock['color'] }}">{{ $stock['name'] }}</span>
                @endif
            </div>
            
            @if ($product->quantity_min)
                <div class="card-mobile-content-quantity">Quantité min : {{ $product->quantity_min }}</div>
            @endif
        </div>
        <div class="card-mobile-content-caret"><i class="fa-solid fa-angle-right"></i></div>
    </div>
</a>