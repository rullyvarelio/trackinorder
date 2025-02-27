<div>
    <x-header title="Pay Order" />
    <x-card shadow class="overflow-x-auto">
        <x-form wire:submit="save" no-separator>
            <x-input label="Token order" wire:model="token_order" readonly />
            <x-input label="Total price" wire:model="total_price" type="number" readonly />
            <x-input label="Paid" wire:model.live="paid" type="number" min="1" />
            <x-input label="Changes" wire:model="changes" type="number" readonly />

            <x-slot:actions>
                <x-button label="Cancel" link="{{ route('orders.index') }}" />
                <x-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>

        </x-form>
    </x-card>
</div>
