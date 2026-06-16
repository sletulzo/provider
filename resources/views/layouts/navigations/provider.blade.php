<div class="nav-mobile-bottom">
    <nav x-data="{ open: false }">
        <x-nav-link class="nav-item" wire:navigate :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            <div class="icon"><i class="fa-regular fa-house"></i></div>
            <div class="title">Accueil</div>
        </x-nav-link>
        <x-nav-link class="nav-item" wire:navigate :href="route('products')" :active="request()->routeIs('products*')">
            <div class="icon"><i class="fa-regular fa-lemon"></i></div>
            <div class="title">Produits</div>
        </x-nav-link>
        <x-nav-link class="nav-item nav-fab" wire:navigate :href="route('orders')" :active="request()->routeIs('orders*')">
            <div class="icon">
                <i class="fa-solid fa-cart-shopping relative">
                    @if (Auth::user()->tenant && Auth::user()->tenant->countOrders())
                        <span class="bubble">{{ Auth::user()->tenant->countOrders() }}</span>
                    @endif
                </i>
            </div>
            <div class="title">Commandes</div>
        </x-nav-link>
        <x-nav-link class="nav-item" wire:navigate :href="route('provider.users')" :active="request()->routeIs('provider.users*')">
            <div class="icon"><i class="fa-solid fa-users-line"></i></div>
            <div class="title">Clients</div>
        </x-nav-link>
        <x-nav-link class="nav-item" wire:navigate :href="route('profile.edit')" :active="request()->routeIs('profile.*')">
            <div class="icon"><i class="fa-regular fa-user"></i></div>
            <div class="title">Profil</div>
        </x-nav-link>
    </nav>
</div>
