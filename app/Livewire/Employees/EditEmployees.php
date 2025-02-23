<?php

namespace App\Livewire\Employees;

use App\Models\User;
use Mary\Traits\Toast;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditEmployees extends Component
{
    use Toast, WithFileUploads;

    public $slug;

    public $name;

    public $email;

    public $password;

    public $password_confirmation;

    public $is_admin;

    public $image;

    public $oldImage;

    public function mount($slug)
    {
        $this->slug = $slug;

        $user = User::where('slug', $slug)->first();

        if (! $user) {
            abort(404);
        }

        $this->name = $user->name;
        $this->email = $user->email;
        $this->is_admin = $user->is_admin;
        $this->oldImage = $user->image;
    }


    public function update()
    {
        $validated = $this->validate([
            'name' => 'required',
            'email' => 'required|email:dns',
            'password' => 'required|confirmed',
            'is_admin' => 'required',
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
        $isAdmin = [
            ['id' => 0, 'name' => 'Staff'],
            ['id' => 1, 'name' => 'Admin'],
        ];

        return view('livewire.employees.edit-employees', [
            'isAdmin' => $isAdmin

        ]);
    }
}
