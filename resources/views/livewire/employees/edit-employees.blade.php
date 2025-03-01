<div>
    <x-header title="Create Employee" />
    <x-card shadow shadow class="overflow-x-auto">
        <x-form wire:submit="update" no-separator>
            <x-input label="Name" hint="Your full name" wire:model="name" />
            <x-input label="Email" wire:model="email" />
            <x-password label="Password" wire:model="password" right />
            <x-password label="Confirm password" wire:model="password_confirmation" right />
            <x-radio label="Role" :options="$role_select" wire:model="role" />
            <x-file label="image" accept="image/png, image/jpeg, image/jpg" wire:model="image">
                @if ($image)
                    <img src="{{ $image->temporaryUrl() }}" class="h-40 rounded-lg" />
                @elseif ($oldImage)
                    <img src="{{ asset('local-storage/' . $oldImage) }}" class="h-40 rounded-lg" />
                @else
                    <img src="{{ asset('No_Image_Available.jpg') }}" class="h-40 rounded-lg" />
                @endif

            </x-file>

            <x-slot:actions>
                <x-button label="Cancel" link="{{ route('employees.index') }}" />
                <x-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>

        </x-form>
    </x-card>
</div>
