<?php

namespace App\Livewire\KepalaSekolah\Dashboard;

use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\kategori_spp;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

/** @disregard P1005 */
class Index extends Component
{

    public function render()
    {

        $now        = now();
        $bulanIni   = $now->locale('id')->isoFormat('MMMM');
        $tahunIni   = $now->year;
        $bulanLalu  = $now->copy()->subMonth()->locale('id')->isoFormat('MMMM');
        $tahunLalu  = $now->copy()->subMonth()->year;

        /** @disregard P1005 */
        $totalSiswa    = Siswa::count();
        /** @disregard P1005 */
        $totalTagihan  = Tagihan::count();
        /** @disregard P1005 */
        $totalLunas    = Tagihan::where('status_tagihan', 'Lunas')->count();
        /** @disregard P1005 */
        $totalBelum    = Tagihan::where('status_tagihan', 'Belum Lunas')->count();
        /** @disregard P1005 */
        $totalPemasukan = Pembayaran::where('status_pembayaran', 'settlement')->sum('jumlah_bayar');
        /** @disregard P1005 */
        $pemasukanBulanIni = Pembayaran::where('status_pembayaran', 'settlement')
            ->whereHas('tagihan', fn($q) => $q->where('bulan', $bulanIni)->where('tahun', $tahunIni))
            ->sum('jumlah_bayar');
        /** @disregard P1005 */
        $pemasukanBulanLalu = Pembayaran::where('status_pembayaran', 'settlement')
            ->whereHas('tagihan', fn($q) => $q->where('bulan', $bulanLalu)->where('tahun', $tahunLalu))
            ->sum('jumlah_bayar');

        $growthPersen = $pemasukanBulanLalu > 0
            ? round((($pemasukanBulanIni - $pemasukanBulanLalu) / $pemasukanBulanLalu) * 100, 1)
            : null;

        /** @disregard P1005 */
        $tunggakan = Tagihan::where('status_tagihan', 'Belum Lunas')
            ->join('kategori_spps', 'tagihans.id_kategori', '=', 'kategori_spps.id_kategori')
            ->sum('kategori_spps.nominal_spp');

        // ── Pemasukan 6 bulan terakhir (grafik) ───────────────
        $chartData = collect();
        for ($i = 5; $i >= 0; $i--) {
            $tgl    = $now->copy()->subMonths($i);
            $bulan  = $tgl->locale('id')->isoFormat('MMMM');
            $tahun  = $tgl->year;
            /** @disregard P1005 */
            $nominal = Pembayaran::where('status_pembayaran', 'settlement')
                ->whereHas('tagihan', fn($q) => $q->where('bulan', $bulan)->where('tahun', $tahun))
                ->sum('jumlah_bayar');
            $chartData->push([
                'label'   => $tgl->isoFormat('MMM'),
                'nominal' => $nominal,
            ]);
        }

        // ── Persentase lunas per kelas ─────────────────────────
        $perKelas = Siswa::select('kelas', DB::raw('count(*) as total'))
            ->groupBy('kelas')
            ->orderBy('kelas')
            ->get()
            ->map(function ($row) {
                /** @disregard P1005 */
                $lunas = Tagihan::where('status_tagihan', 'Lunas')
                    ->whereHas('siswa', fn($q) => $q->where('kelas', $row->kelas))
                    ->count();
                $total = Tagihan::whereHas('siswa', fn($q) => $q->where('kelas', $row->kelas))->count();
                return [
                    'kelas'   => $row->kelas,
                    'siswa'   => $row->total,
                    'lunas'   => $lunas,
                    'total'   => $total,
                    'persen'  => $total > 0 ? round(($lunas / $total) * 100) : 0,
                ];
            });

        // ── Transaksi terbaru ──────────────────────────────────
        $transaksiTerbaru = Pembayaran::with(['tagihan.siswa', 'tagihan.kategori_spp'])
            ->where('status_pembayaran', 'settlement')
            ->latest('waktu_pembayaran')
            ->limit(6)
            ->get();

        // ── Kategori SPP aktif ─────────────────────────────────
        $kategoris = kategori_spp::withCount('tagihan')->latest()->limit(4)->get();

        return view('livewire.kepala-sekolah.dashboard.index', compact(
            'totalSiswa',
            'totalTagihan',
            'totalLunas',
            'totalBelum',
            'totalPemasukan',
            'pemasukanBulanIni',
            'growthPersen',
            'tunggakan',
            'chartData',
            'perKelas',
            'transaksiTerbaru',
            'kategoris',
            'bulanIni',
            'tahunIni',
        ));
    }
}
