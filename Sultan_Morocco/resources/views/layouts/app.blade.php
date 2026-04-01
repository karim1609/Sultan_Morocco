<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{ $title ?? config('app.name', 'Sultan Morocco') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="ultra-bg noise">
        <div class="relative min-h-screen">
            <x-navbar />

            <main class="mx-auto w-full max-w-6xl px-4 py-8 sm:px-6">
                <x-alert />
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
