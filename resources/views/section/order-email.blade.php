@php ($i = 0)
@php ($j = 0)

<section style="width:100%" id="sectionOrderEmail" data-url="{{ route('section.order-email') }}">
    <div class="tabs">
        <div class="tabs-nav">
            @foreach($orderFormatted as $datum)
                <button data-tab="tab_email_{{ $datum['id'] }}" class="{{ $i == 0 ? 'active' : '' }}">{{ $datum['name'] }}</button>
                @php ($i++)
            @endforeach
        </div>

        <div class="tabs-content">
            @foreach($orderFormatted as $datum)
                <div id="tab_email_{{ $datum['id'] }}" class="tab-pane {{ $j == 0 ? 'active' : '' }}">
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
                @php ($j++)
            @endforeach
        </div>
    </div>
</section>