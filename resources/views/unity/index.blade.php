<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-regular fa-lightbulb"></i> {{ __('Unités de produit') }}
        </h2>
    </x-slot>

    <div class="table-wrapper">
        <div class="table-wrapper-title">
            <input type="text" name="search-table" placeholder="Rechercher une unité...">
            <a href="{{ route('unities.create') }}" class="ajax-modal-up table-wrapper-action" data-method="GET" data-size="large">Créer une unité</a>
        </div>
        
        <div class="hidden sm:block">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th class="align-right"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($unities as $unity)
                            <tr class="hover:bg-gray-50 transition-all duration-200 line">
                                <td class="px-6 py-4">{{ $unity->id }}</td>
                                <td class="px-6 py-4">{{ $unity->name }}</td>
                                <td class="align-right actions">
                                    <a href="{{ route('unities.edit', ['unity' => $unity->id]) }}" class="ajax-modal"><i class="fa-regular fa-pen-to-square"></i></a>
                                    <a href="{{ route('unities.delete', ['unity' => $unity->id]) }}" class="confirm-delete" data-remove="line"><i class="fa-regular fa-trash-can"></i></a>
                                </td>
                            </tr> 
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile view -->
        <div class="block sm:hidden">
            <div class="card-mobile-container">
                @foreach($unities as $unity)
                    @include('unity.card', ['unity' => $unity])
                @endforeach
            </div>
        </div>
   </div>
</x-app-layout>
