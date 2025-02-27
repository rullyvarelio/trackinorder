<div>
    <x-header title="Create Order" />
    <x-card shadow class="overflow-x-auto">
        <x-form wire:submit="save" no-separator>
            <table class="table table-zebra">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>Name</td>
                        <td>Price</td>
                        <td>Stock</td>
                        <td>Qty</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>
                                <x-checkbox type="checkbox" wire:model.live="selectProduct.{{ $product->id }}" />
                            </td>
                            <td>
                                {{ $product->name }}
                            </td>
                            <td>
                                {{ $product->price }}
                            </td>
                            <td>
                                {{ $product->stock }}
                            </td>
                            <td>
                                <x-input type="number" wire:model.live="quantity.{{ $product->id }}" min="1"
                                    max="{{ $product->stock }}" style="width: 80px;" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <x-slot:actions>
                <x-button label="Cancel" :link="route('orders.index')" />
                <x-button label="Save Order" class="btn-primary" type="submit" spinner="save4" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
