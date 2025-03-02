<?php

namespace App\Livewire\Admin\Roles;

use App\Models\Role;
use Livewire\Component;
use Mary\Traits\Toast;

class ShowRoles extends Component
{
    use Toast;

    public $searchRoles = '';

    public function delete($id)
    {
        $role = Role::find($id);

        if ($role->id == 1) {
            $this->error(
                title: 'Role admin cannot be deleted!',
                description: null,
                position: 'toast-top toast-end',
                icon: 'o-information-circle',
                css: 'alert-error',
                timeout: 3000,
                redirectTo: null
            );

            return;
        }

        $role->delete();

        $this->success(
            title: 'Role successfully deleted!',
            description: null,
            position: 'toast-top toast-end',
            icon: 'o-information-circle',
            css: 'alert-success',
            timeout: 3000,
            redirectTo: null
        );
    }

    public function render()
    {
        return view('livewire.admin.roles.show-roles', [
            'roles' => Role::search($this->searchRoles)->with('users')->paginate(5),
        ]);
    }
}
