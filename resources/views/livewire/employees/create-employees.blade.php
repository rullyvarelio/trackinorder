<div>
    <x-header title="Create Employee" />
    <x-card shadow>
        <x-form wire:submit="save" no-separator>
            <x-input label="Name" hint="Your full name" wire:model="name" />
            <x-input label="Email" wire:model="email" />
            <x-password label="Password" wire:model="password" right />
            <x-password label="Confirm password" wire:model="password_confirmation" right />
            <x-radio label="Role" :options="$isAdmin" wire:model="is_admin" />
            <x-file label="image" accept="image/png, image/jpeg, image/jpg" wire:model="image">
                <img src="{{ asset('No_Image_Available.jpg') }}" class="h-40 rounded-lg" />
            </x-file>

            <x-slot:actions>
                <x-button label="Cancel" link="{{ route('employees.index') }}" />
                <x-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>

        </x-form>
    </x-card>
</div>
