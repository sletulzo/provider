<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ Vite::asset('resources/images/logo.png') }}">
    <title>Tarifs — {{ $provider->name }}</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/css/provider-prices.css'])
    <style>
        :root {
            --primary: #0a9f38;
            --primary-dark: #087a2b;
            --secondary: #3ecf7a;
            --primary-bg: #0a9f381a;
            --secondary-bg: #3ecf7a29;
        }
    </style>
</head>
<body class="provider-prices-page">
    <div class="provider-prices">
        <header class="provider-prices-header">
            <div class="provider-prices-logo">{{ config('app.name') }}</div>
            <h1>Vos tarifs</h1>
            <p>{{ $provider->tenant?->name }} · Lien valable 30 jours</p>
        </header>

        <div class="provider-prices-intro">
            <i class="fa-solid fa-tags"></i>
            <div>
                <div class="provider-prices-intro-label">Fournisseur</div>
                <div class="provider-prices-intro-name">{{ $provider->name }}</div>
            </div>
        </div>

        @if ($products->isEmpty())
            <div class="provider-prices-empty">
                <i class="fa-regular fa-lemon"></i>
                <p>Aucun produit n'a encore été ajouté à votre catalogue par le client.</p>
            </div>
        @else
            <form method="POST" action="{{ $submitUrl }}" class="provider-prices-form">
                @csrf

                <div class="provider-prices-section-title">
                    Catalogue produits
                    <span>{{ $products->count() }} produit{{ $products->count() > 1 ? 's' : '' }}</span>
                </div>

                <p class="provider-prices-hint">Laissez un champ vide pour conserver le prix actuel ou ne pas le renseigner.</p>

                <div class="provider-prices-list">
                    @foreach ($products as $product)
                        <div class="provider-prices-line">
                            <div class="provider-prices-line-info">
                                <div class="provider-prices-line-name">{{ $product->name }}</div>
                                @if ($product->unity?->name)
                                    <div class="provider-prices-line-unit">{{ $product->unity->name }}</div>
                                @endif
                            </div>
                            <div class="provider-prices-line-input">
                                <input
                                    type="text"
                                    inputmode="decimal"
                                    name="prices[{{ $product->id }}]"
                                    value="{{ $product->price ? number_format($product->price / 100, 2, '.', '') : '' }}"
                                    placeholder="—"
                                    autocomplete="off"
                                >
                                <span>€</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="provider-prices-actions">
                    <button type="submit" class="provider-prices-btn provider-prices-btn--primary">
                        <i class="fa-solid fa-check"></i> Enregistrer les tarifs
                    </button>
                </div>
            </form>
        @endif
    </div>
</body>
</html>
