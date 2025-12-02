<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-regular fa-paste"></i> {{ __('Test steven') }}
        </h2>
    </x-slot>

    <div class="indent-container">
        <div class="indent-container-header">
            <a wire:navigate href="{{ route('dashboard.test') }}"><i class="fa-solid fa-arrow-left"></i></a>
            <div class="indent-container-header-title">
                <div>{{ $provider->name }}</div>
                <span>{{ $provider->email }}</span>
            </div>
            <div class="indent-container-header-search">
                <input type="text" name="search" placeholder="Rechercher...">
            </div>
        </div>

        <div class="indent-container-right">
            @foreach($products as $product)
                <div class="indent-container-right-item {{ $product->quantity ? 'active' : '' }}">
                    <div class="indent-container-right-item-body">
                        <div class="indent-container-right-item-icon"><i class="fa-solid fa-cube"></i></div>
                        <div class="indent-container-right-item-name">
                            <div class="name">{{ $product->name }}</div>
                            <div class="description">{{ $product->unity?->name }}</div>
                        </div>
                        <div class="indent-container-right-item-price">{{ $product->price ? $product->price / 100 . '€' : '' }}</div>
                    </div>
                    <div class="indent-container-right-item-footer">
                        <div class="indent-container-right-item-actions">
                            <div class="updown" data-url="{{ route('dashboard.quantities', ['product' => $product->id]) }}">
                                <button data-type="remove" class="trigger-updown"><i class="fa-solid fa-minus"></i></button>
                                <span class="updown-display">{{ $product->quantity ?? 0 }}</span>
                                <button data-type="add" class="trigger-updown"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="indent-container-right-item-total">{{ $product->total ? $product->total / 100 . '€' : '' }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
  
</x-app-layout>
