<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <link rel="icon" href="{{ Vite::asset('resources/images/logo-no-bg.png') }}">
    <title>Tarifs enregistrés — {{ $provider->name }}</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/css/provider-prices.css'])
    <style>
        :root {
            --primary: #0a9f38;
            --primary-dark: #087a2b;
            --primary-bg: #0a9f381a;
        }
    </style>
</head>
<body class="provider-prices-page">
    <div class="provider-prices">
        <div class="provider-prices-done">
            <div class="provider-prices-done-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <h1>Tarifs enregistrés</h1>
            @if ($changesCount > 0)
                <p>{{ $changesCount }} prix mis à jour. Le client a été notifié par e-mail.</p>
            @else
                <p>Aucun prix modifié. Vous pouvez fermer cette page.</p>
            @endif
            <p class="provider-prices-done-meta">{{ $provider->name }} · {{ now()->format('d/m/Y à H:i') }}</p>
        </div>
    </div>
</body>
</html>
