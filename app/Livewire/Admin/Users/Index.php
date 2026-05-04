<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function delete(User $user)
    {
        $user = User::findOrFail($user->id);
        $user->delete();

        session()->flash('message', 'Akun Wali Murid berhasil dihapus.');
    }

    public function render()
    {
        /** @var \Illuminate\Contracts\Pagination\LengthAwarePaginator $users */
        /** @disregard P1005 */
        $users = User::where('role', 'wali_murid')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.users.index', [
            'users' => $users
        ]);
    }
}
