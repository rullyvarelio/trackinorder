@php
    $categories = App\Models\Categories::all();
@endphp
<div>
    <x-header title="Edit Product" />
    <x-form wire:submit="update" no-separator>
        <x-input label="Name" wire:model="name" />
        <x-select label="Category" :options="$categories" placeholder="Select a category" placeholder-value="0"
            wire:model="category_id" />
        <x-input label="Price" icon="o-currency-dollar" hint="Per batch" wire:model="price" />
        <x-input label="Stock" icon="o-currency-dollar" wire:model="stock" />
        <x-file label="image" accept="image/png, image/jpeg, image/jpg" wire:model="image">
            @if ($image)
                <img src="{{ $image->temporaryUrl() }}" class="h-40 rounded-lg" />
            @elseif ($oldImage)
                <img src="{{ asset('storage2/' . $oldImage) }}" class="h-40 rounded-lg" />
            @else
                <img src="{{ asset('No_Image_Available.jpg') }}" class="h-40 rounded-lg" />
            @endif

        </x-file>

        <x-slot:actions>
            <x-button label="Cancel" link="{{ route('products.index') }}" />
            <x-button label="Click me!" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>

    </x-form>
</div>
