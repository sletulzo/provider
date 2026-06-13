<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <link rel="icon" href="{{ Vite::asset('resources/images/logo.png') }}">
    <title>Réponse enregistrée — {{ config('app.name') }}</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/css/order-response.css'])
    <style>
        :root {
            --primary: #0a9f38;
            --primary-dark: #087a2b;
            --secondary: #3ecf7a;
            --primary-bg: #0a9f381a;
        }
    </style>
</head>
<body class="order-response-page">
    <div class="order-response order-response--done">
        <div class="order-response-done-icon status-badge status-badge--{{ $status['slug'] }}">
            @if ($status['slug'] === 'refused')
                <i class="fa-solid fa-ban"></i>
            @elseif ($status['slug'] === 'partial')
                <i class="fa-solid fa-circle-half-stroke"></i>
            @else
                <i class="fa-solid fa-check"></i>
            @endif
        </div>

        <h1>{{ $status['label'] }}</h1>
        <p class="order-response-done-sub">Commande CMD-{{ $order->id }} — votre réponse a bien été enregistrée.</p>

        @if ($order->provider_note)
            <div class="order-response-done-note">
                <strong>Votre message</strong>
                <p>{{ $order->provider_note }}</p>
            </div>
        @endif

        <div class="order-response-section-title">Récapitulatif</div>
        <div class="order-response-lines">
            @foreach ($order->lines as $line)
                @php ($lineStatus = $line->getStatus())
                <div class="order-response-line order-response-line--readonly order-response-line--{{ $lineStatus['slug'] }}">
                    <div class="order-response-line-info">
                        <div class="order-response-line-name">{{ $line->product?->name }}</div>
                        <div class="order-response-line-meta">{{ $line->quantity }} {{ $line->unity?->name ?? 'unité' }}</div>
                    </div>
                    <span class="status-badge status-badge--{{ $lineStatus['slug'] === 'missing' ? 'missing' : ($lineStatus['slug'] === 'accepted' ? 'accepted' : 'waiting') }}">
                        {{ $lineStatus['label'] }}
                    </span>
                </div>
            @endforeach
        </div>

        @if (!empty($backUrl))
            <a href="{{ $backUrl }}" class="order-response-btn order-response-btn--primary m-t-20">
                Retour aux commandes
            </a>
        @else
            <p class="order-response-done-footer">Vous pouvez fermer cette page.</p>
        @endif
    </div>
</body>
</html>
