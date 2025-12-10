<a href="{{ route('users.edit', ['user' => $user->id]) }}" data-method="GET" data-size="large" class="card-mobile ajax-modal-up">
    <div class="card-mobile-icon">
        <i class="fa-regular fa-user"></i>
    </div>
    <div class="card-mobile-content">
        <div class="card-mobile-content-left">
            <div class="card-mobile-content-name">{{ $user->name }}</div>
            <div class="card-mobile-content-subname">{{ $user->email }}</div>
        </div>
        <div class="card-mobile-content-right">
            <div class="card-mobile-content-price">{{ $user->tenant?->name }}</div>
        </div>
    </div>
</a>