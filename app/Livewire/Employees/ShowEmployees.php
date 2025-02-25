<?php

namespace App\Livewire\Employees;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class ShowEmployees extends Component
{
    use WithPagination;

    public $myModal1 = false;

    public function delete($slug)
    {
        $user = User::where('slug', $slug)->first();

        if ($user) {
            if ($user->image) {
                Storage::delete($user->image);
            }

            $user->delete();
            session()->flash('success', 'Product deleted successfully!');
        } else {
            session()->flash('error', 'Product not found!');
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
