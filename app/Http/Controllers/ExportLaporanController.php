<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportLaporanController extends Controller
{
    public function export(Request $request): StreamedResponse
    {
        $tagihans = Tagihan::with(['siswa', 'kategori_spp', 'pembayaran'])
            ->when($request->bulan,    fn($q) => $q->where('bulan', $request->bulan))
            ->when($request->tahun,    fn($q) => $q->where('tahun', $request->tahun))
            ->when($request->status,   fn($q) => $q->where('status_tagihan', $request->status))
            ->when($request->kategori, fn($q) => $q->where('id_kategori', $request->kategori))
            ->when($request->kelas,    fn($q) => $q->whereHas('siswa', fn($q2) => $q2->where('kelas', $request->kelas)))
            ->latest()
            ->get();

        $filename = 'Laporan_SPP_' . now()->format('Y-m-d_His') . '.csv';

        return response()->streamDownload(function () use ($tagihans) {
            $handle = fopen('php://output', 'w');

            // BOM for UTF-8 Excel compatibility
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header row
            fputcsv($handle, [
                'No',
                'Nama Siswa',
                'NIS',
                'Kelas',
                'Bulan',
                'Tahun',
                'Kategori SPP',
                'Nominal',
                'Status',
                'Metode Bayar',
                'Waktu Pembayaran',
            ], ';');

            // Data rows
            foreach ($tagihans as $i => $t) {
                $p = $t->pembayaran->where('status_pembayaran', 'settlement')->first();

                fputcsv($handle, [
                    $i + 1,
                    $t->siswa->nama_siswa,
                    $t->siswa->nis,
                    $t->siswa->kelas,
                    $t->bulan,
                    $t->tahun,
                    $t->kategori_spp->tahun_ajaran,
                    $t->kategori_spp->nominal_spp,
                    $t->status_tagihan,
                    $p?->metode_bayar ?? '-',
                    $p?->waktu_pembayaran?->format('d/m/Y') ?? '-',
                ], ';');
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function exportSiswa(): StreamedResponse
    {
        $siswas = Siswa::with('user')->latest()->get();

        $filename = 'Data_Santri_' . now()->format('Y-m-d_His') . '.csv';

        return response()->streamDownload(function () use ($siswas) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'No',
                'Nama Santri',
                'NIS',
                'Kelas',
                'Wali Murid',
                'Email Wali',
                'Tanggal Terdaftar',
            ], ';');

            foreach ($siswas as $i => $s) {
                fputcsv($handle, [
                    $i + 1,
                    $s->nama_siswa,
                    $s->nis,
                    $s->kelas,
                    $s->user?->name ?? '-',
                    $s->user?->email ?? '-',
                    $s->created_at?->format('d/m/Y') ?? '-',
                ], ';');
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function exportWaliMurid(): StreamedResponse
    {
        /** @disregard P1005 */
        $users = User::where('role', 'wali_murid')
            ->with('siswa')
            ->latest()
            ->get();

        $filename = 'Data_Wali_Murid_' . now()->format('Y-m-d_His') . '.csv';

        return response()->streamDownload(function () use ($users) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'No',
                'Nama Wali Murid',
                'Email',
                'Jumlah Anak',
                'Daftar Anak',
                'Tanggal Registrasi',
            ], ';');

            foreach ($users as $i => $u) {
                $anakList = $u->siswa->pluck('nama_siswa')->implode(', ') ?: '-';

                fputcsv($handle, [
                    $i + 1,
                    $u->name,
                    $u->email,
                    $u->siswa->count(),
                    $anakList,
                    $u->created_at?->format('d/m/Y') ?? '-',
                ], ';');
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
