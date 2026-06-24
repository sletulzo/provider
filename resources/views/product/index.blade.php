<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-regular fa-lemon"></i> {{ __('Produits') }}
        </h2>
    </x-slot>

    @if (!Auth::user()->is_only_order)
        <x-slot name="headerActions">
            <a wire:navigate href="{{ route('products.create') }}" class="table-wrapper-action"><i class="fa-solid fa-plus"></i></a>
        </x-slot>
    @endif

    <div class="table-wrapper">
        <div class="table-wrapper-title">
            <div class="form-group-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search-table" placeholder="Rechercher un produit...">
            </div>
        </div>

        @php($productCount = $providers->sum(fn ($provider) => $provider->products->count()))

        @if ($productCount === 0)
            <x-empty-state
                icon="fa-regular fa-lemon"
                title="Aucun produit"
                :description="Auth::user()->is_only_order
                    ? 'Aucun produit n\'a encore été ajouté à votre catalogue.'
                    : 'Ajoutez votre premier produit pour pouvoir le commander auprès de vos fournisseurs.'"
                :action="Auth::user()->is_only_order ? null : 'Ajouter un produit'"
                :href="Auth::user()->is_only_order ? null : route('products.create')"
                :modal="!Auth::user()->is_only_order"
            />
        @else
            <div class="hidden sm:block">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Unité</th>
                                <th>Fournisseur</th>
                                <th class="align-center">Quantité min</th>
                                <th class="align-center">Quantité étape</th>
                                <th class="align-center">Prix</th>
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
                                        <td class="align-center">{{ $product->price ? $product->price / 100 . '€' : '' }}</td>
                                        <td class="align-right actions">
                                            @if (!Auth::user()->is_only_order)
                                                <a wire:navigate href="{{ route('products.edit', ['product' => $product->id]) }}"><i class="fa-regular fa-pen-to-square"></i></a>
                                                <a href="{{ route('products.delete', ['product' => $product->id]) }}" class="confirm-delete" data-remove="line"><i class="fa-regular fa-trash-can"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="block sm:hidden">
                <div class="card-mobile-container">
                    @foreach($providers as $provider)
                        <div class="card-mobile-separator">{{ $provider->name }}</div>
                        @foreach($provider->products->sortBy('name') as $product)
                            @include('product.card', ['product' => $product])
                        @endforeach
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
