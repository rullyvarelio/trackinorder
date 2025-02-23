@php

@endphp
<div>
    <x-header title="Stocks" />
    <x-table :headers="$headers" :rows="$products" with-pagination>
        @scope('cell_name', $x)
            ({{ $loop->iteration }}) {{ $x->name }}
        @endscope
        @scope('cell_status', $x)
            @if ($x->stock > 0)
                <x-badge value="Available" class="badge-success" />
            @else
                <x-badge value="Not available" class="badge-error" />
            @endif
        @endscope
    </x-table>
    <x-button label="Add stock" icon="o-plus" :link="route('stocks.in')" spinner wire:navigate />
    <x-button label="Remove stock" icon="o-minus" :link="route('stocks.out')" spinner wire:navigate />
</div>
