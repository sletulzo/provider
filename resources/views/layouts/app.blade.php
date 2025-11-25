<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css">

        <!-- PWA -->
        @include('components.pwa')

        <!-- Scripts -->
        @vite([
            'resources/css/app.css',
            'resources/css/admin.css',
            'resources/css/nav.css',
            'resources/css/table.css',
            'resources/css/form.css',
            'resources/css/mobile.css',
        ])

        @livewireStyles
    </head>
    <body class="font-sans antialiased">

        <div class="main-wrapper">
            <header>
                {{ isset($header) ? $header : 'Dashboard' }}
                @include('layouts.header-right')
            </header>

            @include('layouts.navigation')

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @include('layouts.modal')

        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

        @vite([
            'resources/js/app.js',
            'resources/js/admin.js'
        ])

        @livewireScripts
    </body>
</html>
