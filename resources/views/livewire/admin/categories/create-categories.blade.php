<div>
    <x-header title="Create Category" />
    <x-card shadow class="overflow-x-auto">
        <x-form wire:submit="save" no-separator>
            <x-input label="Name" wire:model="name" />

            <x-slot:actions>
                <x-button label="Cancel" link="{{ route('categories.index') }}" />
                <x-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>

        </x-form>
    </x-card>
</div>
