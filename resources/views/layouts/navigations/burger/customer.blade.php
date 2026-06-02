<div class="burger-wrapper">
    <button class="burger-btn toggle-burger-menu" id="salut">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <div class="menu-overlay toggle-burger-menu" id="menuOverlay"></div>
    <aside class="burger-menu" id="burgerMenu">

        <div class="menu-header">
            <div class="avatar">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <div>
                <h3>Bonjour {{ Auth::user()->name }}</h3>
                <p>{{ Auth::user()->email }}</p>
                <p>{{ Auth::user()->tenant?->name }}</p>
            </div>
        </div>

        <ul class="menu-links">
            <li>
                <x-nav-link class="nav-item" wire:navigate :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    <div class="icon"><i class="fa-regular fa-house"></i></div>
                    <div class="title">Tableau de bord</div>
                </x-nav-link>
            </li>
            <li>
                <x-nav-link class="nav-item" wire:navigate :href="route('orders')" :active="request()->routeIs('orders')">
                    <div class="icon">
                        <i class="fa-solid fa-cart-shopping relative">
                            @if (Auth::user()->tenant && Auth::user()->tenant->countOrders())
                                <span class="bubble">{{ Auth::user()->tenant->countOrders() }}</span>
                            @endif
                        </i>
                    </div>
                    <div class="title">Commandes</div>
                </x-nav-link>
            </li>
            <li>
                <x-nav-link class="nav-item" wire:navigate :href="route('products')" :active="request()->routeIs('products')">
                    <div class="icon"><i class="fa-regular fa-lemon"></i></div>
                    <div class="title">Produits</div>
                </x-nav-link>
            </li>
            <li>
                <x-nav-link class="nav-item" wire:navigate :href="route('providers')" :active="request()->routeIs('providers')">
                    <div class="icon"><i class="fa-regular fa-address-book"></i></div>
                    <div class="title">Fournisseurs</div>
                </x-nav-link>
            </li>
            <li>
                <x-nav-link class="nav-item" wire:navigate :href="route('unities')" :active="request()->routeIs('unities')">
                    <div class="icon"><i class="fa-solid fa-scale-unbalanced-flip"></i></div>
                    <div class="title">Unités de mesure</div>
                </x-nav-link>
            </li>
            <li class="divider"></li>
            <li>
                <x-nav-link class="nav-item" wire:navigate :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                    <div class="icon"><i class="fa-regular fa-user"></i></div>
                    <div class="title">Profil</div>
                </x-nav-link>
            </li>
            @if (Auth::user()->is_admin)
                <li>
                    <x-nav-link class="nav-item" wire:navigate :href="route('users')" :active="request()->routeIs('users')">
                        <div class="icon"><i class="fa-solid fa-chalkboard-user"></i></div>
                        <div class="title">{{ __('Utilisateurs') }}</div>
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link class="nav-item" wire:navigate :href="route('tenants')" :active="request()->routeIs('tenants')">
                        <div class="icon"><i class="fa-regular fa-building"></i></div>
                        <div class="title">{{ __('Sociétés') }}</div>
                    </x-nav-link>
                </li>
            @endif
            <li class="divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> {{ __('Déconnexion') }}
                    </button>
                </form>
            </li>
        </ul>
    </aside>
</div>