<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AuthRegisterLivewire extends Component
{
    public $name;
    public $email;
    public $password;

    public function register()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
        ]);

        // Daftarkan user
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // Reset data
        $this->reset(['name', 'email', 'password']);

        // Redirect ke halaman login
        return redirect()->route('auth.login');
    }

    public function render()
    {
        return view('livewire.auth-register-livewire');
    }
}