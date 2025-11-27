<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-regular fa-lemon"></i> {{ __('Produits') }}
        </h2>
    </x-slot>

    <div class="table-wrapper">
        <div class="table-wrapper-title">
            <input type="text" name="search-table" placeholder="Rechercher un produit...">
            <a href="{{ route('products.create') }}" class="ajax-modal table-wrapper-action">Créer un produit</a>
        </div>

        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Unité</th>
                        <th>Fournisseur</th>
                        <th class="align-center">Quantité min</th>
                        <th class="align-center">Quantité étape</th>
                        <th class="align-right"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($providers as $provider)
                        <tr class="parent-tr">
                            <td colspan="6">{{ $provider->name }}</td>
                        </tr>
                        @foreach($provider->products->sortBy('name') as $product)
                            <tr class="child hover:bg-gray-50 transition-all duration-200 line">
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->unity?->name }}</td>
                                <td>{{ $product->provider?->name }}</td>
                                <td class="align-center">{{ $product->quantity_min }}</td>
                                <td class="align-center">{{ $product->quantity_step }}</td>
                                <td class="align-right actions">
                                    <a href="{{ route('products.edit', ['product' => $product->id]) }}" class="ajax-modal"><i class="fa-regular fa-pen-to-square"></i></a>
                                    <a href="{{ route('products.delete', ['product' => $product->id]) }}" class="confirm-delete" data-remove="line"><i class="fa-regular fa-trash-can"></i></a>
                                </td>
                            </tr> 
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
