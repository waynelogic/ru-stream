<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Meta -->
        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        <meta name="description" content="Платформа для рестрима ваших видео">

        <!-- Favicons -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/pwa/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/pwa/pwa-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/pwa/pwa-16x16.png') }}">
        <link rel="manifest" href="{{ asset('/pwa/site.webmanifest') }}">
        <link rel="mask-icon" href="{{ asset('/pws/safari-pinned-tab.svg') }}" color="#5bbad5">
        <link rel="shortcut icon" href="{{ asset('/pwa/favicon.ico') }}">
{{--        <link rel="manifest" href="{{ asset('/manifest.json') }}">--}}
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="msapplication-config" content="{{ asset('/favicon/browserconfig.xml') }}">
        <meta name="theme-color" content="#ffffff">

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia

{{--        <script src="{{ asset('/sw.js') }}"></script>--}}
{{--        <script>--}}
{{--            if (!navigator.serviceWorker.controller) {--}}
{{--                navigator.serviceWorker.register("/sw.js").then(function (reg) {--}}
{{--                    console.log("Service worker has been registered for scope: " + reg.scope);--}}
{{--                });--}}
{{--            }--}}
{{--        </script>--}}
    </body>
</html>
