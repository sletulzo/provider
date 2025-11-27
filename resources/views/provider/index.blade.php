<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-regular fa-address-book"></i> {{ __('Fournisseurs') }}
        </h2>
    </x-slot>

    <div class="table-wrapper">
        <div class="table-wrapper-title">
            <input type="text" name="search-table" placeholder="Rechercher un fournisseur...">
            <a href="{{ route('providers.create') }}" class="ajax-modal table-wrapper-action">Créer un fournisseur</a>
        </div>

        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="px-6 py-3">Nom</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Téléphone</th>
                        <th scope="col" class="px-6 py-3 align-right"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($providers as $provider)
                        <tr class="hover:bg-gray-50 transition-all duration-200 line">
                            <td>{{ $provider->name }}</td>
                            <td>{{ $provider->email }}</td>
                            <td>{{ $provider->phone }}</td>
                            <td class="align-right actions">
                                <a href="{{ route('providers.edit', ['provider' => $provider->id]) }}" class="ajax-modal"><i class="fa-regular fa-pen-to-square"></i></a>
                                <a href="{{ route('providers.delete', ['provider' => $provider->id]) }}" class="confirm-delete" data-remove="line"><i class="fa-regular fa-trash-can"></i></a>
                            </td>
                        </tr> 
                    @endforeach
                </tbody>
            </table>
        </div>
   </div>
</x-app-layout>
