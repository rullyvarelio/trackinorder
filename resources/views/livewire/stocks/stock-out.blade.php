<div>
    <x-header title="Stock out" />
    <x-card shadow>
        <x-form wire:submit="save" no-separator>
            <x-select label="Product" :options="$products" placeholder="Select a product" placeholder-value="0"
                wire:model="product_id" />
            <x-input label="Quantity" hint="Per batch" wire:model="quantity" type="number" min="1" />
            <x-radio label="Reason" :options="$reasons" option-value="name" wire:model="reason" />
            <x-datetime label="Date" wire:model="used_date" icon="o-calendar" />

            <x-slot:actions>
                <x-button label="Cancel" link="{{ route('stocks.index') }}" />
                <x-button label="Submit" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>

        </x-form>
    </x-card>
</div>
