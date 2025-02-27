<div>
    <x-header title="Stock in" />
    <x-card shadow class="overflow-x-auto">
        <x-form wire:submit="save" no-separator>
            <x-select label="Product" :options="$products" placeholder="Select a product" placeholder-value="0"
                wire:model="product_id" />
            <x-input label="Quantity" hint="Per batch" wire:model="quantity" type="number" min="1" />
            <x-input label="Supplier" wire:model="supplier" />
            <x-datetime label="Date" wire:model="received_date" icon="o-calendar" />
            <x-input label="Notes" wire:model="notes" hint="Optional" />

            <x-slot:actions>
                <x-button label="Cancel" link="{{ route('stocks.index') }}" />
                <x-button label="Submit" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>

        </x-form>
    </x-card>
</div>
