<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="manifest" href="{{ asset('manifest.json') }}">
        <link rel="icon" href="{{ Vite::asset('resources/images/logo.png') }}">
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
        ])

        @livewireStyles

         <!-- Color -->
        @php ($color = auth()->user()->getColor())
        <style>
            :root {
                --primary: {{ $color ?? '#3645b1' }};
                --secondary: {{ $color ?? '#44beee' }};

                --primary-bg: {{ $color ?? '#3645b1' }}1a;
                --secondary-bg: {{ $color ?? '#44beee' }}4d;
            }
        </style>
    </head>
    <body class="font-sans antialiased">

        <div class="main-wrapper">
            <header>
                @include('layouts.navigations.burger.' . Auth::user()->getNavigationSlug())

                <!-- <x-application-logo class="block h-9 w-auto fill-current text-gray-800" /> -->
                {{ isset($header) ? $header : '' }}
                
                @if (isset($headerActions))
                    {!! $headerActions !!}
                @endif
            </header>

            @include('layouts.navigations.' . Auth::user()->getNavigationSlug())

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

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
                <div class="fixed inset-0 bg-white/60 backdrop-blur-sm flex items-center justify-center pointer-events-auto"></div>
            </template>
        </div>
    </body>
</html>
