@if ($provider)
    <a wire:navigate href="{{ route('indent.products', ['provider' => $provider->id]) }}" class="card-mobile">
        <div class="card-mobile-icon">
            <i class="fa-solid fa-cube"></i>
        </div>
        <div class="card-mobile-content">
            <div class="card-mobile-content-left">
                <div class="card-mobile-content-name">{{ $product->name }}</div>
                <div class="card-mobile-content-subname">
                    {{ $provider->name }}
                    @if ($product->price)
                        · <x-price :amount="$product->price" />
                    @endif
                </div>
            </div>
            <div class="card-mobile-content-right">
                @if ($product->orders_lines_count ?? 0)
                    <div class="card-mobile-content-quantity">{{ $product->orders_lines_count }} commande{{ $product->orders_lines_count > 1 ? 's' : '' }}</div>
                @endif
                <div class="card-mobile-content-stock">
                    @if ($provider->is_stock)
                        @php ($stock = $product->getStockLabel())
                        <span style="color: {{ $stock['color'] }}">{{ $stock['name'] }}</span>
                    @endif
                </div>
            </div>
            <div class="card-mobile-content-caret"><i class="fa-solid fa-angle-right"></i></div>
        </div>
    </a>
@endif