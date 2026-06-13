<div class="nav-drawer__grid">
    <x-nav-link class="nav-drawer__tile" wire:navigate :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        <span class="nav-drawer__tile-icon"><i class="fa-regular fa-house"></i></span>
        <span class="nav-drawer__tile-label">Accueil</span>
    </x-nav-link>
    <x-nav-link class="nav-drawer__tile" wire:navigate :href="route('indents')" :active="request()->routeIs('indents', 'indent.*')">
        <span class="nav-drawer__tile-icon"><i class="fa-solid fa-basket-shopping"></i></span>
        <span class="nav-drawer__tile-label">Catalogue</span>
    </x-nav-link>
    <x-nav-link class="nav-drawer__tile" wire:navigate :href="route('orders')" :active="request()->routeIs('orders*')">
        <span class="nav-drawer__tile-icon"><i class="fa-solid fa-cart-shopping"></i></span>
        <span class="nav-drawer__tile-label">Commandes</span>
    </x-nav-link>
    <x-nav-link class="nav-drawer__tile" wire:navigate :href="route('products')" :active="request()->routeIs('products*')">
        <span class="nav-drawer__tile-icon"><i class="fa-regular fa-lemon"></i></span>
        <span class="nav-drawer__tile-label">Produits</span>
    </x-nav-link>
</div>

@if (! Auth::user()->is_only_order)
    <div class="nav-drawer__group">
        <div class="nav-drawer__group-title">Gestion</div>
        <x-nav-link class="nav-drawer__link" wire:navigate :href="route('providers')" :active="request()->routeIs('providers*')">
            <i class="fa-regular fa-address-book"></i>
            <span>Fournisseurs</span>
            <i class="fa-solid fa-chevron-right nav-drawer__chevron"></i>
        </x-nav-link>
        <x-nav-link class="nav-drawer__link" wire:navigate :href="route('unities')" :active="request()->routeIs('unities*')">
            <i class="fa-solid fa-scale-unbalanced-flip"></i>
            <span>Unités de mesure</span>
            <i class="fa-solid fa-chevron-right nav-drawer__chevron"></i>
        </x-nav-link>
    </div>
@endif

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
            <i class="fa-solid fa-user-group"></i>
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
