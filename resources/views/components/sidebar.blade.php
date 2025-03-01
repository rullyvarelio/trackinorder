@php
    $user = Auth::user();

    function getInitials($name)
    {
        $words = explode(' ', trim($name));

        $firstInitial = isset($words[0]) ? strtoupper(substr($words[0], 0, 1)) : '';
        $lastInitial = isset($words[1]) ? strtoupper(substr(Arr::last($words), 0, 1)) : '';

        return $firstInitial . $lastInitial;
    }
@endphp
<x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-200">

    {{-- User --}}
    @if ($user)
        <form action="/logout" method="POST">
            @csrf

            <x-list-item :item="$user" value="name" sub-value="email" no-separator no-hover class="pt-2">
                <x-slot:avatar>
                    @if ($user->image)
                        <x-avatar :image="asset('local-storage/' . $user->image)" />
                    @else
                        <x-avatar :placeholder="getInitials($user->name)" />
                    @endif

                </x-slot:avatar>
                <x-slot:actions>
                    <x-button type="submit" icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff"
                        no-wire-navigate />
                </x-slot:actions>
            </x-list-item>
        </form>

        <x-menu-separator />
    @endif

    <x-menu activate-by-route>
        <x-menu-item title="Home" icon="o-home" :link="route('dashboard')" />
        <x-menu-item title="Products" icon="o-archive-box" :link="route('products.index')" />
        <x-menu-item title="Orders" icon="o-clipboard-document-list" :link="route('orders.index')" />
        <x-menu-sub title="Stock management" icon="o-inbox-stack">
            <x-menu-item title="Stocks" icon="o-square-2-stack" :link="route('stocks.index')" />
            <x-menu-item title="Stock in" icon="o-arrow-down-on-square-stack" :link="route('stocks.in')" />
            <x-menu-item title="Stock out" icon="o-arrow-up-on-square-stack" :link="route('stocks.out')" />
        </x-menu-sub>
        <x-menu-item title="Employees" icon="o-user-group" :link="route('employees.index')" />
        <x-menu-item title="Reports" icon="o-document-chart-bar" :link="route('reports.index')" />
        {{-- only accesed by admin --}}
        <x-menu-separator />
        <x-menu-item title="Categories" icon="o-table-cells" :link="route('categories.index')" />

    </x-menu>

</x-slot:sidebar>
