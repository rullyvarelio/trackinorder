<div>
    <x-header title="Categories">
        <x-slot:middle class="!justify-end">
            <form method="get">
                <x-input icon="o-magnifying-glass" placeholder="Search..." wire:model.live="searchCategories" />
            </form>
        </x-slot:middle>
        <x-slot:actions>
            <x-button link="{{ route('categories.create') }}" icon="o-plus" class="btn-primary" />
        </x-slot:actions>
    </x-header>
    <x-card shadow class="overflow-x-auto">
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Products</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $categories->firstItem() + $loop->index }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            @if ($category->products->isNotEmpty())
                                <x-dropdown label="{{ $category->products->count() }} Product" class="btn-ghost btn-sm">
                                    @foreach ($category->products as $product)
                                        <x-menu-item :title="$product->name" />
                                    @endforeach
                                </x-dropdown>
                            @else
                                <x-badge value="No Product" class="badge-error" />
                            @endif
                        </td>
                        <td>{{ $category->created_at->diffForHumans() }}</td>
                        <td>
                            <x-button link="{{ route('categories.edit', $category->slug) }}" icon="o-pencil-square"
                                class="btn-warning btn-sm" />
                            <x-button icon="o-trash" class="btn-error btn-sm" wire:click="delete({{ $category->id }})"
                                wire:confirm="Are you sure you want to delete this category?" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="my-2">
            {{ $categories->links() }}
        </div>
    </x-card>
</div>
