<?php

namespace App\Livewire\Employees;

use App\Models\Role;
use App\Models\User;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

class CreateEmployees extends Component
{
    use Toast, WithFileUploads;

    #[Validate('required')]
    public $name;

    #[Validate('required|email:dns')]
    public $email;

    #[Validate('required|confirmed')]
    public $password;

    #[Validate('required')]
    public $password_confirmation;

    #[Validate('required')]
    public $role_id;

    #[Validate('required')]
    public $slug;

    #[Validate('nullable')]
    public $image;

    public function save()
    {
        if (! Gate::allows('admin')) {
            abort(403, 'Unauthorized Access');
        }

        if ($this->name) {
            $this->slug = SlugService::createSlug(User::class, 'slug', $this->name);
        }

        $validated = $this->validate();

        if ($this->image) {
            $validated['image'] = $this->image->store('employee_images');
        }

        User::create($validated);

        $this->success(
            title: 'Employee successfully updated!',
            description: null,
            position: 'toast-top toast-end',
            icon: 'o-information-circle',
            css: 'alert-success',
            timeout: 3000,
            redirectTo: route('employees.index')
        );
    }

    public function render()
    {
        if (! Gate::allows('admin')) {
            abort(403, 'Unauthorized Access');
        }

        $role_select = Role::all();

        return view('livewire.employees.create-employees', [
            'role_select' => $role_select,
        ]);
    }
}
