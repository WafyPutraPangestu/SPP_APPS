<?php

namespace App\Livewire\Admin\Kategori;

use App\Models\kategori_spp;
use App\Models\KategoriSpp;
use Livewire\Component;

class Create extends Component
{
    public $tahun_ajaran = '';
    public $nominal_spp = '';

    public function save()
    {
        // Validasi input: tahun ajaran wajib diisi, nominal harus berupa angka
        $this->validate([
            'tahun_ajaran' => 'required|string|max:20',
            'nominal_spp' => 'required|numeric|min:0',
        ]);

        kategori_spp::create([
            'tahun_ajaran' => $this->tahun_ajaran,
            'nominal_spp' => $this->nominal_spp,
        ]);

        session()->flash('message', 'Kategori SPP berhasil ditambahkan.');
        return $this->redirect('/admin/kategori', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.kategori.create');
    }
}
