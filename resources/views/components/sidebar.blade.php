@php
$user = Auth::user();
@endphp
<x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-200">

    {{-- User --}}
    @if($user)
    <form action="/logout" method="POST">
        @csrf
        <x-list-item :item="$user" value="name" sub-value="email" no-separator no-hover class="pt-2">
            <x-slot:actions>
                <x-button type="submit" icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff"
                    no-wire-navigate />
            </x-slot:actions>
        </x-list-item>
    </form>

    <x-menu-separator />
    @endif

    <x-menu activate-by-route>
        <x-menu-item title="Home" icon="o-home" link="dashboard" />
        <x-menu-item title="Products" icon="o-archive-box" link="dashboard/products" />
        <x-menu-sub title="Stock management" icon="o-inbox-stack">
            <x-menu-item title="Stock in" icon="o-arrow-down-on-square-stack" link="dashboard/stocks/stock-in" />
            <x-menu-item title="Stock out" icon="o-arrow-up-on-square-stack" link="dashboard/stocks/stock-out" />
        </x-menu-sub>
        <x-menu-item title="Employees" icon="o-user-group" link="dashboard/employees" />
        <x-menu-item title="Reports" icon="o-document-chart-bar" link="dashboard/reports" />
        @if ($user->is_admin)
        <x-menu-separator />
        <x-menu-item title="Create Categories" icon="o-table-cells" link="dashboard/admin/categories" />
        @endif
    </x-menu>
</x-slot:sidebar>