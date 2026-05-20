<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-regular fa-paste"></i> {{ __('Commandes fournisseur') }}
        </h2>
    </x-slot>

    <div class="table-wrapper">
        <div class="table-wrapper-title">
            <div class="form-group-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search-table" placeholder="Rechercher un fournisseur...">
            </div>
        </div>

        <div class="block sm:hidden">
            <div class="card-mobile-container">
                @foreach($providers as $provider)
                    @include('indent.card', ['provider' => $provider])
                @endforeach
            </div>
        </div>
    </div>

    <!-- <div class="indent-container">
        <div class="indent-container-left">
            <div class="indent-container-left-title">Commande</div>
            <div class="indent-container-left-subtitle">Sélectionnez un fournisseur</div>

            <div class="indent-container-left-list" data-url="{{ route('indent.items') }}">
                @foreach($providers as $i => $provider)
                    @include('indent.card', ['provider' => $provider])
                @endforeach
            </div>
        </div>
        <div class="indent-container-right"></div>
    </div> -->
  
</x-app-layout>
