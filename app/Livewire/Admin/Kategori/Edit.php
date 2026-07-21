<?php

namespace App\Livewire\Admin\Kategori;

use App\Models\kategori_spp as KategoriSpp;
use Livewire\Component;

class Edit extends Component
{
    public KategoriSpp $kategori;
    public $tahun_ajaran = '';
    public $nominal_spp = '';

    // Mengambil data kategori saat halaman pertama kali dimuat
    public function mount(KategoriSpp $kategori)
    {
        $this->kategori = $kategori;
        $this->tahun_ajaran = $kategori->tahun_ajaran;
        $this->nominal_spp = $kategori->nominal_spp;
    }

    public function update()
    {
        $this->nominal_spp = str_replace('.', '', $this->nominal_spp);
        $this->validate([
            'tahun_ajaran' => 'required|string|max:20',
            'nominal_spp' => 'required|numeric|min:0|max:1000000000',
        ]);

        $this->kategori->update([
            'tahun_ajaran' => $this->tahun_ajaran,
            'nominal_spp' => $this->nominal_spp,
        ]);

        session()->flash('message', 'Kategori SPP berhasil diperbarui.');
        return $this->redirect('/admin/kategori', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.kategori.edit');
    }
}
