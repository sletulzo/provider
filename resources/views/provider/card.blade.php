<a wire:navigate href="{{ route('providers.edit', ['provider' => $provider->id]) }}" class="card-mobile">
    <div class="card-mobile-icon">
        <i class="fa-regular fa-address-book"></i>
    </div>
    <div class="card-mobile-content">
        <div class="card-mobile-content-left">
            <div class="card-mobile-content-name">{{ $provider->name }}</div>
            <div class="card-mobile-content-subname">{{ $provider->email }}</div>
        </div>
        <div class="card-mobile-content-right">
            <!-- <div class="card-mobile-content-price">{{ $provider->phone }}</div> -->
        </div>
        <div class="card-mobile-content-caret"><i class="fa-solid fa-angle-right"></i></div>
    </div>
</a>