<a href="{{ route('unities.edit', ['unity' => $unity->id]) }}" data-method="GET" class="card-mobile ajax-modal-up">
    <div class="card-mobile-icon">
        <i class="fa-solid fa-scale-unbalanced-flip"></i>
    </div>
    <div class="card-mobile-content">
        <div class="card-mobile-content-left">
            <div class="card-mobile-content-name">{{ $unity->name }}</div>
            <div class="card-mobile-content-subname">{{ $unity->email }}</div>
        </div>
        <div class="card-mobile-content-right">
            <div class="card-mobile-content-price">{{ $unity->phone }}</div>
        </div>
    </div>
</a>