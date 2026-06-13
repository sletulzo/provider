<aside class="app-sidebar" aria-label="Navigation principale">
    <div class="app-sidebar__brand">
        <span class="app-sidebar__logo">V</span>
        <span class="app-sidebar__name">{{ config('app.name') }}</span>
    </div>
    <nav class="app-sidebar__nav">
        <x-nav-link wire:navigate :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            <i class="fa-regular fa-house"></i> Accueil
        </x-nav-link>
        <x-nav-link wire:navigate :href="route('indents')" :active="request()->routeIs('indents') || request()->routeIs('indent.*')">
            <i class="fa-solid fa-basket-shopping"></i> Catalogue
        </x-nav-link>
        <x-nav-link wire:navigate :href="route('orders')" :active="request()->routeIs('orders*')">
            <i class="fa-solid fa-cart-shopping"></i> Commandes
        </x-nav-link>
        <x-nav-link wire:navigate :href="route('products')" :active="request()->routeIs('products*')">
            <i class="fa-regular fa-lemon"></i> Produits
        </x-nav-link>
        @if (! Auth::user()->is_only_order)
            <x-nav-link wire:navigate :href="route('providers')" :active="request()->routeIs('providers*')">
                <i class="fa-regular fa-address-book"></i> Fournisseurs
            </x-nav-link>
        @endif
    </nav>
</aside>
