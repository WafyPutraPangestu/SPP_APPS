<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Edit extends Component
{
    public User $user;
    public $name = '';
    public $email = '';
    public $password = '';

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'password' => 'nullable|string|min:8',
        ]);

        $this->user->name = $this->name;
        $this->user->email = $this->email;

        if (!empty($this->password)) {
            $this->user->password = Hash::make($this->password);
        }

        $this->user->save();

        session()->flash('message', 'Data Wali Murid berhasil diperbarui.');
        return $this->redirect('/admin/users', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.users.edit');
    }
}
