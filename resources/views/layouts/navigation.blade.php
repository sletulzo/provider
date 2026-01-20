

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