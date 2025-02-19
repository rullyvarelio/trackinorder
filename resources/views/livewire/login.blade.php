<x-form wire:submit="login" no-separator>
    @if (session()->has('error'))
    <x-alert title="Error!" description="{{ session('error') }}" icon="o-exclamation-triangle" class="alert-error"
        dismissible />
    @endif
    <x-input label="Email" wire:model="email" />
    <x-password label="Password" wire:model="password" right />
    <x-slot:actions>
        <x-button label="Login" class="btn-primary" type="submit" spinner="save" />
    </x-slot:actions>
</x-form>