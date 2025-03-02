<div>
    <x-header title="Employees">
        <x-slot:middle class="!justify-end">
            <form method="GET">
                <x-input icon="o-magnifying-glass" placeholder="Search..." wire:model.live="searchEmployees" />
            </form>
        </x-slot:middle>
        @can('admin')
            <x-slot:actions>
                <x-button link="{{ route('employees.create') }}" icon="o-plus" class="btn-primary" />
            </x-slot:actions>
        @endcan
    </x-header>
    <x-card shadow class="overflow-x-auto">
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Employee</th>
                    <th>Role</th>
                    <th>Joined</th>
                    @can('admin')
                        <th>Action</th>
                    @endcan
                </tr>
            </thead>
            <tbody>

                @foreach ($users as $user)
                    <tr>
                        <td>{{ $users->firstItem() + $loop->index }}</td>
                        <td>
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
                        </td>
                        <td>
                            @if ($user->role_id == 1)
                                <x-badge :value="$user->role->name" class="badge-primary" />
                            @else
                                <x-badge :value="$user->role->name" class="badge-secondary" />
                            @endif
                        </td>
                        <td>
                            <span class="font-bold">
                                {{ $user->created_at->format('d-m-Y') }}
                            </span>
                        </td>
                        @can('admin')
                            <td>
                                <x-button :link="route('employees.edit', $user->slug)" icon="o-pencil-square" class="btn-warning btn-sm" />
                                <x-button icon="o-trash" class="btn-error btn-sm" wire:click="delete({{ $user->id }})"
                                    wire:confirm="Are you sure you want to delete this user?" />
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="my-2">
            {{ $users->links() }}
        </div>
    </x-card>
</div>
