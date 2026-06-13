<div class="nav-drawer__overlay menu-overlay toggle-burger-menu" id="menuOverlay"></div>

<aside class="nav-drawer burger-menu" id="burgerMenu" aria-label="Menu principal">
    <div class="nav-drawer__hero">
        <button type="button" class="nav-drawer__close toggle-burger-menu" aria-label="Fermer le menu">
            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
        </button>

        <div class="nav-drawer__profile">
            <x-avatar :name="Auth::user()->name" size="lg" class="nav-drawer__avatar" />
            <div class="nav-drawer__greeting">Bonjour,</div>
            <div class="nav-drawer__name">{{ Auth::user()->name }}</div>
            @if (Auth::user()->tenant?->name)
                <span class="nav-drawer__tenant">{{ Auth::user()->tenant->name }}</span>
            @endif
        </div>
    </div>

    <div class="nav-drawer__body">
        @include('layouts.navigations.burger.links.' . Auth::user()->getNavigationSlug())
    </div>

    <div class="nav-drawer__footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-drawer__logout">
                <i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true"></i>
                {{ __('Déconnexion') }}
            </button>
        </form>
    </div>
</aside>
