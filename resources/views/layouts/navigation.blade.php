<div class="nav">
    <div class="nav-title">
        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
        Vinste
    </div>
    <div class="nav-title-separator"></div>
    <nav x-data="{ open: false }">
        <x-nav-link wire:navigate :href="route('indents')" :active="request()->routeIs('indents')">
            <div class="icon"><i class="fa-solid fa-basket-shopping"></i></div>
            {{ __('Commandes') }}
        </x-nav-link>
        <x-nav-link wire:navigate :href="route('providers')" :active="request()->routeIs('providers')">
            <div class="icon"><i class="fa-regular fa-address-book"></i></div>
            {{ __('Fournisseurs') }}
        </x-nav-link>
        <x-nav-link wire:navigate :href="route('products')" :active="request()->routeIs('products')">
            <div class="icon"><i class="fa-regular fa-lemon"></i></div>
            {{ __('Produits') }}
        </x-nav-link>
        <x-nav-link wire:navigate :href="route('orders')" :active="request()->routeIs('orders')">
            <div class="icon"><i class="fa-solid fa-cart-shopping"></i></div>
            {{ __('Commandes effectués') }}
        </x-nav-link>
        <x-nav-link wire:navigate :href="route('unities')" :active="request()->routeIs('unities')">
            <div class="icon"><i class="fa-solid fa-scale-unbalanced-flip"></i></div>
            {{ __('Unités') }}
        </x-nav-link>
    </nav>

    @if (Auth::user()->is_admin)
        <div class="nav-title-separator"></div>
        <nav x-data="{ open: false }">
            <x-nav-link wire:navigate :href="route('users')" :active="request()->routeIs('users')">
                <div class="icon"><i class="fa-regular fa-circle-user"></i></div>
                {{ __('Utilisateurs') }}
            </x-nav-link>
            <x-nav-link wire:navigate :href="route('tenants')" :active="request()->routeIs('tenants')">
                <div class="icon"><i class="fa-regular fa-building"></i></div>
                {{ __('Sociétés') }}
            </x-nav-link>
        </nav>
    @endif
</div>

<!-- Responsive menu -->
<!-------------------------------------------------------------------------------------------->
<div class="nav-mobile-bottom">
    <nav x-data="{ open: false }">
        <x-nav-link class="nav-item" wire:navigate :href="route('providers')" :active="request()->routeIs('providers')">
            <div class="icon"><i class="fa-regular fa-address-book"></i></div>
        </x-nav-link>
        <x-nav-link class="nav-item" wire:navigate :href="route('products')" :active="request()->routeIs('products')">
            <div class="icon"><i class="fa-regular fa-lemon"></i></div>
        </x-nav-link>
        <x-nav-link class="nav-item" wire:navigate :href="route('indents')" :active="request()->routeIs('indents')">
            <div class="icon">
                <i class="fa-solid fa-basket-shopping relative">
                    @if (Auth::user()->tenant && Auth::user()->tenant->countOrders())
                        <span class="bubble">{{ Auth::user()->tenant->countOrders() }}</span>
                    @endif
                </i>
            </div>
        </x-nav-link>
        <x-nav-link class="nav-item" wire:navigate :href="route('orders')" :active="request()->routeIs('orders')">
            <div class="icon"><i class="fa-solid fa-cart-shopping"></i></div>
        </x-nav-link>
        <x-nav-link class="nav-item" wire:navigate :href="route('unities')" :active="request()->routeIs('unities')">
            <div class="icon"><i class="fa-solid fa-scale-unbalanced-flip"></i></div>
        </x-nav-link>
    </nav>
</div>