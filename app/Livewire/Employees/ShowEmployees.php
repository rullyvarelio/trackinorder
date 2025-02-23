<?php

namespace App\Livewire\Employees;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ShowEmployees extends Component
{
    public function delete($id)
    {
        $user = User::where('id', $id)->first();

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
        $users = User::all()->except(Auth::id());
        $headers = [
            ['key' => 'no', 'label' => '#'],
            ['key' => 'employee', 'label' => 'Employee'],
            ['key' => 'role', 'label' => 'Role'],
            ['key' => 'joined', 'label' => 'Joined'],
            ['key' => 'cta', 'label' => 'Action'],

        ];

        return view('livewire.employees.show-employees', [
            'users' => $users,
            'headers' => $headers,
        ]);
    }
}
