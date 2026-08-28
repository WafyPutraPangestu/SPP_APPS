<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;

class Show extends Component
{
    public User $user;
    public function mount(User $user)
    {
        $this->user = $user->load(['siswa.tagihan']);
    }
    public function render()
    {
        return view('livewire.admin.users.show');
    }
}
