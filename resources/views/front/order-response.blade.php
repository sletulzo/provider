<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ Vite::asset('resources/images/logo.png') }}">
    <title>Commande CMD-{{ $order->id }} — {{ config('app.name') }}</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/css/order-response.css'])
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
<body class="order-response-page">
    <div class="order-response">
        <header class="order-response-header">
            @if (!empty($backUrl))
                <a href="{{ $backUrl }}" class="order-response-back"><i class="fa-solid fa-arrow-left"></i></a>
            @endif
            <div class="order-response-header-content">
                <div class="order-response-logo">{{ config('app.name') }}</div>
                <h1>Commande CMD-{{ $order->id }}</h1>
                <p>{{ $order->tenant?->name }} · {{ carbon($order->created_at)->format('d/m/Y à H:i') }}</p>
            </div>
        </header>

        <div class="order-response-client">
            <i class="fa-regular fa-user"></i>
            <div>
                <div class="order-response-client-label">Client</div>
                <div class="order-response-client-name">{{ $order->user?->name }}</div>
            </div>
        </div>

        <form method="POST" action="{{ $submitUrl }}" id="orderResponseForm">
            @csrf

            <div class="order-response-section-title">
                Articles commandés
                <span>{{ $order->lines->count() }} produit{{ $order->lines->count() > 1 ? 's' : '' }}</span>
            </div>

            <div class="order-response-lines">
                @foreach ($order->lines as $line)
                    <div class="order-response-line" data-line="{{ $line->id }}">
                        <div class="order-response-line-info">
                            <div class="order-response-line-name">{{ $line->product?->name }}</div>
                            <div class="order-response-line-meta">
                                {{ $line->quantity }} {{ $line->unity?->name ?? 'unité' }}
                                @if ($line->product?->price)
                                    · {{ price($line->getLineTotal(), 2) }} €
                                @endif
                            </div>
                        </div>
                        <div class="order-response-line-toggle">
                            <input type="hidden" name="lines[{{ $line->id }}]" value="accepted" class="line-status-input">
                            <button type="button" class="order-response-toggle-btn active" data-status="accepted">
                                <i class="fa-solid fa-check"></i> Dispo
                            </button>
                            <button type="button" class="order-response-toggle-btn" data-status="missing">
                                <i class="fa-solid fa-xmark"></i> Manquant
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="order-response-note">
                <label for="provider_note">Message au client (optionnel)</label>
                <textarea id="provider_note" name="provider_note" rows="3" placeholder="Ex : Livraison prévue demain matin, pommes indisponibles cette semaine…"></textarea>
            </div>

            <div class="order-response-actions">
                <button type="submit" class="order-response-btn order-response-btn--primary">
                    <i class="fa-solid fa-paper-plane"></i> Valider ma réponse
                </button>
                <button type="button" class="order-response-btn order-response-btn--danger" id="refuseAllBtn">
                    <i class="fa-solid fa-ban"></i> Refuser toute la commande
                </button>
            </div>

            <input type="hidden" name="refuse_all" value="0" id="refuseAllInput">
        </form>
    </div>

    <script>
        document.querySelectorAll('.order-response-line').forEach(function (line) {
            var input = line.querySelector('.line-status-input');
            line.querySelectorAll('.order-response-toggle-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    line.querySelectorAll('.order-response-toggle-btn').forEach(function (b) {
                        b.classList.remove('active');
                    });
                    btn.classList.add('active');
                    input.value = btn.dataset.status;
                    line.classList.toggle('order-response-line--missing', btn.dataset.status === 'missing');
                });
            });
        });

        document.getElementById('refuseAllBtn').addEventListener('click', function () {
            if (!confirm('Refuser l\'intégralité de cette commande ?')) return;
            document.getElementById('refuseAllInput').value = '1';
            document.getElementById('orderResponseForm').submit();
        });
    </script>
</body>
</html>
