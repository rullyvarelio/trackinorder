<div>
    <x-header title="Edit Category" />
    <x-card shadow class="overflow-x-auto">
        <x-form wire:submit="update" no-separator>
            <x-input label="Name" wire:model="name" />
            <x-input label="Slug" wire:model="slug" readonly />

            <x-slot:actions>
                <x-button label="Cancel" link="{{ route('categories.index') }}" />
                <x-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>

        </x-form>
    </x-card>
</div>
