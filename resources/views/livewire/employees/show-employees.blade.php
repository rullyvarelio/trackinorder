<div>
    <x-header title="Employees">
        <x-slot:middle class="!justify-end">
            <x-input icon="o-magnifying-glass" placeholder="Search..." />
        </x-slot:middle>
        <x-slot:actions>
            <x-button link="{{ route('employees.create') }}" icon="o-plus" class="btn-primary" />
        </x-slot:actions>
    </x-header>
    <x-card shadow class="overflow-x-auto">
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Employee</th>
                    <th>Role</th>
                    <th>Joined</th>
                    <th>Action</th>
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
                            @if ($user->is_admin)
                                <x-badge value="Admin" class="badge-primary" />
                            @else
                                <x-badge value="Staff" class="badge-secondary" />
                            @endif
                        </td>
                        <td>
                            <span class="font-bold">
                                {{ $user->created_at->format('d-m-Y') }}
                            </span>
                        </td>
                        <td>
                            <x-button :link="route('employees.edit', $user->slug)" icon="o-pencil-square" class="btn-warning btn-sm" />
                            <x-modal wire:model="myModal1" title="Order cancellation">
                                <div class="mb-5">Are you sure you want to cancel this order?</div>
                                <x-slot:actions>
                                    <x-button label="Cancel" @click="$wire.myModal1 = false" />
                                    <x-button label="Confirm" wire:click="delete('{{ $user->slug }}')"
                                        class="btn-error" @click="$wire.myModal1 = false" />
                                </x-slot:actions>
                            </x-modal>
                            <x-button icon="o-trash" class="btn-error btn-sm" @click="$wire.myModal1 = true" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="my-2">
            {{ $users->links() }}
        </div>
    </x-card>
</div>
