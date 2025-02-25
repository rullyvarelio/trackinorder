<div>
    <x-header title="Reports">
        <x-slot:middle class="!justify-end">
            <x-input icon="o-magnifying-glass" placeholder="Search..." />
        </x-slot:middle>
    </x-header>
    <x-card shadow>
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
            <x-modal wire:model="myModal1" title="Export file">
                <div>Export as CSV?</div>

                <x-slot:actions>
                    <x-button label="Cancel" @click="$wire.myModal1 = false" />
                    <x-button label="Confirm" class="btn-primary" wire:click="report('csv')" spinner />
                </x-slot:actions>
            </x-modal>
            <x-modal wire:model="myModal2" title="Export file">
                <div>Export as PDF?</div>

                <x-slot:actions>
                    <x-button label="Cancel" @click="$wire.myModal2 = false" />
                    <x-button label="Confirm" class="btn-primary" wire:click="report('pdf')" spinner />
                </x-slot:actions>
            </x-modal>
            <x-button label="Export as CSV" icon="o-arrow-down-tray" class="btn-primary"
                @click="$wire.myModal1 = true" />
            <x-button label="Export as PDF" icon="o-arrow-down-tray" class="btn-secondary"
                @click="$wire.myModal2 = true" />
        </x-slot:actions>
    </x-card>
</div>
