@foreach($products as $product)
    <div class="indent-container-right-item {{ $product->quantity ? 'active' : '' }}">
        <div class="indent-container-right-item-body">
            <div class="indent-container-right-item-icon"><i class="fa-solid fa-cube"></i></div>
            <div class="indent-container-right-item-name">
                <div class="name">{{ $product->name }}</div>
                <div class="description">{{ $product->unity?->name }}</div>
            </div>
            <div class="indent-container-right-item-price">0 €</div>
        </div>
        <div class="indent-container-right-item-footer">
            <div class="indent-container-right-item-actions">
                <div class="updown" data-url="{{ route('dashboard.quantities', ['product' => $product->id]) }}">
                    <button data-type="remove" class="trigger-updown"><i class="fa-solid fa-minus"></i></button>
                    <span class="updown-display">{{ $product->quantity ?? 0 }}</span>
                    <button data-type="add" class="trigger-updown"><i class="fa-solid fa-plus"></i></button>
                </div>
            </div>
            <div class="indent-container-right-item-total">167€</div>
        </div>
    </div>
@endforeach