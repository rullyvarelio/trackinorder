@php

@endphp
<div>
    <x-header title="Stocks" />
    <x-card shadow>
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Stock</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $products->firstItem() + $loop->index }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>
                            @if ($product->stock > 0)
                                <x-badge value="Available" class="badge-success" />
                            @else
                                <x-badge value="Not available" class="badge-error" />
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <x-slot:actions>
            <x-button label="Add stock" icon="o-plus" :link="route('stocks.in')" spinner wire:navigate />
            <x-button label="Remove stock" icon="o-minus" :link="route('stocks.out')" spinner wire:navigate />
        </x-slot:actions>
    </x-card>
</div>
