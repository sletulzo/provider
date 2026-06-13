<div class="nav-drawer__grid">
    <x-nav-link class="nav-drawer__tile" wire:navigate :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        <span class="nav-drawer__tile-icon"><i class="fa-regular fa-house"></i></span>
        <span class="nav-drawer__tile-label">Accueil</span>
    </x-nav-link>
    <x-nav-link class="nav-drawer__tile" wire:navigate :href="route('orders')" :active="request()->routeIs('orders*')">
        <span class="nav-drawer__tile-icon">
            <i class="fa-solid fa-cart-shopping relative">
                @if (Auth::user()->tenant && Auth::user()->tenant->countOrders())
                    <span class="bubble">{{ Auth::user()->tenant->countOrders() }}</span>
                @endif
            </i>
        </span>
        <span class="nav-drawer__tile-label">Commandes</span>
    </x-nav-link>
    <x-nav-link class="nav-drawer__tile" wire:navigate :href="route('products')" :active="request()->routeIs('products*')">
        <span class="nav-drawer__tile-icon"><i class="fa-regular fa-lemon"></i></span>
        <span class="nav-drawer__tile-label">Produits</span>
    </x-nav-link>
    <x-nav-link class="nav-drawer__tile" wire:navigate :href="route('provider.users')" :active="request()->routeIs('provider.users*')">
        <span class="nav-drawer__tile-icon"><i class="fa-solid fa-users-line"></i></span>
        <span class="nav-drawer__tile-label">Clients</span>
    </x-nav-link>
</div>

<div class="nav-drawer__group">
    <div class="nav-drawer__group-title">Compte</div>
    <x-nav-link class="nav-drawer__link" wire:navigate :href="route('profile.edit')" :active="request()->routeIs('profile.*')">
        <i class="fa-regular fa-user"></i>
        <span>Mon profil</span>
        <i class="fa-solid fa-chevron-right nav-drawer__chevron"></i>
    </x-nav-link>
</div>

@if (Auth::user()->is_admin)
    <div class="nav-drawer__group">
        <div class="nav-drawer__group-title">Administration</div>
        <x-nav-link class="nav-drawer__link" wire:navigate :href="route('users')" :active="request()->routeIs('users*')">
            <i class="fa-solid fa-chalkboard-user"></i>
            <span>Utilisateurs</span>
            <i class="fa-solid fa-chevron-right nav-drawer__chevron"></i>
        </x-nav-link>
        <x-nav-link class="nav-drawer__link" wire:navigate :href="route('tenants')" :active="request()->routeIs('tenants*')">
            <i class="fa-regular fa-building"></i>
            <span>Sociétés</span>
            <i class="fa-solid fa-chevron-right nav-drawer__chevron"></i>
        </x-nav-link>
    </div>
@endif
