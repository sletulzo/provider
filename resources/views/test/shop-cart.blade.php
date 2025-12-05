<div class="shop-cart">
    <div class="shop-cart-title">
        Ma commande
        <span class="shop-cart-title-label">{{ $indents->sum('quantity') }} articles</span>
    </div>
    <div class="shop-cart-body">
        <div class="shop-cart-body-provider"><i class="fa-regular fa-address-book"></i> {{ $provider->name }}</div>
        <div class="shop-cart-body-items">
            @foreach($indents as $indent)
                <div class="shop-cart-body-item">
                    <div class="shop-cart-body-item-icon"><i class="fa-solid fa-cube"></i></div>
                    <div class="shop-cart-body-item-name">
                        <div>{{ $indent->product?->name }}</div>
                        <span>{{ $indent->quantity }} x {{ $indent->product?->price / 100 }}€</span>
                    </div>
                    <div class="shop-cart-body-item-actions">
                        <div class="price">{{ $indent->getPrice() / 100 }}€</div>
                        <a href=""><i class="fa-regular fa-trash-can"></i></a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="shop-cart-footer">
        <div>
            <div class="shop-cart-footer-title">Total général</div>
            <div class="shop-cart-footer-price">{{ $provider->getPrice() / 100 }}€</div>
        </div>
        <div class="shop-cart-footer-actions">
            <a href="" class="btn-primary">Passer la commande</a>
        </div>
    </div>
</div>