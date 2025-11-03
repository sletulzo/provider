<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('📦 Commandes fournisseurs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="row">
                        <section style="width: 100%">
                            <h2>Produits à commander</h2>

                            <form method="POST" action="{{ route('order-waiting.save') }}">
                                @csrf
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Choix du produit</label>
                                    <select class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 orderwaiting-update-product" name="product_id" required>
                                        <option value="">Choisir</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" data-provider="{{ $product->provider_id }}" data-unity="{{ $product->unity_id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div style="flex: 1 1 auto">
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Choix de l'unité</label>
                                        <select class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" name="unity_id" required>
                                            <option value="">Choisir</option>
                                            @foreach($unities as $unity)
                                                <option value="{{ $unity->id }}">{{ $unity->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div style="flex: 1 1 auto">
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Choix du fournisseur</label>
                                        <select class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" name="provider_id" required>
                                            <option value="">Choisir</option>
                                            @foreach($providers as $provider)
                                                <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                                    <input type="number" step="0.01" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" name="quantity" required>
                                </div>

                                <div class="flex justify-end pt-2">
                                    <button type="submit"
                                            class="ml-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition">
                                        Ajouter à la commande
                                    </button>
                                </div>
                            </form>
                        </section>
                        
                        <section style="width: 100%">
                            <h2><span class="big-bubble">{{ $providerOrders->count() }}</span> Commande en attente</h2>
                            @foreach($providerOrders as $providerId => $data)
                                @php ($provider = \App\Models\Provider::find($providerId))
                                    <h2>{{ $provider->name }}</h2>
                                    <div class="overflow-x-auto rounded-xl border border-gray-100 m-b-20">
                                        <table class="min-w-full text-sm text-left text-gray-600 layout-fixed">
                                            <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-semibold">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3" style="width:20%">Produit</th>
                                                    <th scope="col" class="px-6 py-3" width="120px">Quantité</th>
                                                    <th scope="col" class="px-6 py-3">Unité</th>
                                                    <th scope="col" class="px-6 py-3">Fournisseur</th>
                                                    <th scope="col" class="px-6 py-3 text-right"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-100">
                                                @foreach($data as $datum)
                                                    <tr class="hover:bg-gray-50 transition-all duration-200">
                                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $datum->product?->name }}</td>
                                                        <td class="px-6 py-4 nopaddingtb">
                                                            <input type="number" value="{{ $datum->quantity }}">
                                                        </td>
                                                        <td class="px-6 py-4">{{ $datum->unity?->name }}</td>
                                                        <td class="px-6 py-4">{{ $datum->provider?->name }}</td>
                                                        <td class="px-6 py-4 text-right">
                                                            <a href="{{ route('order-waiting.delete', ['orderWaiting' => $datum->id]) }}" class="px-3 py-1.5 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition">Supprimer</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                <!-- </div> -->
                            @endforeach
                        </section>

                        <section style="width:100%">
                            <h2>Personnaliser votre envoi de mail</h2>
                                <div class="md:flex" style="width:100%">
                                <div class="nav-tabs md:flex" style="width:100%">
                                    <ul class="flex-column space-y space-y-4 text-sm font-medium text-gray-500 dark:text-gray-400 md:me-4 mb-4 md:mb-0">
                                        @foreach($orderFormatted as $datum)
                                            <li>
                                                <a href="#provider_{{ $datum['id'] }}" class="inline-flex items-center px-4 py-3 text-white bg-blue-700 rounded-lg active w-full dark:bg-blue-600" aria-current="page">
                                                    <svg class="w-4 h-4 me-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
                                                    </svg>
                                                    {{ $datum['name'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="p-6 text-medium bg-gray-50 text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg w-full">
                                        <div class="tab-content">
                                            @foreach($orderFormatted as $datum)
                                                <div class="tab-pane" id="provider_{{ $datum['id'] }}">
                                                    <h2>Modèle d'email {{ $datum['name'] }}</h2>
                                                    <div class="muted">Ces champs seront fusionnés.</div>
                                                    
                                                    <form method="POST" action="{{ route('orders.save', ['provider' => $datum['id']]) }}">
                                                        @csrf
                                                        <div class="grid mb-4" style="margin-top:8px">
                                                            <input id="tplSubject" name="subject" placeholder="Objet" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" value="Commande la misaine - {{ \Carbon\Carbon::now()->format('d/m/Y') }}">
                                                        </div>

                                                        <div class="muted">Contenu de l'email</div>
                                                        <div class="mb-4 mt-2">
                                                            <div class="quill-editor" style="height: 230px;">{{ $datum['email_content'] ?? '' }}
                                                                @if ($datum['email_content'])
                                                                    {!! $datum['email_content'] !!}
                                                                @else
                                                                    Bonjour {{ $datum['name'] }}, <br>Merci de préparer la commande suivante pour livraison selon vos tournées : 
                                                                @endif
                                                                <p><br></p>
                                                                <table border="1" cellpadding="6" cellspacing="0" style="border-collapse:collapse;">
                                                                    <tr>
                                                                        <td style="font-weight: bold;">Produits</td>
                                                                        <td style="font-weight: bold;">Quantité</td>
                                                                        <td style="font-weight: bold;">Unité</td>
                                                                    </tr>
                                                                    @foreach($datum['items'] as $item)
                                                                        <tr>
                                                                            <td>{{ $item['product'] }}</td>
                                                                            <td>{{ $item['quantity'] }}</td>
                                                                            <td>{{ $item['unity'] }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </table>

                                                                <p><br></p>
                                                                <p>Merci !</p>
                                                                <p>La Misaine</p>
                                                                <p>Port de Sainte-Marine</p>
                                                            </div>
                                                            <input type="hidden" name="email_content">
                                                        </div>
                                                        
                                                        <div class="flex justify-end pt-2">
                                                            <button type="submit"
                                                                    class="ml-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition">
                                                                Envoyer
                                                            </button>
                                                        </div>
                                                    </form>
                                                    
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
