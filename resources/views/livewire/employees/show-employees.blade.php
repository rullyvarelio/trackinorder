<div>
    <x-header title="Employees">
        <x-slot:middle class="!justify-end">
            <x-input icon="o-magnifying-glass" placeholder="Search..." />
        </x-slot:middle>
        <x-slot:actions>
            <x-button link="{{ route('employees.create') }}" icon="o-plus" class="btn-primary" />
        </x-slot:actions>
    </x-header>
    <x-table :headers="$headers" :rows="$users">
        @scope('cell_no', $user)
            {{ $loop->iteration }}
        @endscope
        @scope('cell_employee', $user)
            <div class="flex items-center gap-3">
                @if ($user->image)
                    <x-avatar :image="asset('local-storage/' . $user->image)" class="!w-14 rounded-lg" />
                @else
                    <x-avatar :image="asset('no-profile.jpg')" class="!w-14 rounded-lg" />
                @endif
                <div>
                    <div class="font-bold">
                        {{ $user->name }}
                    </div>
                    <div class="text-sm opacity-50">
                        {{ $user->email }}
                    </div>
                </div>
            </div>
        @endscope
        @scope('cell_role', $user)
            @if ($user->is_admin)
                <x-badge value="Admin" class="badge-primary" />
            @else
                <x-badge value="Staff" class="badge-secondary" />
            @endif
        @endscope
        @scope('cell_joined', $user)
            <span class="font-bold">
                {{ $user->created_at->format('d-m-Y') }}
            </span>
        @endscope
        @scope('cell_cta', $user)
            <x-button :link="route('employees.edit', $user->slug)" icon="o-pencil-square" class="btn-warning btn-sm" />
            <x-button wire:click="delete({{ $user->id }})" icon="o-trash" class="btn-error btn-sm" />
        @endscope
    </x-table>
</div>
