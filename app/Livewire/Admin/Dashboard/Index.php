<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\kategori_spp;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        /** @disregard P1005 */
        $totalSiswa     = Siswa::count();
        /** @disregard P1005 */
        $totalWali      = User::where('role', 'wali_murid')->count();
        /** @disregard P1005 */
        $totalTagihan   = Tagihan::count();
        /** @disregard P1005 */
        $tagLunas       = Tagihan::where('status_tagihan', 'Lunas')->count();
        /** @disregard P1005 */
        $tagBelum       = Tagihan::where('status_tagihan', 'Belum Lunas')->count();

        /** @disregard P1005 */
        $terkumpul = Pembayaran::whereIn('status_pembayaran', ['settlement', 'capture', 'Lunas'])
            ->sum('jumlah_bayar');

        // Potensi total (semua tagihan × nominal kategori)
        $potensi = Tagihan::with('kategori_spp')
            ->get()
            ->sum(fn($t) => $t->kategori_spp->nominal_spp ?? 0);

        // Tagihan belum lunas terbaru (5 data)
        $tagihanMenunggu = Tagihan::with(['siswa', 'kategori_spp'])
            ->where('status_tagihan', 'Belum Lunas')
            ->latest()
            ->take(5)
            ->get();

        // Pembayaran terbaru (5 data)
        $pembayaranTerbaru = Pembayaran::with(['tagihan.siswa'])
            ->latest()
            ->take(5)
            ->get();

        // Rekapitulasi per bulan (12 bulan terakhir dari tagihan lunas)
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
            'Desember'
        ];
        $rekapBulan = collect($bulanList)->map(function ($bulan) {
            /** @disregard P1005 */
            return [
                'bulan'  => $bulan,
                'lunas'  => Tagihan::where('bulan', $bulan)
                    ->where('tahun', now()->year)
                    ->where('status_tagihan', 'Lunas')->count(),
                'belum'  => Tagihan::where('bulan', $bulan)
                    ->where('tahun', now()->year)
                    ->where('status_tagihan', 'Belum Lunas')->count(),
            ];
        });

        // Top 5 santri dengan tagihan belum lunas terbanyak
        $santriTunggakan = Siswa::withCount([
            'tagihan as belum_lunas_count' => fn($q) => $q->where('status_tagihan', 'Belum Lunas')
        ])->having('belum_lunas_count', '>', 0)
            ->orderByDesc('belum_lunas_count')
            ->take(5)
            ->get();

        /** @disregard P1005 */
        $kategoris = kategori_spp::latest()->take(5)->get();

        $persen = $potensi > 0 ? round(($terkumpul / $potensi) * 100, 1) : 0;

        return view('livewire.admin.dashboard.index', compact(
            'totalSiswa',
            'totalWali',
            'totalTagihan',
            'tagLunas',
            'tagBelum',
            'terkumpul',
            'potensi',
            'persen',
            'tagihanMenunggu',
            'pembayaranTerbaru',
            'rekapBulan',
            'santriTunggakan',
            'kategoris',
            'bulanList'
        ));
    }
}
