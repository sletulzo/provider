<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-regular fa-address-book"></i> {{ __('Fournisseurs') }}
        </h2>
    </x-slot>

    @if (!Auth::user()->is_only_order)
        <x-slot name="headerActions">
            <a wire:navigate href="{{ route('providers.create') }}" class="table-wrapper-action"><i class="fa-solid fa-plus"></i></a>
        </x-slot>
    @endif

    <div class="table-wrapper">
        <div class="table-wrapper-title">
            <div class="form-group-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search-table" placeholder="Rechercher un produit...">
            </div>
        </div>

        @if ($providers->isEmpty())
            <x-empty-state
                icon="fa-regular fa-address-book"
                title="Aucun fournisseur"
                :description="Auth::user()->is_only_order
                    ? 'Aucun fournisseur n\'a encore été configuré pour votre société.'
                    : 'Ajoutez votre premier fournisseur pour commencer à passer des commandes.'"
                :action="Auth::user()->is_only_order ? null : 'Ajouter un fournisseur'"
                :href="Auth::user()->is_only_order ? null : route('providers.create')"
                :modal="!Auth::user()->is_only_order"
            />
        @else
            <div class="hidden sm:block">
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
                                        @if (!Auth::user()->is_only_order)
                                            <a wire:navigate href="{{ route('providers.edit', ['provider' => $provider->id]) }}"><i class="fa-regular fa-pen-to-square"></i></a>
                                            <a href="{{ route('providers.delete', ['provider' => $provider->id]) }}" class="confirm-delete" data-remove="line"><i class="fa-regular fa-trash-can"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="block sm:hidden">
                <div class="card-mobile-container">
                    @foreach($providers as $provider)
                        @include('provider.card', ['provider' => $provider])
                    @endforeach
                </div>
            </div>
        @endif
   </div>
</x-app-layout>
