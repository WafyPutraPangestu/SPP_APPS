<?php

namespace App\Livewire\Admin\Kategori;

use App\Models\kategori_spp as KategoriSpp;
use Livewire\Component;

class Show extends Component
{
    public KategoriSpp $kategori;

    public function mount(KategoriSpp $kategori)
    {
        $this->kategori = $kategori;
    }

    public function render()
    {
        return view('livewire.admin.kategori.show');
    }
}
