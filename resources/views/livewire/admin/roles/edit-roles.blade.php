<div>
    <x-header title="Create Role" />
    <x-card shadow class="overflow-x-auto">
        <x-form wire:submit="update" no-separator>
            <x-input label="Name" wire:model="name" />

            <x-slot:actions>
                <x-button label="Cancel" link="{{ route('roles.index') }}" />
                <x-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>

        </x-form>
    </x-card>
</div>
