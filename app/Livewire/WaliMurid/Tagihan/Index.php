<?php

namespace App\Livewire\WaliMurid\Tagihan;

use App\Models\Tagihan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public string $filterStatus = '';
    public string $filterBulan  = '';
    public string $filterTahun  = '';
    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }
    public function updatingFilterBulan(): void
    {
        $this->resetPage();
    }
    public function updatingFilterTahun(): void
    {
        $this->resetPage();
    }
    public function render()
    {
        $siswaIds = Auth::user()
            ->siswa()
            ->pluck('id_siswa');
        $tagihans = Tagihan::with(['siswa', 'kategori_spp', 'pembayaran'])
            ->whereIn('id_siswa', $siswaIds)
            ->when($this->filterStatus, fn($q) => $q->where('status_tagihan', $this->filterStatus))
            ->when($this->filterBulan,  fn($q) => $q->where('bulan', $this->filterBulan))
            ->when($this->filterTahun,  fn($q) => $q->where('tahun', $this->filterTahun))
            ->latest()
            ->paginate(9);
        /** @disregard P1005 */
        $allTagihans = Tagihan::whereIn('id_siswa', $siswaIds);
        $stats = [
            'total'       => (clone $allTagihans)->count(),
            'lunas'       => (clone $allTagihans)->where('status_tagihan', 'Lunas')->count(),
            'belum_lunas' => (clone $allTagihans)->where('status_tagihan', 'Belum Lunas')->count(),
            'total_nominal' => (clone $allTagihans)
                ->where('status_tagihan', 'Belum Lunas')
                ->join('kategori_spps', 'tagihans.id_kategori', '=', 'kategori_spps.id_kategori')
                ->sum('kategori_spps.nominal_spp'),
        ];
        $bulanList = [
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
            'Desember',
        ];
        return view('livewire.wali-murid.tagihan.index', compact('tagihans', 'stats', 'bulanList'));
    }
}
