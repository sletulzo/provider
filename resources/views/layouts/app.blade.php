<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="manifest" href="{{ asset('manifest.json') }}">
        <link rel="icon" href="{{ Vite::asset('resources/images/logo-no-bg.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('icons/app-icon.png') }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

        <!-- Scripts -->
        @vite([
            'resources/css/app.css',
            'resources/css/admin.css',
            'resources/css/nav.css',
            'resources/css/table.css',
            'resources/css/form.css',
            'resources/css/mobile.css',
            'resources/css/dashboard.css',
            'resources/css/ui-v2.css',
        ])

        @livewireStyles

         <!-- Color -->
        @php ($theme = auth()->user()->getTheme())
        <style>
            :root {
                --primary: {{ $theme['primary'] }};
                --primary-dark: {{ $theme['primary_dark'] }};
                --secondary: {{ $theme['secondary'] }};
                --primary-bg: {{ $theme['primary'] }}1a;
                --secondary-bg: {{ $theme['secondary'] }}29;
            }
        </style>
    </head>
    <body class="font-sans antialiased">

        <div id="appSplash" class="app-splash" aria-hidden="true">
            <div class="app-splash__inner">
                <img class="app-splash__logo" src="{{ Vite::asset('resources/images/logo-no-bg.png') }}" alt="{{ config('app.name') }}">
            </div>
        </div>

        <script>
            (function () {
                var splash = document.getElementById('appSplash');
                if (!splash) return;

                // Déjà affiché dans cette session (navigation SPA) : on l'enlève sans le remontrer.
                if (window.__appSplashDone) {
                    splash.remove();
                    return;
                }

                // Uniquement au lancement de la PWA installée.
                var standalone = (window.matchMedia && window.matchMedia('(display-mode: standalone)').matches)
                    || window.navigator.standalone === true;

                if (!standalone) {
                    splash.remove();
                    return;
                }

                splash.classList.add('is-active');

                var MIN_VISIBLE = 1100;
                var start = Date.now();
                var done = false;

                function hide() {
                    if (done) return;
                    done = true;
                    window.__appSplashDone = true;
                    splash.classList.add('is-hidden');
                    setTimeout(function () { if (splash.parentNode) splash.remove(); }, 600);
                }

                if (document.readyState === 'complete') {
                    setTimeout(hide, MIN_VISIBLE);
                } else {
                    window.addEventListener('load', function () {
                        var remaining = MIN_VISIBLE - (Date.now() - start);
                        setTimeout(hide, remaining > 0 ? remaining : 0);
                    });
                }

                // Sécurité : ne jamais bloquer l'accès.
                setTimeout(hide, 4000);
            })();
        </script>

        <div class="main-wrapper">
            @include('layouts.navigations.sidebar.' . Auth::user()->getNavigationSlug())

            <div class="app-shell">
                <header class="app-header">
                    @include('layouts.partials.app-bar')

                    {{ isset($header) ? $header : '' }}

                    @if (isset($headerActions))
                        <div class="app-header__actions-desktop">
                            {!! $headerActions !!}
                        </div>
                    @endif
                </header>

                <main>
                    {{ $slot }}
                </main>
            </div>

            @include('layouts.navigations.' . Auth::user()->getNavigationSlug())
        </div>

        @include('layouts.navigations.burger.drawer')

        @include('layouts.modal')
        @include('layouts.modal-slide-up')

        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

        @vite([
            'resources/js/app.js',
            'resources/js/admin.js',
            'resources/js/nav.js',
        ])

        @livewireScripts
        
        @persist('notifications')
            @include('layouts.notifications')
        @endpersist

        <div x-data="{ loading: false }" x-on:livewire:navigate.window="loading = true" x-on:livewire:navigated.window="loading = false">
            <template x-if="loading">
                <div class="fixed inset-0 bg-stone-100/60 backdrop-blur-sm flex items-center justify-center pointer-events-auto"></div>
            </template>
        </div>
    </body>
</html>
