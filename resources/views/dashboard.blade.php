<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-regular fa-paste"></i> {{ __('Commandes fournisseurs') }}
        </h2>
    </x-slot>

    <div class="flex g-20 m-b-20">
        <div class="col-6">
            <div class="box w-100 m-b-20">
                <div class="box-title">Produits par fournisseur</div>
                <div class="box-content">
                    <form method="POST" action="{{ route('providers.products') }}">
                        @csrf
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Choix du fournisseur</label>
                            <select id="selectProviderProduct" name="provider_id" required>
                                <option value="">Choisir</option>
                                @foreach($providers as $provider)
                                    <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>Liste des produits</label>
                            <div class="container-provider-products"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="box w-100 m-b-20">
                <div class="box-title">
                    <span class="big-bubble">{{ $providerOrders->count() }}</span> Commande en attente
                </div>
                <div class="box-content">
                    @include('section.order-waiting')
                </div>
            </div>
        </div>
    </div>

    <div class="box w-100 m-b-20">
        <div class="box-title">Personnaliser votre envoi de mail</div>
        <div class="box-content">
            @include('section.order-email')
        </div>
    </div>
  
</x-app-layout>
