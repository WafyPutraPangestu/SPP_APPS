<?php

namespace App\Livewire\Admin\Tagihan;

use App\Models\kategori_spp;
use App\Models\Siswa;
use App\Models\Tagihan;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    // ── Filter ──────────────────────────────────────
    public $filterStatus    = '';
    public $filterKategori  = '';
    public $filterBulan     = '';
    public $filterTahun     = '';

    // ── Create single ───────────────────────────────
    public $showCreateModal = false;
    public $create_id_siswa    = '';
    public $create_id_kategori = '';
    public $create_bulan       = '';
    public $create_tahun       = '';

    // ── Generate massal ─────────────────────────────
    public $showGenerateModal  = false;
    public $generate_id_kategori = '';
    public $generate_bulan       = '';
    public $generate_tahun       = '';

    // ── Edit ────────────────────────────────────────
    public $showEditModal   = false;
    public $edit_id         = null;
    public $edit_id_siswa      = '';
    public $edit_id_kategori   = '';
    public $edit_bulan         = '';
    public $edit_tahun         = '';
    public $edit_status        = '';

    protected function rules(): array
    {
        return [
            'create_id_siswa'    => 'required|exists:siswas,id_siswa',
            'create_id_kategori' => 'required|exists:kategori_spps,id_kategori',
            'create_bulan'       => 'required|string|max:20',
            'create_tahun'       => 'required|integer|min:2000|max:2100',
        ];
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }
    public function updatingFilterKategori()
    {
        $this->resetPage();
    }
    public function updatingFilterBulan()
    {
        $this->resetPage();
    }
    public function updatingFilterTahun()
    {
        $this->resetPage();
    }

    // ── Create single ───────────────────────────────
    public function openCreate()
    {
        $this->reset(['create_id_siswa', 'create_id_kategori', 'create_bulan', 'create_tahun']);
        $this->resetErrorBag();
        $this->showCreateModal = true;
    }

    public function save()
    {
        $this->validate([
            'create_id_siswa'    => 'required|exists:siswas,id_siswa',
            'create_id_kategori' => 'required|exists:kategori_spps,id_kategori',
            'create_bulan'       => 'required|string|max:20',
            'create_tahun'       => 'required|integer|min:2000|max:2100',
        ]);

        /** @disregard P1005 */
        $exists = Tagihan::where('id_siswa', $this->create_id_siswa)
            ->where('id_kategori', $this->create_id_kategori)
            ->where('bulan', $this->create_bulan)
            ->where('tahun', $this->create_tahun)
            ->exists();

        if ($exists) {
            $this->addError('create_bulan', 'Tagihan untuk santri, bulan, dan tahun ini sudah ada.');
            return;
        }

        Tagihan::create([
            'id_siswa'       => $this->create_id_siswa,
            'id_kategori'    => $this->create_id_kategori,
            'bulan'          => $this->create_bulan,
            'tahun'          => $this->create_tahun,
            'status_tagihan' => 'Belum Lunas',
        ]);

        $this->showCreateModal = false;
        session()->flash('message', 'Tagihan berhasil dibuat.');
    }

    // ── Generate massal ─────────────────────────────
    public function openGenerate()
    {
        $this->reset(['generate_id_kategori', 'generate_bulan', 'generate_tahun']);
        $this->resetErrorBag();
        $this->showGenerateModal = true;
    }

    public function generate()
    {
        $this->validate([
            'generate_id_kategori' => 'required|exists:kategori_spps,id_kategori',
            'generate_bulan'       => 'required|string|max:20',
            'generate_tahun'       => 'required|integer|min:2000|max:2100',
        ]);

        $siswas = Siswa::all();
        $created = 0;
        $skipped = 0;

        foreach ($siswas as $siswa) {
            /** @disregard P1005 */
            $exists = Tagihan::where('id_siswa', $siswa->id_siswa)
                ->where('id_kategori', $this->generate_id_kategori)
                ->where('bulan', $this->generate_bulan)
                ->where('tahun', $this->generate_tahun)
                ->exists();

            if (!$exists) {
                Tagihan::create([
                    'id_siswa'       => $siswa->id_siswa,
                    'id_kategori'    => $this->generate_id_kategori,
                    'bulan'          => $this->generate_bulan,
                    'tahun'          => $this->generate_tahun,
                    'status_tagihan' => 'Belum Lunas',
                ]);
                $created++;
            } else {
                $skipped++;
            }
        }

        $this->showGenerateModal = false;
        session()->flash('message', "Generate selesai: {$created} tagihan dibuat, {$skipped} dilewati (sudah ada).");
    }

    // ── Edit ────────────────────────────────────────
    public function openEdit($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $this->edit_id          = $id;
        $this->edit_id_siswa    = $tagihan->id_siswa;
        $this->edit_id_kategori = $tagihan->id_kategori;
        $this->edit_bulan       = $tagihan->bulan;
        $this->edit_tahun       = $tagihan->tahun;
        $this->edit_status      = $tagihan->status_tagihan;
        $this->resetErrorBag();
        $this->showEditModal    = true;
    }

    public function update()
    {
        $this->validate([
            'edit_id_siswa'    => 'required|exists:siswas,id_siswa',
            'edit_id_kategori' => 'required|exists:kategori_spps,id_kategori',
            'edit_bulan'       => 'required|string|max:20',
            'edit_tahun'       => 'required|integer|min:2000|max:2100',
            'edit_status'      => 'required|in:Belum Lunas,Lunas',
        ]);

        $tagihan = Tagihan::findOrFail($this->edit_id);
        $tagihan->update([
            'id_siswa'       => $this->edit_id_siswa,
            'id_kategori'    => $this->edit_id_kategori,
            'bulan'          => $this->edit_bulan,
            'tahun'          => $this->edit_tahun,
            'status_tagihan' => $this->edit_status,
        ]);

        $this->showEditModal = false;
        session()->flash('message', 'Tagihan berhasil diperbarui.');
    }

    // ── Tandai Lunas ────────────────────────────────
    public function tandaiLunas($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $tagihan->update(['status_tagihan' => 'Lunas']);
        session()->flash('message', 'Tagihan berhasil ditandai Lunas.');
    }

    // ── Delete ──────────────────────────────────────
    public function delete($id)
    {
        Tagihan::findOrFail($id)->delete();
        session()->flash('message', 'Tagihan berhasil dihapus.');
    }

    public function render()
    {
        $query = Tagihan::with(['siswa', 'kategori_spp'])
            ->when($this->filterStatus,   fn($q) => $q->where('status_tagihan', $this->filterStatus))
            ->when($this->filterKategori, fn($q) => $q->where('id_kategori', $this->filterKategori))
            ->when($this->filterBulan,    fn($q) => $q->where('bulan', $this->filterBulan))
            ->when($this->filterTahun,    fn($q) => $q->where('tahun', $this->filterTahun))
            ->latest();

        /** @disregard P1005 */
        return view('livewire.admin.tagihan.index', [
            'tagihans'  => $query->paginate(10),
            'kategoris' => kategori_spp::all(),
            'siswas'    => Siswa::all(),
            'bulanList' => [
                'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            ],
            'stats' => [
                'total'        => Tagihan::count(),
                'lunas'        => Tagihan::where('status_tagihan', 'Lunas')->count(),
                'belum_lunas'  => Tagihan::where('status_tagihan', 'Belum Lunas')->count(),
            ],
        ]);
    }
}
