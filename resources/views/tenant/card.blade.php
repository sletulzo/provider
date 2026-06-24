<a wire:navigate href="{{ route('tenants.edit', ['tenant' => $tenant->id]) }}" class="card-mobile">
    <div class="card-mobile-icon">
        <i class="fa-solid fa-house-chimney-user"></i>
    </div>
    <div class="card-mobile-content">
        <div class="card-mobile-content-left">
            <div class="card-mobile-content-name">{{ $tenant->name }}</div>
            <div class="card-mobile-content-subname">{{ $tenant->smtp_email }}</div>
            <div class="tenant-stat-row">
                <span class="tenant-stat tenant-stat--clients">
                    <span class="tenant-stat__icon"><i class="fa-regular fa-user"></i></span>
                    <span class="tenant-stat__value">{{ $tenant->clients_count }}</span>
                    <span class="tenant-stat__label">client{{ $tenant->clients_count > 1 ? 's' : '' }}</span>
                </span>
                <span class="tenant-stat tenant-stat--providers">
                    <span class="tenant-stat__icon"><i class="fa-solid fa-truck"></i></span>
                    <span class="tenant-stat__value">{{ $tenant->providers_count }}</span>
                    <span class="tenant-stat__label">fourn.</span>
                </span>
            </div>
        </div>
        <div class="card-mobile-content-right">
            <div class="card-mobile-content-price"></div>
        </div>
    </div>
</a>