<?php

namespace App\Livewire\Admin\Roles;

use App\Models\Role;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class CreateRoles extends Component
{
    use Toast;

    #[Validate('required')]
    public $name;

    #[Validate('required')]
    public $slug;

    public function save()
    {

        if ($this->name) {
            $this->slug = SlugService::createSlug(Role::class, 'slug', $this->name);
        }

        $validated = $this->validate();

        Role::create($validated);

        $this->success(
            title: 'Role successfully created!',
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
        return view('livewire.admin.roles.create-roles');
    }
}
