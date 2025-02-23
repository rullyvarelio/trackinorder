<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources\css\app.css', 'resources\js\app.js'])
    @livewireStyles
    <title>{{ $title ?? 'Trackin Order' }}</title>
</head>

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">
    <x-nav sticky class="lg:hidden">
        <x-slot:brand>
            <div class="ml-5 font-bold">Trackin Order</div>
        </x-slot:brand>
        <x-slot:actions>
            <label for="main-drawer" class="lg:hidden mr-3">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-nav>

    <x-main full-width>
        <x-sidebar />
        <x-slot:content>
            <x-theme-toggle class="absolute right-2 top-3" darkTheme="business" lightTheme="corporate" />
            {{ $slot }}
        </x-slot:content>
    </x-main>
    <x-toast />
</body>

</html>
