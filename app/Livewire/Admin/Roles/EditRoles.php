<?php

namespace App\Livewire\Admin\Roles;

use App\Models\Role;
use Livewire\Component;
use Mary\Traits\Toast;

class EditRoles extends Component
{
    use Toast;

    public $slug;

    public $name;

    public function mount($slug)
    {
        $this->slug = $slug;

        $role = Role::where('slug', $slug)->first();

        if ($role->id == 1) {
            $this->error(
                title: 'Role admin cannot be updated!',
                description: null,
                position: 'toast-top toast-end',
                icon: 'o-information-circle',
                css: 'alert-error',
                timeout: 3000,
                redirectTo: route('roles.index')
            );

            return;
        }

        if (! $role) {
            abort(404);
        }

        $this->name = $role->name;
    }

    public function update()
    {

        $validated = $this->validate([
            'name' => 'required',
            'slug' => 'required',
        ]);

        $role = Role::where('slug', $this->slug)->firstOrFail();

        $role->update($validated);

        $this->success(
            title: 'Role successfully updated!',
            description: null,
            position: 'toast-top toast-end',
            icon: 'o-information-circle',
            css: 'alert-success',
            timeout: 3000,
            redirectTo: route('roles.index')
        );
    }

    public function render()
    {
        return view('livewire.admin.roles.edit-roles');
    }
}
