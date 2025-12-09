<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-regular fa-paste"></i> {{ __('Commandes fournisseur') }}
        </h2>
    </x-slot>


    <div class="indent-container">
        <div class="indent-container-left">
            <div class="indent-container-left-title">Commande</div>
            <div class="indent-container-left-subtitle">Sélectionnez un fournisseur</div>

            <div class="indent-container-left-list" data-url="{{ route('indent.items') }}">
                @foreach($providers as $i => $provider)
                    <a wire:navigate href="{{ route('indent.products', ['provider' => $provider->id]) }}" class="indent-container-left-item" data-provider="{{ $provider->id }}">
                        <div class="indent-container-left-item-icon"><i class="fa-regular fa-address-book"></i></div>
                        <div class="indent-container-left-item-name">
                            <div class="name">{{ $provider->name }}</div>
                            <div class="email">{{ $provider->email }}</div>
                        </div>
                        @if ($provider->sumOrderWaitings())
                            <div class="indent-container-left-item-count">{{ $provider->sumOrderWaitings() }}</div>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
        <div class="indent-container-right"></div>
    </div>
  
</x-app-layout>
