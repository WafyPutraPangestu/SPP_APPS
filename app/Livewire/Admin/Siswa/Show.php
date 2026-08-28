<?php

namespace App\Livewire\Admin\Siswa;

use App\Models\Siswa;
use Livewire\Component;

class Show extends Component
{
    public Siswa $siswa;

    public function mount(Siswa $siswa)
    {
        $this->siswa = $siswa->load(['user', 'tagihan.kategori_spp']);
    }

    public function render()
    {
        return view('livewire.admin.siswa.show');
    }
}
