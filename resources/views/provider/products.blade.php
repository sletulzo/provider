@foreach($products as $product)
    <div class="container-provider-products-item" data-id="{{ $product->id }}">
        <div class="name">{{ $product->name }}</div>
        <div class="unity">{{ $product->unity_name }}</div>
        <div class="input">
            <a href="#" class="increment" data-type="minus" data-target="input-provider-product-update"><i class="fa-solid fa-minus"></i></a>
            <input type="number" min="0" class="input-provider-product-update" data-url="{{ route('providers.products.quantity', ['product' => $product->id]) }}" value="{{ $product->quantity }}">
            <a href="#" class="increment" data-type="plus" data-target="input-provider-product-update"><i class="fa-solid fa-plus"></i></a>
        </div>
    </div>
@endforeach