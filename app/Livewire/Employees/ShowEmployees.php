<?php

namespace App\Livewire\Employees;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Mary\Traits\Toast;

class ShowEmployees extends Component
{
    use Toast;

    public $searchEmployees = '';

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

        return view('livewire.employees.show-employees', [
            'users' => User::search($this->searchEmployees)->where('id', '!=', Auth::id())->orderBy('role')->paginate(10),
        ]);
    }
}
