<a href="{{ route('providers.edit', ['provider' => $provider->id]) }}" data-method="GET" data-size="large" class="card-mobile ajax-modal-up">
    <div class="card-mobile-icon">
        <i class="fa-regular fa-address-book"></i>
    </div>
    <div class="card-mobile-content">
        <div class="card-mobile-content-left">
            <div class="card-mobile-content-name">{{ $provider->name }}</div>
            <div class="card-mobile-content-subname">{{ $provider->email }}</div>
        </div>
        <div class="card-mobile-content-right">
            <div class="card-mobile-content-price">{{ $provider->phone }}</div>
        </div>
    </div>
</a>