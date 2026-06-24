<a wire:navigate href="{{ route('products.edit', ['product' => $product->id]) }}" class="card-mobile">
    <div class="card-mobile-icon">
        <i class="fa-solid fa-cube"></i>
    </div>
    <div class="card-mobile-content">
        <div class="card-mobile-content-left">
            <div class="card-mobile-content-name">{{ $product->name }}</div>
            <div class="card-mobile-content-subname">
                @if ($product->orders_lines_count ?? 0)
                    {{ $product->orders_lines_count }} commande{{ $product->orders_lines_count > 1 ? 's' : '' }}
                @endif
                @if ($product->price)
                    @if ($product->orders_lines_count ?? 0) · @endif
                    <x-price :amount="$product->price" />
                @endif
            </div>
        </div>
        <div class="card-mobile-content-right">
            @if ($provider->is_stock)
                @php ($stock = $product->getStockLabel())
                <div class="card-mobile-content-stock">
                    <span style="color: {{ $stock['color'] }}">{{ $stock['name'] }}</span>
                </div>
            @endif
        </div>
        <div class="card-mobile-content-caret"><i class="fa-solid fa-angle-right"></i></div>
    </div>
</a>
