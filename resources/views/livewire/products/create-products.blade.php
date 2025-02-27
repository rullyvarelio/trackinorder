@php
    $categories = App\Models\Category::all();
@endphp
<div>
    <x-header title="Create Product" />
    <x-card shadow class="overflow-x-auto">
        <x-form wire:submit="save" no-separator>
            <x-input label="Name" wire:model="name" />
            <x-select label="Category" :options="$categories" placeholder="Select a category" placeholder-value="0"
                wire:model="category_id" />
            <x-input label="Price" icon="o-currency-dollar" hint="Per batch" wire:model="price" type="number"
                min="0" />
            <x-input label="Stock" wire:model="stock" readonly />
            <x-file label="image" accept="image/png, image/jpeg, image/jpg" wire:model="image">
                <img src="{{ asset('No_Image_Available.jpg') }}" class="h-40 rounded-lg" />
            </x-file>

            <x-slot:actions>
                <x-button label="Cancel" link="{{ route('products.index') }}" />
                <x-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
