<div>

    <x-header title="Overview" />
    <div class="grid gap-7 sm:grid-cols-2 lg:grid-cols-3 mb-10">
        <x-card title="Revenue" subtitle="This month" shadow>
            <x-slot:menu class="bg-success rounded">
                <x-icon name="o-chevron-up" class="cursor-pointer" />
                <div class="text-sm">
                    75%
                </div>
            </x-slot:menu>
            <div class="text-2xl font-bold ">
                {{ '$' . number_format($revenue, 2) }}
            </div>
        </x-card>
        <x-card title="Orders" subtitle="This month" shadow>
            <x-slot:menu class="bg-success rounded">
                <x-icon name="o-chevron-up" class="cursor-pointer" />
                <div class="text-sm">
                    75%
                </div>
            </x-slot:menu>
            <div class="text-2xl font-bold ">
                {{ $total_order }}
            </div>
        </x-card>
        <x-card title="MRR" subtitle="This year" shadow>
            <x-slot:menu class="bg-success rounded">
                <x-icon name="o-chevron-up" class="cursor-pointer" />
                <div class="text-sm">
                    75%
                </div>
            </x-slot:menu>
            <div class="text-2xl font-bold ">
                {{ '$' . number_format($monthly_recurring_revenue, 2) }}
            </div>
        </x-card>
    </div>
    <x-card shadow>
        <x-table :headers='$headers' :rows="$dash_table" with-pagination>
            @scope('cell_product', $entry)
                <div class="flex items-center px-4 py-2 font-medium whitespace-nowrap">
                    @if ($entry->image)
                        <img src="{{ asset('local-storage/' . $entry->image) }}" alt="{{ $entry->name }}'s Image"
                            class="w-8 h-8 mr-3 rounded object-cover">
                    @else
                        <img src="{{ asset('No_Image_Available.jpg') }}" alt="Image not available"
                            class="w-8 h-8 mr-3 rounded">
                    @endif
                    {{ $entry->name }}
                </div>
            @endscope
            @scope('cell_sales', $entry)
                {{ $entry->total_sales ?? 0 }}
            @endscope
            @scope('cell_revenue', $entry)
                {{ '$' . number_format($entry->monthly_revenue, 2) }}
            @endscope
            @scope('cell_updated_at', $entry)
                {{ $entry->updated_at->diffForHumans() }}
            @endscope
        </x-table>
    </x-card>
</div>
