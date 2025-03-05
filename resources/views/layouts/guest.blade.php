<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources\css\app.css', 'resources\js\app.js'])
    @livewireStyles
    <title>{{ $title ?? 'Trackin Order' }}</title>
</head>

<body
    class="flex flex-row min-h-screen justify-center items-center font-sans antialiased bg-base-200/50 dark:bg-base-200">

    <x-theme-toggle class="absolute right-3 top-3 btn btn-circle btn-ghost" darkTheme="business" lightTheme="corporate" />
    <x-card class="w-full p-6 lg:max-w-lg" shadow>
        <x-slot:title>
            <div class="w-9 h-9 text-primary text-2xl font-bold flex">
                <img src="{{ asset('logo-light.svg') }}" alt="Logo" class="block dark:hidden" />
                <img src="{{ asset('logo-dark.svg') }}" alt="Logo" class="hidden dark:block" />

                TrackinOrder
            </div>
        </x-slot:title>

        <div>
            {{ $slot }}
        </div>
    </x-card>

</body>

</html>
