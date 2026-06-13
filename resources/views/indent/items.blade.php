@if ($products->isEmpty())
    <x-empty-state
        icon="fa-regular fa-lemon"
        title="Aucun produit"
        :description="Auth::user()->is_only_order
            ? 'Aucun produit n\'est disponible chez ce fournisseur pour le moment.'
            : 'Ajoutez des produits à ce fournisseur pour pouvoir commander.'"
        :action="Auth::user()->is_only_order ? null : 'Ajouter un produit'"
        :href="Auth::user()->is_only_order ? null : route('products.create')"
        :modal="!Auth::user()->is_only_order"
    />
@endif

@foreach($products as $product)
    @php ($stock = $product->getStock())
    <div
        class="indent-v2__product {{ $product->quantity ? 'active' : '' }} {{ $provider->is_stock && $stock == 0 ? 'disabled' : '' }}"
        data-product-name="{{ strtolower($product->name) }}"
    >
        <div class="indent-v2__product-row">
            @if ($provider->is_stock)
                <div class="indent-v2__product-icon"><span>{{ $stock }}</span></div>
            @else
                <div class="indent-v2__product-icon"><i class="fa-solid fa-cube"></i></div>
            @endif
            <div class="indent-v2__product-info">
                <div class="indent-v2__product-name">{{ $product->name }}</div>
                <div class="indent-v2__product-meta">
                    {{ $product->unity?->name }}
                    @if ($product->price)
                        · {{ price($product->price, 2) }} €
                    @endif
                    @if ($provider->is_stock)
                        · @php($stockLabel = $product->getStockLabel())
                        <span style="color: {{ $stockLabel['color'] }}">{{ $stockLabel['name'] }}</span>
                    @endif
                </div>
            </div>
            <div class="updown updown-v2" data-url="{{ route('indent.update.quantity', ['product' => $product->id]) }}">
                <button type="button" data-type="remove" class="trigger-updown" aria-label="Retirer"><i class="fa-solid fa-minus"></i></button>
                <span class="updown-display">{{ $product->quantity ?? 0 }}</span>
                <button type="button" data-type="add" class="trigger-updown" aria-label="Ajouter"><i class="fa-solid fa-plus"></i></button>
            </div>
        </div>
    </div>
@endforeach

<a class="indent-order-popup ajax-modal-up slide-right {{ ($orderCount ?? 0) ? 'active' : '' }}" href="{{ route('indent.shop-cart', ['provider' => $provider->id]) }}">
    <i class="fa-solid fa-basket-shopping">
        <span id="indentOrderCount">{{ $orderCount ?? 0 }}</span>
    </i>
    Voir la commande
</a>
