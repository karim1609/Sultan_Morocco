@props([
    'title' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{ $title ?? config('app.name', 'Sultan Morocco') }}</title>

        <x-theme-init />

        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-zinc-950 text-zinc-100 antialiased">
        <div class="relative flex min-h-screen flex-col">
            <x-navbar variant="chat" />

            <main class="mx-auto flex w-full max-w-6xl flex-1 flex-col px-4 py-6 sm:px-6">
                <x-alert />
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
