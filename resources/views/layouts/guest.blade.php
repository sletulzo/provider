<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="manifest" href="{{ asset('manifest.json') }}">
        <link rel="icon" href="{{ Vite::asset('resources/images/logo-only.svg') }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css">

        <!-- PWA -->
        @include('components.pwa')

        <!-- Scripts -->
        @vite([
            'resources/css/app.css',
            'resources/css/login.css',
            'resources/js/app.js',
        ])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        {{ $slot }}

        <button id="installPWA" style="display: none" class="install-pwa-button">
            <i class="fa-solid fa-mobile-screen"></i>
        </button>
    </body>
</html>
