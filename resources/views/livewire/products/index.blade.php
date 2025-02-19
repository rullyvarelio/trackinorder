@php
$products = App\Models\Products::with('category')->get();

$headers = [
['key' => 'id', 'label' => '#'],
['key' => 'name', 'label' => 'Product name'],
['key' => 'category.name', 'label' => 'Category'],
['key' => 'price', 'label' => 'Price'],
['key' => 'stock', 'label' => 'Stock'],
['key' => 'status', 'label' => 'Status'],
['key' => 'action', 'label' => 'Action'],
];
@endphp
<div>
    <x-header title="Products">
        <x-slot:actions>
            <x-button icon="o-plus" class="btn-primary" link="{{ route('create.product') }}" />
        </x-slot:actions>
    </x-header>
    <x-table :headers="$headers" :rows="$products" striped>
        @scope('cell_status', $product)
        {{ $product->status ? 'Available' : 'Not available' }}
        @endscope
        @scope('cell_action', $product)
        <x-button icon="o-arrow-top-right-on-square" class="btn-square btn-ghost btn-sm" />
        <x-button icon="o-trash" class="btn-square btn-sm" />
        @endscope
    </x-table>
</div>