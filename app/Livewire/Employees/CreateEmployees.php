<?php

namespace App\Livewire\Employees;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Cviebrock\EloquentSluggable\Services\SlugService;
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
    public $is_admin;

    #[Validate('required')]
    public $slug;

    #[Validate('nullable')]
    public $image;


    public function save()
    {
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
        $isAdmin = [
            ['id' => 0, 'name' => 'Staff'],
            ['id' => 1, 'name' => 'Admin'],
        ];
        return view('livewire.employees.create-employees', [
            'isAdmin' => $isAdmin
        ]);
    }
}
