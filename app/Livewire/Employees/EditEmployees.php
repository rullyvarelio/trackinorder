<?php

namespace App\Livewire\Employees;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

class EditEmployees extends Component
{
    use Toast, WithFileUploads;

    public $slug;

    public $name;

    public $email;

    public $password;

    public $password_confirmation;

    public $role_id;

    public $image;

    public $oldImage;

    public function mount($slug)
    {
        if (! Gate::allows('admin')) {
            abort(403, 'Unauthorized Access');
        }

        $this->slug = $slug;

        $user = User::where('slug', $slug)->first();

        if (! $user) {
            abort(404);
        }

        $this->name = $user->name;
        $this->email = $user->email;
        $this->role_id = $user->role_id;
        $this->oldImage = $user->image;
    }

    public function update()
    {
        if (! Gate::allows('admin')) {
            abort(403, 'Unauthorized Access');
        }

        $validated = $this->validate([
            'name' => 'required',
            'email' => 'required|email:dns',
            'password' => 'required|confirmed',
            'role_id' => 'required',
            'image' => 'nullable|image',
        ]);

        $product = User::where('slug', $this->slug)->firstOrFail();

        if ($this->image) {
            $path = $this->image->store('employee_images');
            $validated['image'] = $path;

            if ($this->oldImage) {
                Storage::delete($this->oldImage);
            }
        } else {
            $validated['image'] = $this->oldImage;
        }

        $product->update($validated);

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

        return view('livewire.employees.edit-employees', [
            'role_select' => $role_select,

        ]);
    }
}
