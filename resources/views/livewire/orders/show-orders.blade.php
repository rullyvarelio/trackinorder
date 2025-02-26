<div>
    <x-header title="Orders">
        <x-slot:middle class="!justify-end">
            <x-input icon="o-magnifying-glass" placeholder="Search..." />
        </x-slot:middle>
        <x-slot:actions>
            <x-button link="{{ route('orders.create') }}" icon="o-plus" class="btn-primary" />
        </x-slot:actions>
    </x-header>
    <x-card shadow>
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Order</th>
                    <th>Placed by</th>
                    <th>Total price</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $orders->firstItem() + $loop->index }}</td>
                        <td>
                            @if ($order->token_order)
                                <x-kbd>{{ $order->token_order }}</x-kbd>
                            @else
                                <x-kbd>No token</x-kbd>
                            @endif
                        </td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ '$' . number_format($order->total_price, 2) }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>
                            @if ($order->status == 'pending')
                                <x-badge :value="Str::upper($order->status)" class="badge-warning font-bold" />
                            @elseif ($order->status == 'canceled')
                                <x-badge :value="Str::upper($order->status)" class="badge-error font-bold" />
                            @elseif ($order->status == 'paid')
                                <x-badge :value="Str::upper($order->status)" class="badge-success font-bold" />
                            @elseif ($order->status == 'completed')
                                <x-badge :value="Str::upper($order->status)" class="badge-success font-bold" />
                            @endif
                        </td>
                        <td>
                            @if ($order->status == 'pending')
                                <x-button link="{{ route('orders.pay', $order->token_order) }}" icon="o-banknotes"
                                    class="btn-success btn-sm" tooltip="Payment" />
                                <x-button icon="o-trash" class="btn-error btn-sm"
                                    wire:click="cancel({{ $order->id }})"
                                    wire:confirm="Are you sure you want to cancel this order?" />
                            @else
                                <x-kbd>
                                    {{ Str::upper($order->status) }}
                                </x-kbd>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="my-2">
            {{ $orders->links() }}
        </div>
    </x-card>
</div>
