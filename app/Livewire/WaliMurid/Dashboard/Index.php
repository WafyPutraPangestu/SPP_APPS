<?php

namespace App\Livewire\WaliMurid\Dashboard;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $siswaIds = Auth::user()->siswa()->pluck('id_siswa');

        // Tagihan belum lunas terbaru (max 5 untuk preview)
        $tagihanBelumLunas = Tagihan::with(['siswa', 'kategori_spp'])
            ->whereIn('id_siswa', $siswaIds)
            ->where('status_tagihan', 'Belum Lunas')
            ->latest()
            ->limit(5)
            ->get();

        // Riwayat pembayaran terbaru (max 5)
        $riwayatTerbaru = Pembayaran::with(['tagihan.siswa', 'tagihan.kategori_spp'])
            ->whereHas('tagihan', fn($q) => $q->whereIn('id_siswa', $siswaIds))
            ->where('status_pembayaran', 'settlement')
            ->latest()
            ->limit(5)
            ->get();

        /** @disregard P1005 */
        $baseTagihan   = Tagihan::whereIn('id_siswa', $siswaIds);
        $basePembayaran = Pembayaran::whereHas('tagihan', fn($q) => $q->whereIn('id_siswa', $siswaIds));

        $stats = [
            'total_tagihan'   => (clone $baseTagihan)->count(),
            'belum_lunas'     => (clone $baseTagihan)->where('status_tagihan', 'Belum Lunas')->count(),
            'lunas'           => (clone $baseTagihan)->where('status_tagihan', 'Lunas')->count(),
            'total_dibayar'   => (clone $basePembayaran)->where('status_pembayaran', 'settlement')->sum('jumlah_bayar'),
            'tunggakan'       => (clone $baseTagihan)
                ->where('status_tagihan', 'Belum Lunas')
                ->join('kategori_spps', 'tagihans.id_kategori', '=', 'kategori_spps.id_kategori')
                ->sum('kategori_spps.nominal_spp'),
        ];

        // Data siswa milik wali
        $siswas = Auth::user()->siswa()->get();

        // Bulan ini
        $bulanIni = now()->locale('id')->isoFormat('MMMM');
        $tahunIni = now()->year;

        $tagihanBulanIni = Tagihan::with(['kategori_spp'])
            ->whereIn('id_siswa', $siswaIds)
            ->where('bulan', $bulanIni)
            ->where('tahun', $tahunIni)
            ->get();

        return view('livewire.wali_murid.dashboard.index', compact(
            'stats',
            'tagihanBelumLunas',
            'riwayatTerbaru',
            'siswas',
            'tagihanBulanIni',
            'bulanIni',
            'tahunIni',
        ));
    }
}
