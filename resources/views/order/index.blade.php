<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-pencil"></i> Commandes effectuées
        </h2>
    </x-slot>

    <livewire:orders-table />

</x-app-layout>