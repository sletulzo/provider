<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-regular fa-lightbulb"></i> {{ __('Unités de produit') }}
        </h2>
    </x-slot>

   <div class="table-wrapper">
        <div class="table-wrapper-title">
            <input type="text" name="search-table" placeholder="Rechercher une unité...">
            <a href="{{ route('unities.create') }}" class="ajax-modal table-wrapper-action">Créer une unité</a>
        </div>

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
                    <tr class="hover:bg-gray-50 transition-all duration-200" class="line">
                        <td class="px-6 py-4">{{ $unity->id }}</td>
                        <td class="px-6 py-4">{{ $unity->name }}</td>
                        <td class="align-right actions">
                            <a href="{{ route('unities.edit', ['unity' => $unity->id]) }}" class="ajax-modal"><i class="fa-regular fa-pen-to-square"></i></a>
                            <a href="{{ route('unities.delete', ['unity' => $unity->id]) }}"  class="confirm-delete" data-remove="line"><i class="fa-regular fa-trash-can"></i></a>
                        </td>
                    </tr> 
                @endforeach
            </tbody>
        </table>
   </div>
</x-app-layout>
