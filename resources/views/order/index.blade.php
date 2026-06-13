<x-app-layout>
    <div class="orders-list-page">
        <div class="orders-list-page__header">
            <div>
                <p class="orders-list-page__context">{{ Auth::user()->isProvider() ? 'Espace fournisseur' : 'Espace client' }}</p>
                <h1 class="orders-list-page__title">Commandes</h1>
            </div>
            @if (Auth::user()->isCustomer())
                <a wire:navigate href="{{ route('indents') }}" class="orders-list-page__action" aria-label="Catalogue">
                    <i class="fa-solid fa-basket-shopping"></i>
                </a>
            @endif
        </div>

        <livewire:orders-table />
    </div>
</x-app-layout>
