<?php

namespace App\Livewire\WaliMurid\Riwayat;

use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $filterStatus = '';
    public string $filterBulan  = '';
    public string $filterTahun  = '';
    public string $search       = '';

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
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $siswaIds = Auth::user()->siswa()->pluck('id_siswa');

        $pembayarans = Pembayaran::with(['tagihan.siswa', 'tagihan.kategori_spp'])
            ->whereHas('tagihan', fn($q) => $q->whereIn('id_siswa', $siswaIds))
            ->when($this->filterStatus, fn($q) => $q->where('status_pembayaran', $this->filterStatus))
            ->when($this->filterBulan,  fn($q) => $q->whereHas('tagihan', fn($q2) => $q2->where('bulan', $this->filterBulan)))
            ->when($this->filterTahun,  fn($q) => $q->whereHas('tagihan', fn($q2) => $q2->where('tahun', $this->filterTahun)))
            ->when($this->search,       fn($q) => $q->where('order_id', 'like', '%' . $this->search . '%')
                ->orWhereHas('tagihan.siswa', fn($q2) => $q2->where('nama_siswa', 'like', '%' . $this->search . '%')))
            ->latest()
            ->paginate(10);

        // Stats
        $base = Pembayaran::whereHas('tagihan', fn($q) => $q->whereIn('id_siswa', $siswaIds));
        $stats = [
            'total_transaksi' => (clone $base)->count(),
            'total_berhasil'  => (clone $base)->where('status_pembayaran', 'settlement')->sum('jumlah_bayar'),
            'total_pending'   => (clone $base)->where('status_pembayaran', 'pending')->count(),
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

        return view('livewire.wali-murid.riwayat.index', compact('pembayarans', 'stats', 'bulanList'));
    }
}
