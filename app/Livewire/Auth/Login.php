<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;
    public function login()
    {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            session()->regenerate();
            session()->flash('message', 'Login successful!');
            $role = Auth::user()->role;
            if ($role === 'admin') {
                return redirect()->intended('/');
            } elseif ($role === 'wali_murid') {
                return redirect()->intended('/');
            } elseif ($role === 'kepala_sekolah') {
                return redirect()->intended('/');
            }
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();

            session()->flash('error', 'Akun Anda tidak memiliki hak akses yang valid di sistem ini.');
            return redirect('/login');
        } else {
            $this->password = '';
            session()->flash('error', 'Invalid email or password.');
        }
    }
    public function render()
    {
        return view('livewire.auth.login');
    }
}
