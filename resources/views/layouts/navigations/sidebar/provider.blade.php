<aside class="app-sidebar" aria-label="Navigation principale">
    <div class="app-sidebar__brand">
        <span class="app-sidebar__logo">V</span>
        <span class="app-sidebar__name">{{ config('app.name') }}</span>
    </div>
    <nav class="app-sidebar__nav">
        <x-nav-link wire:navigate :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            <i class="fa-regular fa-house"></i> Accueil
        </x-nav-link>
        <x-nav-link wire:navigate :href="route('orders')" :active="request()->routeIs('orders*')">
            <i class="fa-solid fa-cart-shopping"></i> Commandes
        </x-nav-link>
        <x-nav-link wire:navigate :href="route('products')" :active="request()->routeIs('products*')">
            <i class="fa-regular fa-lemon"></i> Produits
        </x-nav-link>
        <x-nav-link wire:navigate :href="route('provider.users')" :active="request()->routeIs('provider.users*')">
            <i class="fa-solid fa-users-line"></i> Clients
        </x-nav-link>
        <x-nav-link wire:navigate :href="route('profile.edit')" :active="request()->routeIs('profile.*')">
            <i class="fa-regular fa-user"></i> Profil
        </x-nav-link>
    </nav>
</aside>
