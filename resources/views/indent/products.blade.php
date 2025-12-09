<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-regular fa-paste"></i> {{ __('Test steven') }}
        </h2>
    </x-slot>

    <div class="indent-container">
        <div class="indent-container-header">
            <a wire:navigate href="{{ route('indents') }}"><i class="fa-solid fa-arrow-left"></i></a>
            <div class="indent-container-header-title">
                <div>{{ $provider->name }}</div>
                <span>{{ $provider->email }}</span>
            </div>
            <div class="indent-container-header-search">
                <input type="text" name="search" placeholder="Rechercher...">
            </div>
        </div>

        <div class="indent-container-right">
            @include('indent.items')
        </div>
    </div>
  
</x-app-layout>
