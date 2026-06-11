<x-app-layout>
    <x-slot name="headerActions">
        <a href="{{ route('indents') }}" class="table-wrapper-action relative">
            <i class="fa-solid fa-cart-shopping">
                @if (Auth::user()->tenant && Auth::user()->tenant->countOrdersWaiting())
                    <span class="bubble">{{ Auth::user()->tenant->countOrdersWaiting() }}</span>
                @endif
            </i>
        </a>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-pencil"></i> Commandes effectuées
        </h2>
    </x-slot>

    <livewire:orders-table />

</x-app-layout>