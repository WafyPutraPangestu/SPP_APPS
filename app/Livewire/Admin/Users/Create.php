<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Create extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'wali_murid',
        ]);
        session()->flash('message', 'Akun Wali Murid berhasil dibuat.');
        return $this->redirect('/admin/users', navigate: true);
    }
    public function render()
    {
        return view('livewire.admin.users.create');
    }
}
