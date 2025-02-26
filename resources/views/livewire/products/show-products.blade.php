<div>
    <x-header title="Products">
        <x-slot:middle class="!justify-end">
            <x-input icon="o-magnifying-glass" placeholder="Search..." />
        </x-slot:middle>
        <x-slot:actions>
            <x-button link="{{ route('products.create') }}" icon="o-plus" class="btn-primary" />
        </x-slot:actions>
    </x-header>
    <x-card shadow class="overflow-x-auto">
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($products as $product)
                    <tr>
                        <td>{{ $products->firstItem() + $loop->index }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ '$' . $product->price }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>
                            @if ($product->status)
                                <x-badge value="Available" class="badge-success" />
                            @else
                                <x-badge value="Out of stock" class="badge-error" />
                            @endif
                        </td>
                        <td>
                            <x-button link="{{ route('products.edit', $product->slug) }}" icon="o-pencil-square"
                                class="btn-warning btn-sm" />
                            <x-button icon="o-trash" class="btn-error btn-sm" wire:click="delete({{ $product->id }})"
                                wire:confirm="Are you sure you want to delete this product?" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="my-2">
            {{ $products->links() }}
        </div>
    </x-card>
</div>
