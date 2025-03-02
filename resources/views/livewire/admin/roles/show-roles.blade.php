<div>
    <x-header title="Roles">
        <x-slot:middle class="!justify-end">
            <form method="get">
                <x-input icon="o-magnifying-glass" placeholder="Search..." wire:model.live="searchRoles" />
            </form>
        </x-slot:middle>
        <x-slot:actions>
            <x-button link="{{ route('roles.create') }}" icon="o-plus" class="btn-primary" />
        </x-slot:actions>
    </x-header>
    <x-card shadow class="overflow-x-auto">
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Users</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $roles->firstItem() + $loop->index }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            @if ($role->users->isNotEmpty())
                                <x-dropdown label="{{ $role->users->count() }} Employee" class="btn-ghost btn-sm">
                                    @foreach ($role->users as $user)
                                        <x-menu-item :title="$user->name" />
                                    @endforeach
                                </x-dropdown>
                            @else
                                <x-badge value="No Employee" class="badge-error" />
                            @endif
                        </td>
                        <td>{{ $role->created_at->diffForHumans() }}</td>
                        <td>
                            @if ($role->id != 1)
                                <x-button link="{{ route('roles.edit', $role->slug) }}" icon="o-pencil-square"
                                    class="btn-warning btn-sm" />
                                <x-button icon="o-trash" class="btn-error btn-sm"
                                    wire:click="delete({{ $role->id }})"
                                    wire:confirm="Are you sure you want to delete this role?" />
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="my-2">
            {{ $roles->links() }}
        </div>
    </x-card>
</div>
