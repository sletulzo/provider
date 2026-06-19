<a href="{{ route('tenants.edit', ['tenant' => $tenant->id]) }}" data-method="GET" data-size="large" class="card-mobile ajax-modal-up">
    <div class="card-mobile-icon">
        <i class="fa-solid fa-house-chimney-user"></i>
    </div>
    <div class="card-mobile-content">
        <div class="card-mobile-content-left">
            <div class="card-mobile-content-name">{{ $tenant->name }}</div>
            <div class="card-mobile-content-subname">{{ $tenant->smtp_email }}</div>
            <div class="tenant-count-row">
                <span class="tenant-count tenant-count--clients"><i class="fa-regular fa-user"></i> {{ $tenant->clients_count }} client{{ $tenant->clients_count > 1 ? 's' : '' }}</span>
                <span class="tenant-count tenant-count--providers"><i class="fa-regular fa-building"></i> {{ $tenant->providers_count }} fourn.</span>
            </div>
        </div>
        <div class="card-mobile-content-right">
            <div class="card-mobile-content-price"></div>
        </div>
    </div>
</a>