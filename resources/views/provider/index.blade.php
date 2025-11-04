<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Fournisseurs') }}
        </h2>
    </x-slot>

   <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="bg-white p-6 rounded-2xl shadow-sm">
                            <a href="{{ route('providers.create') }}"
                                class="ajax-modal inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow transition">
                                + Créer un fournisseur
                            </a>
                        </div>

                        <div class="overflow-x-auto rounded-xl border border-gray-100">
                            <table class="min-w-full text-sm text-left text-gray-600">
                                <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-semibold">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">ID</th>
                                        <th scope="col" class="px-6 py-3">Nom</th>
                                        <th scope="col" class="px-6 py-3">Email</th>
                                        <th scope="col" class="px-6 py-3">Téléphone</th>
                                        <th scope="col" class="px-6 py-3 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($providers as $provider)
                                        <tr class="hover:bg-gray-50 transition-all duration-200">
                                            <td class="px-6 py-4 font-medium text-gray-900">1</td>
                                            <td class="px-6 py-4">{{ $provider->name }}</td>
                                            <td class="px-6 py-4">{{ $provider->email }}</td>
                                            <td class="px-6 py-4">{{ $provider->phone }}</td>
                                            <td class="px-6 py-4 text-right">
                                                <a href="{{ route('providers.edit', ['provider' => $provider->id]) }}" class="ajax-modal"><i class="fa-solid fa-pencil"></i></a>
                                                <a href="{{ route('providers.delete', ['provider' => $provider->id]) }}"><i class="fa-solid fa-trash"></i></a>
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
   </div>
</x-app-layout>
