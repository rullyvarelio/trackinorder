<div>
    <x-header title="Reports">
        <x-slot:middle class="!justify-end">
            <x-input icon="o-magnifying-glass" placeholder="Search..." />
        </x-slot:middle>
    </x-header>
    <x-card shadow class="overflow-x-auto">
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Order</th>
                    <th>Total price</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $orders->firstItem() + $loop->index }}</td>
                        <td>
                            <x-kbd>{{ $order->token_order }}</x-kbd>
                        </td>
                        <td>{{ '$' . number_format($order->total_price, 2) }}</td>
                        <td>
                            <x-badge :value="Str::upper($order->status)" class="badge-success font-bold" />
                        </td>
                        <td>{{ $order->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="my-2">
            {{ $orders->links() }}
        </div>
        <x-slot:actions>
            <x-button label="Export as CSV" icon="o-arrow-down-tray" class="btn-primary" wire:click="report('csv')"
                wire:confirm="Are you sure you want to download this file?" />
            <x-button label="Export as PDF" icon="o-arrow-down-tray" class="btn-secondary" wire:click="report('pdf')"
                wire:confirm="Are you sure you want to download this file?" />
        </x-slot:actions>
    </x-card>
</div>
