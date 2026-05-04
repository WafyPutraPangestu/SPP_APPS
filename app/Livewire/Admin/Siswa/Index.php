<?php

namespace App\Livewire\Admin\Siswa;

use App\Models\Siswa;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function delete($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        session()->flash('message', 'Data Santri berhasil dihapus.');
    }

    public function render()
    {
        // Mengambil data siswa beserta relasi user (wali murid)
        $siswas = Siswa::with('user')->latest()->paginate(10);

        return view('livewire.admin.siswa.index', [
            'siswas' => $siswas
        ]);
    }
}
