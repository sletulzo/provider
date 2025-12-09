<form class="shop-cart" method="POST" action="{{ route('indent.send', ['provider' => $provider->id]) }}">
    @csrf

    <div class="shop-cart-title">
        Prévisualiser ma commande
        <span class="shop-cart-title-label">{{ $indents->sum('quantity') }} articles</span>
    </div>
    <div class="shop-cart-body">
        <div class="shop-cart-body-preview">
            <div class="shop-cart-body-preview-box">
                <div class="icon"><i class="fa-regular fa-address-book"></i></div>
                <div class="provider">
                    <div>{{ $provider->name }}</div>
                    <span>{{ $provider->email }}</span>
                </div>
            </div>
            <div class="shop-cart-body-preview-bigbox">
                <div class="header">
                    <div>Nouvelle commande</div>
                    <span><i class="fa-regular fa-calendar"></i> {{ carbon()->translatedFormat('l j F') }}</span>
                </div>
                <div class="body">
                    <div class="mb-4">
                        <input name="subject" placeholder="Objet" class="w-100" value="Commande {{ $provider->tenant?->name }} - {{ \Carbon\Carbon::now()->format('d/m/Y') }}">
                    </div>

                    <div class="mb-4">
                        @php ($content = "Bonjour " . $provider->name . ",\nMerci de préparer la commande suivante pour livraison selon vos tournées :")
                        <textarea name="content" placeholder="Objet" rows="3" class="w-100">{{ $content }}</textarea>
                    </div>

                    <div class="preview-products">
                        <table>
                            <tr>
                                <td style="font-weight: bold;">Produits</td>
                                <td style="font-weight: bold;">Quantité</td>
                                <td style="font-weight: bold;">Unité</td>
                            </tr>
                            @foreach($indents as $indent)
                                <tr>
                                    <td>{{ $indent->product?->name }}</td>
                                    <td>{{ $indent->quantity }}</td>
                                    <td>{{ $indent->unity?->name }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>

                    <div class="mt-4">
                        @php ($remerciement = "Merci !\n". Auth::user()->tenant?->name ." \n" . Auth::user()->tenant?->adress)
                        <textarea name="footer" placeholder="Objet" rows="3" class="w-100">{{ $remerciement }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="shop-cart-footer">
        <div class="shop-cart-footer-actions">
            <a href="{{ route('indent.shop-cart', ['provider' => $provider->id]) }}" class="btn-default ajax-modal-up">Annuler</a>
            <button type="submit" class="btn-primary">
                <span class="btn-loader"></span>
                <span class="btn-text">Confirmer et envoyer</span>
            </button>
        </div>
    </div>
</div>