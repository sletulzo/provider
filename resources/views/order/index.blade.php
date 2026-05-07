<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-pencil"></i> {{ __('Commandes effectuées') }}
        </h2>
    </x-slot>

    <div class="table-wrapper">
        <div class="table-wrapper-title">
            <div class="form-group-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search-table" placeholder="Rechercher une commande...">
            </div>
        </div>

        <div class="hidden sm:block">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Articles</th>
                            <th>Date</th>
                            <th>Fournisseur</th>
                            <th>Créateur</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr class="hover:bg-gray-50 transition-all duration-200 line">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $order->id }}</td>
                                <td>Commande</td>
                                <td>{{ $order->lines()->count() }}</td>
                                <td>{{ carbon($order->created_at)->format('d/m/Y') }}</td>
                                <td>{{ $order->provider?->name }}</td>
                                <td>{{ $order->user?->name }}</td>
                                <td class="align-right actions">
                                    <a href="{{ route('orders.products', ['order' => $order->id]) }}" class="ajax-modal"><i class="fa-solid fa-table-cells-large"></i></a>
                                    <a href="{{ route('orders.delete', ['order' => $order->id]) }}"  class="confirm-delete" data-remove="line"><i class="fa-regular fa-trash-can"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile view -->
        <div class="block sm:hidden">
            <div class="card-mobile-container">
                @foreach($orders as $order)
                    @if (Auth::user()->isProvider())
                        @include('order.provider-card', ['order' => $order])
                    @else
                        @include('order.card', ['order' => $order])
                    @endif
                @endforeach
            </div>
        </div>
   </div>
</x-app-layout>
