<div>
    <x-header title="Stocks" />
    <x-card shadow>
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Entry</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stocks as $stock)
                    <tr>
                        <td>{{ $stocks->firstItem() + $loop->index }}</td>
                        <td>{{ $stock->product->name }}</td>
                        <td>{{ $stock->quantity }}</td>
                        <td>
                            @if ($stock->product->stock > 0)
                                <x-badge class="badge-success" value="Available" />
                            @else
                                <x-badge class="badge-error" value="Out of stock" />
                            @endif
                        </td>
                        <td>
                            @if ($stock->type == 'in')
                                <x-badge class="badge-primary" value="Stock In" />
                            @else
                                <x-badge class="badge-secondary" value="Stock Out" />
                            @endif
                        </td>
                        <td>
                            {{ $stock->created_at->diffForHumans() }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <x-slot:actions>
            <x-button label="Add stock" icon="o-plus" :link="route('stocks.in')" spinner wire:navigate />
            <x-button label="Remove stock" icon="o-minus" :link="route('stocks.out')" spinner wire:navigate />
        </x-slot:actions>
        <div class="my-2">
            {{ $stocks->links() }}
        </div>
    </x-card>
</div>
