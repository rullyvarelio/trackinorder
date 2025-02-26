<?php

namespace App\Livewire\Employees;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ShowEmployees extends Component
{
    use Toast, WithPagination;

    public function delete($id)
    {
        $user = User::find($id);

        if ($user) {
            if ($user->image) {
                Storage::delete($user->image);
            }
            $user->delete();

            $this->success(
                title: 'Employee successfully deleted!',
                description: null,
                position: 'toast-top toast-end',
                icon: 'o-information-circle',
                css: 'alert-warning',
                timeout: 3000,
                redirectTo: null
            );
        } else {
            $this->error(
                title: 'Error, please try again!',
                description: null,
                position: 'toast-top toast-end',
                icon: 'o-information-circle',
                css: 'alert-error',
                timeout: 3000,
                redirectTo: null
            );
        }
    }

    public function render()
    {
        $users = User::where('id', '!=', Auth::id())->paginate(10);

        return view('livewire.employees.show-employees', [
            'users' => $users,
        ]);
    }
}
