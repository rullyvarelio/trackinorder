<div>
    <x-header title="Reports">
        <x-slot:middle class="!justify-end">
            <x-input icon="o-magnifying-glass" placeholder="Search..." />
        </x-slot:middle>
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
        @scope('cell_status', $order)
            <x-badge :value="Str::upper($order->status)" class="badge-success font-bold" />
        @endscope
    </x-table>
    <x-button label="Export as CSV" icon="o-arrow-down-tray" wire:click="report('csv')" class="btn-primary" />
    <x-button label="Export as PDF" icon="o-arrow-down-tray" wire:click="report('pdf')" class="btn-secondary" />
</div>
