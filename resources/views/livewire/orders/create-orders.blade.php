<div>
    <x-header title="Create Order" />
    <x-form wire:submit="save" no-separator>
        <x-table :headers="$headers" :rows="$products" wire:model="selected" selectable>
            @scope('cell_quantity', $order)
                <x-input type="number" wire:model="products.{{ $order['id'] }}.quantity" min="1"
                    max="{{ $order['stock'] }}" style="width: 80px;" />
            @endscope
        </x-table>
        <x-slot:actions>
            <x-button label="Cancel" :link="route('orders.index')" />
            <x-button label="Save Order" class="btn-primary" type="submit" spinner="save4" />
        </x-slot:actions>
    </x-form>
</div>
