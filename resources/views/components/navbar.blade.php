@php
$user = Auth::user();
$initials = Str::upper(collect(explode(' ', $user->name))->map(fn($word) => $word[0])->implode(''));
@endphp
<x-nav sticky full-width>

    <x-slot:brand>
        {{-- Drawer toggle for "main-drawer" --}}
        <label for="main-drawer" class="lg:hidden mr-3">
            <x-icon name="o-bars-3" class="cursor-pointer" />
        </label>

        {{-- Brand --}}
        <div><span class="font-bold">Trackin Order</span></div>
    </x-slot:brand>

    {{-- Right side actions --}}
    <x-slot:actions>
        @if ($user->image)
        <x-avatar :image="$user->image" />
        @else
        <x-avatar placeholder="{{ $initials }}" />
        @endif
        <x-theme-toggle darkTheme="business" lightTheme="corporate" />
    </x-slot:actions>
</x-nav>