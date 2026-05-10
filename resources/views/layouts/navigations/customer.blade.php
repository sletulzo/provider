<div class="nav-mobile-bottom">
    <nav x-data="{ open: false }">
        <x-nav-link class="nav-item" wire:navigate :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            <div class="icon"><i class="fa-regular fa-house"></i></div>
            <div class="title">Accueil</div>
        </x-nav-link>
        <x-nav-link class="nav-item" wire:navigate :href="route('indents')" :active="request()->routeIs('indents')">
            <div class="icon">
                <i class="fa-solid fa-basket-shopping relative">
                    @if (Auth::user()->tenant && Auth::user()->tenant->countOrdersWaiting())
                        <span class="bubble">{{ Auth::user()->tenant->countOrdersWaiting() }}</span>
                    @endif
                </i>
            </div>
            <div class="title">Catalogue</div>
        </x-nav-link>
        <x-nav-link class="nav-item" wire:navigate :href="route('orders')" :active="request()->routeIs('orders')">
            <div class="icon"><i class="fa-solid fa-cart-shopping"></i></div>
            <div class="title">Commandes</div>
        </x-nav-link>
        <x-nav-link class="nav-item" wire:navigate :href="route('unities')" :active="request()->routeIs('unities')">
            <div class="icon"><i class="fa-regular fa-user"></i></div>
            <div class="title">Profil</div>
        </x-nav-link>
    </nav>
</div>