<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Commandes effectués') }}
        </h2>
    </x-slot>

   <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto rounded-xl border border-gray-100">
                        <table class="min-w-full text-sm text-left text-gray-600">
                            <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-semibold">
                                <tr>
                                    <th scope="col" class="px-6 py-3">ID</th>
                                    <th scope="col" class="px-6 py-3">Nom</th>
                                    <th scope="col" class="px-6 py-3">Unité</th>
                                    <th scope="col" class="px-6 py-3">Fournisseur</th>
                                    <th scope="col" class="px-6 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($orders as $order)
                                    <tr class="hover:bg-gray-50 transition-all duration-200">
                                        <td class="px-6 py-4 font-medium text-gray-900">1</td>
                                        <td class="px-6 py-4">{{ $order->id }}</td>
                                        <td class="px-6 py-4">{{ $order->id }}</td>
                                        <td class="px-6 py-4">{{ $order->id }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('products.edit', ['product' => $order->id]) }}" class="ajax-modal px-3 py-1.5 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition">Editer</a>
                                            <a href="{{ route('products.delete', ['product' => $order->id]) }}" class="px-3 py-1.5 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition">Supprimer</a>
                                        </td>
                                    </tr> 
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
   </div>
</x-app-layout>
