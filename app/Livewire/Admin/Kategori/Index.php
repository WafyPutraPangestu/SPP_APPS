<?php

namespace App\Livewire\Admin\Kategori;

use App\Models\kategori_spp;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    // Fungsi untuk menghapus kategori
    public function delete($id)
    {
        $kategori = kategori_spp::findOrFail($id);
        $kategori->delete();

        session()->flash('message', 'Kategori SPP berhasil dihapus.');
    }

    public function render()
    {
        /** @disregard P1005 */
        $kategoris = kategori_spp::latest()->paginate(10);

        return view('livewire.admin.kategori.index', [
            'kategoris' => $kategoris
        ]);
    }
}
