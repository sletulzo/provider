@php
    $user = Auth::user();
    $isCustomer = $user->isCustomer();

    $pageTitle = match (true) {
        request()->routeIs('dashboard') => 'Accueil',
        request()->routeIs('indents', 'indent.*') => 'Catalogue',
        request()->routeIs('orders*') => 'Commandes',
        request()->routeIs('products*') => 'Produits',
        request()->routeIs('providers*') => 'Fournisseurs',
        request()->routeIs('unities*') => 'Unités',
        request()->routeIs('profile.*') => 'Profil',
        request()->routeIs('users*') => 'Utilisateurs',
        request()->routeIs('tenants*') => 'Sociétés',
        request()->routeIs('provider.users*') => 'Clients',
        default => config('app.name'),
    };

    $contextLabel = $user->tenant?->name
        ?? ($isCustomer ? 'Espace client' : 'Espace fournisseur');

    $actionRoute = $isCustomer ? route('indents') : route('orders');
    $actionIcon = $isCustomer ? 'fa-basket-shopping' : 'fa-cart-shopping';
    $actionLabel = $isCustomer ? 'Catalogue' : 'Commandes';
    $actionCount = $isCustomer
        ? ($user->tenant?->countOrdersWaiting() ?? 0)
        : ($user->tenant?->countOrders() ?? 0);
@endphp

<div class="app-bar">
    <button type="button" class="app-bar__menu toggle-burger-menu" aria-label="Ouvrir le menu" aria-expanded="false">
        <i class="fa-solid fa-bars" aria-hidden="true"></i>
    </button>

    <div class="app-bar__brand">
        <span class="app-bar__logo" aria-hidden="true">V</span>
        <div class="app-bar__titles">
            <span class="app-bar__page">{{ $pageTitle }}</span>
            <span class="app-bar__context">{{ $contextLabel }}</span>
        </div>
    </div>

    <div class="app-bar__actions">
        @if (isset($headerActions))
            <div class="app-bar__legacy-actions">
                {!! $headerActions !!}
            </div>
        @endif

        <a wire:navigate href="{{ $actionRoute }}" class="app-bar__action" aria-label="{{ $actionLabel }}">
            <i class="fa-solid {{ $actionIcon }}" aria-hidden="true"></i>
            @if ($actionCount > 0)
                <span class="app-bar__badge">{{ $actionCount }}</span>
            @endif
        </a>

        <a wire:navigate href="{{ route('profile.edit') }}" class="app-bar__profile" aria-label="Mon profil">
            <x-avatar :name="$user->name" size="sm" />
        </a>
    </div>
</div>
