<div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <x-header title="Overview" />
    <div class="grid gap-7 sm:grid-cols-2 lg:grid-cols-4 mb-10">
        <x-card title="Revenue" subtitle="This year" shadow>
            <div class="text-2xl font-bold ">
                {{ '$' . number_format($revenue, 2) }}
            </div>
        </x-card>
        <x-card title="ARPO" subtitle="Average Revenue per Order" shadow>
            <div class="text-2xl font-bold ">
                {{ '$' . $arpo }}
            </div>
        </x-card>
        <x-card title="Orders" subtitle="This month" shadow>
            <div class="text-2xl font-bold ">
                {{ $total_order }}
            </div>
        </x-card>
        <x-card title="Growth rate" subtitle="This month" shadow>
            <div class="text-2xl font-bold ">
                {{ number_format($growth_rate, 2) }}%
            </div>
        </x-card>
    </div>
    <x-card shadow class="overflow-x-auto">
        <table class="table table-zebra">
            <thead>
                <tr>
                    <td>Product</td>
                    <td>Category</td>
                    <td>Stock</td>
                    <td>Sales</td>
                    <td>Revenue</td>
                    <td>Last Update</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($entries as $entry)
                    <tr>
                        <td class="flex items-center px-4 py-2 font-medium whitespace-nowrap">
                            @if ($entry->image)
                                <img src="{{ asset('local-storage/' . $entry->image) }}"
                                    alt="{{ $entry->name }}'s Image" class="w-8 h-8 mr-3 rounded object-cover">
                            @else
                                <img src="{{ asset('No_Image_Available.jpg') }}" alt="Image not available"
                                    class="w-8 h-8 mr-3 rounded">
                            @endif
                            {{ $entry->name }}
                        </td>
                        <td>
                            {{ $entry->category->name }}
                        </td>
                        <td>
                            {{ $entry->stock }}
                        </td>
                        <td>
                            {{ $entry->total_sales ?? 0 }}
                        </td>
                        <td>
                            {{ '$' . number_format($entry->monthly_revenue, 2) }}
                        </td>
                        <td>
                            {{ $entry->updated_at->diffForHumans() }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="my-2">
            {{ $entries->links() }}
        </div>
    </x-card>

    <div class="grid gap-7 sm:grid-cols-2 lg:grid-cols-3 mt-10">
        <x-card title="32.4k" subtitle="Orders this year" shadow>
            <x-chart wire:model="chart1" />
        </x-card>
        <x-card title="$5,405" subtitle="Revenue this year" shadow class="col-span-2">
            <x-chart wire:model="chart2" />
        </x-card>
    </div>
</div>
