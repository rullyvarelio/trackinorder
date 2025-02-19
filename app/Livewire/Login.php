<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.guest')]
class Login extends Component
{
    #[Validate('required|email')]
    public string $email;

    #[Validate('required')]
    public string $password;

    public function login()
    {
        $validated = $this->validate();

        if (Auth::attempt($validated)) {
            session()->regenerate();

            return redirect()->intended('dashboard');
        } else {
            return back()->with('error', 'Login failed!');
        }
    }

    public function render()
    {
        return view('livewire.login')->title('Login');
    }
}
