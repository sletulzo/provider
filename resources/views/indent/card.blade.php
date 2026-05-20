@php ($sumOrderWaiting = $provider->sumOrderWaitings())

<a wire:navigate href="{{ route('indent.products', ['provider' => $provider->id]) }}" class="card-mobile {{ $sumOrderWaiting ? 'card-mobile-primary' : '' }}" data-provider="{{ $provider->id }}">
    <div class="card-mobile-icon">
        <i class="fa-regular fa-address-book"></i>
    </div>
    <div class="card-mobile-content">
        <div class="card-mobile-content-left">
            <div class="card-mobile-content-name">{{ $provider->name }}</div>
            <div class="card-mobile-content-subname">{{ $provider->email }}</div>
        </div>
        <div class="card-mobile-content-right">
            @if ($sumOrderWaiting)
                <div class="card-mobile-content-counter">{{ $sumOrderWaiting }}</div>
            @endif
        </div>
        <div class="card-mobile-content-caret"><i class="fa-solid fa-angle-right"></i></div>
    </div>
</a>