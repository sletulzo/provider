<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-regular fa-building"></i> {{ __('Sociétés') }}
        </h2>
    </x-slot>

   <div class="table-wrapper">
        <div class="table-wrapper-title">
            <input type="text" name="search-table" placeholder="Rechercher une société...">
            <a href="{{ route('tenants.create') }}" class="ajax-modal table-wrapper-action">Créer une société</a>
        </div>

        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Domaine</th>
                        <th class="align-center">Active</th>
                        <th>Crée le</th>
                        <th class="align-right"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tenants as $tenant)
                        <tr class="hover:bg-gray-50 transition-all duration-200 {{ $tenant->is_locked ? 'tr-locked' : '' }}">
                            <td class="px-6 py-4">{{ $tenant->name }}</td>
                            <td class="px-6 py-4">{{ $tenant->domain }}</td>
                            <td class="px-6 py-4 align-center">
                                @if (!$tenant->is_locked)
                                    <i class="fa-regular fa-circle-check"></i>
                                @else
                                    <i class="fa-solid fa-lock"></i>
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ carbon($tenant->created_at)->format('d/m/Y') }}</td>
                            <td class="align-right actions">
                                <a href="{{ route('tenants.edit', ['tenant' => $tenant->id]) }}" class="ajax-modal"><i class="fa-regular fa-pen-to-square"></i></a>
                                <a href="{{ route('tenants.delete', ['tenant' => $tenant->id]) }}"><i class="fa-regular fa-trash-can"></i></a>
                            </td>
                        </tr> 
                    @endforeach
                </tbody>
            </table>
        </div>
   </div>
</x-app-layout>