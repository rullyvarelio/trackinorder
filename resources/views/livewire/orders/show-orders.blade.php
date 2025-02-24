<div>
    <x-header title="Orders">
        <x-slot:middle class="!justify-end">
            <x-input icon="o-magnifying-glass" placeholder="Search..." />
        </x-slot:middle>
        <x-slot:actions>
            <x-button link="{{ route('orders.create') }}" icon="o-plus" class="btn-primary" />
        </x-slot:actions>
    </x-header>
    <x-table :headers="$headers" :rows="$orders">
        @scope('cell_loop', $order)
            {{ $loop->iteration }}
        @endscope
        @scope('cell_token_order', $order)
            @if ($order->token_order)
                <x-kbd>{{ $order->token_order }}</x-kbd>
            @else
                <x-kbd>No token</x-kbd>
            @endif
        @endscope
        @scope('cell_by', $order)
            {{ $order->user->name }}
        @endscope
        @scope('cell_status', $order)
            @if ($order->status == 'pending')
                <x-badge :value="Str::upper($order->status)" class="badge-warning font-bold" />
            @elseif ($order->status == 'canceled')
                <x-badge :value="Str::upper($order->status)" class="badge-error font-bold" />
            @elseif ($order->status == 'paid')
                <x-badge :value="Str::upper($order->status)" class="badge-success font-bold" />
            @endif
        @endscope
        @scope('cell_action', $order)
            @if ($order->status == 'pending')
                <x-button link="{{ route('orders.pay', $order->token_order) }}" icon="o-banknotes"
                    class="btn-success btn-sm" tooltip="Payment" />
                <x-button wire:click="cancel('{{ $order->token_order }}')" icon="o-x-circle" class="btn-error btn-sm"
                    tooltip="Cancel order" />
            @else
                <x-kbd>
                    {{ Str::upper($order->status) }}
                </x-kbd>
            @endif
        @endscope
    </x-table>
</div>
