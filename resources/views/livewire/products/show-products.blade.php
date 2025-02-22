@php
    $products = App\Models\Products::with('category')->paginate(5);

    $headers = [
        ['key' => 'name', 'label' => 'Name'],
        ['key' => 'category.name', 'label' => 'Category'],
        ['key' => 'price', 'label' => 'Price', 'format' => ['currency', '2,.', '$ ']],
        ['key' => 'stock', 'label' => 'Stock'],
        ['key' => 'status', 'label' => 'Status'],
        ['key' => 'action', 'label' => 'Action'],
    ];
@endphp

<div>
    <x-header title="Products">
        <x-slot:middle class="!justify-end">
            <x-input icon="o-magnifying-glass" placeholder="Search..." />
        </x-slot:middle>
        <x-slot:actions>
            <x-button link="{{ route('products.create') }}" icon="o-plus" class="btn-primary" />
        </x-slot:actions>
    </x-header>

    {{-- Notice `no-headers` --}}
    <x-table :headers="$headers" :rows="$products" with-pagination>
        @scope('cell_name', $x)
            ({{ $loop->index + 1 }}) {{ $x->name }}
        @endscope
        @scope('cell_status', $x)
            @if ($x->stock > 0)
                <x-badge value="Available" class="badge-success" />
            @else
                <x-badge value="Not available" class="badge-error" />
            @endif
        @endscope
        @scope('cell_action', $x)
            <x-button link="{{ route('products.edit', $x->slug) }}" icon="o-pencil-square" class="btn-warning btn-sm" />
            <x-button wire:click="delete({{ $x->id }})" icon="o-trash" class="btn-error btn-sm" />
        @endscope
    </x-table>

</div>
