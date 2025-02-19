<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources\css\app.css', 'resources\js\app.js'])
    @livewireStyles
    <title>{{ $title ?? 'Trackin Order' }}</title>
</head>

<body class="font-sans antialiased">

    <x-navbar />
    <x-main with-nav full-width>
        <x-sidebar />
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>
    <x-toast />
</body>

</html>