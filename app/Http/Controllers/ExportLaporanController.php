<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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

        // ── 1. Buka template Excel ─────────────────────────────
        $templatePath = base_path('file-excel-revisi/Laporan-Keuangan-SPP.xlsx');
        $spreadsheet  = IOFactory::load($templatePath);
        $sheet        = $spreadsheet->getActiveSheet();

        // ── 2. Tulis info filter di row 5 (opsional) ──────────
        $filterTexts = [];
        if ($request->bulan) $filterTexts[] = "Bulan: {$request->bulan}";
        if ($request->tahun) $filterTexts[] = "Tahun: {$request->tahun}";
        if ($request->status) $filterTexts[] = "Status: {$request->status}";
        if ($request->kelas) $filterTexts[] = "Kelas: {$request->kelas}";

        $filterString = !empty($filterTexts) ? 'Filter: ' . implode(' | ', $filterTexts) : 'Semua Data';
        $sheet->setCellValue('A5', 'Waktu Cetak: ' . now()->format('d/m/Y H:i') . '  •  ' . $filterString);
        $sheet->getStyle('A5')->applyFromArray([
            'font' => ['italic' => true, 'size' => 10, 'color' => ['argb' => 'FF555555']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT]
        ]);
        $sheet->getRowDimension(5)->setRowHeight(20);

        // ── 3. Isi data mulai row 8 ───────────────────────────
        $startRow       = 8;
        $templateEndRow = 23;

        foreach ($tagihans as $index => $t) {
            $row = $startRow + $index;

            // Jika melebihi baris template → tambahkan merge & salin style
            if ($row > $templateEndRow) {
                $prevRow = $row - 1;
                $sheet->mergeCells("B{$row}:C{$row}");
                $sheet->mergeCells("G{$row}:H{$row}");
                $sheet->mergeCells("I{$row}:J{$row}");

                // Salin style dari baris sebelumnya
                foreach (['A', 'B', 'D', 'E', 'F', 'G', 'I', 'K', 'L'] as $col) {
                    $sheet->duplicateStyle(
                        $sheet->getStyle("{$col}{$prevRow}"),
                        "{$col}{$row}"
                    );
                }
            }

            $p = $t->pembayaran->where('status_pembayaran', 'settlement')->first();

            // Isi nilai
            // A: No, B:C: Siswa, D: Kelas, E: Periode, F: Kategori, G:H: Nominal, I:J: Status, K: Dibayar Via, L: Waktu Bayar
            $sheet->setCellValue("A{$row}", $index + 1);
            $sheet->setCellValue("B{$row}", $t->siswa->nama_siswa);
            $sheet->setCellValue("D{$row}", $t->siswa->kelas);
            $sheet->setCellValue("E{$row}", $t->bulan . ' ' . $t->tahun);
            $sheet->setCellValue("F{$row}", $t->kategori_spp->tahun_ajaran ?? '-');
            $sheet->setCellValue("G{$row}", $t->kategori_spp->nominal_spp ?? 0);
            $sheet->setCellValue("I{$row}", $t->status_tagihan);
            $sheet->setCellValue("K{$row}", $p?->metode_bayar ?? '-');
            $sheet->setCellValue("L{$row}", $p?->waktu_pembayaran?->format('d/m/Y H:i') ?? '-');
        }

        // ── 4. Stream download ─────────────────────────────────
        $namaFile = 'Laporan_Keuangan_SPP_' . now()->format('Ymd_His') . '.xlsx';
        $writer   = new Xlsx($spreadsheet);

        return response()->streamDownload(
            function () use ($writer) {
                $writer->save('php://output');
            },
            $namaFile,
            [
                'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $namaFile . '"',
                'Cache-Control'       => 'max-age=0',
            ]
        );
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

    /**
     * Export riwayat tagihan satu siswa menggunakan template Excel.
     * Template: file-excel-revisi/Riwayat Tagihan Santri.xlsx
     */
    public function exportTagihanSiswa(Siswa $siswa): StreamedResponse
    {
        // Load semua relasi yang dibutuhkan
        $siswa->load(['user', 'tagihan.kategori_spp']);

        // ── 1. Buka template Excel ─────────────────────────────
        $templatePath = base_path('file-excel-revisi/Riwayat Tagihan Santri.xlsx');
        $spreadsheet  = IOFactory::load($templatePath);
        $sheet        = $spreadsheet->getActiveSheet();

        // ── 2. Tulis info siswa di row 5 & 6 (yang kosong) ────
        $sheet->mergeCells('B5:K5');
        $sheet->mergeCells('B6:K6');

        $sheet->setCellValue('B5',
            'Nama Santri : ' . $siswa->nama_siswa .
            '     NIS : '    . $siswa->nis .
            '     Kelas : '  . $siswa->kelas
        );

        $waliNama  = $siswa->user?->name  ?? '-';
        $waliEmail = $siswa->user?->email ?? '-';
        $sheet->setCellValue('B6', 'Wali Murid : ' . $waliNama . '     Email : ' . $waliEmail);

        // Style row 5 & 6
        foreach (['B5', 'B6'] as $cell) {
            $sheet->getStyle($cell)->applyFromArray([
                'font'      => ['bold' => false, 'size' => 10],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                ],
            ]);
        }
        $sheet->getRowDimension(5)->setRowHeight(18);
        $sheet->getRowDimension(6)->setRowHeight(18);

        // ── 3. Isi data tagihan mulai row 8 ───────────────────
        $startRow       = 8;
        $templateEndRow = 23; // baris terakhir yang sudah ada di template
        $tagihans       = $siswa->tagihan;

        foreach ($tagihans as $index => $tagihan) {
            $row = $startRow + $index;

            // Jika melebihi baris template → tambahkan merge & salin style
            if ($row > $templateEndRow) {
                $prevRow = $row - 1;
                $sheet->mergeCells("B{$row}:C{$row}");
                $sheet->mergeCells("D{$row}:F{$row}");
                $sheet->mergeCells("G{$row}:H{$row}");
                $sheet->mergeCells("I{$row}:J{$row}");

                // Salin style dari baris sebelumnya
                foreach (['A', 'B', 'D', 'G', 'I'] as $col) {
                    $sheet->duplicateStyle(
                        $sheet->getStyle("{$col}{$prevRow}"),
                        "{$col}{$row}"
                    );
                }
            }

            // Isi nilai
            $sheet->setCellValue("A{$row}", $index + 1);
            $sheet->setCellValue("B{$row}", $tagihan->bulan . ' ' . $tagihan->tahun);
            $sheet->setCellValue("D{$row}", $tagihan->kategori_spp->tahun_ajaran ?? '-');
            $sheet->setCellValue("G{$row}", $tagihan->kategori_spp->nominal_spp ?? 0);
            $sheet->setCellValue("I{$row}", $tagihan->status_tagihan);
        }

        // ── 4. Stream download ─────────────────────────────────
        $namaFile = 'Riwayat_Tagihan_' . str_replace(' ', '_', $siswa->nama_siswa) . '.xlsx';
        $writer   = new Xlsx($spreadsheet);

        return response()->streamDownload(
            function () use ($writer) {
                $writer->save('php://output');
            },
            $namaFile,
            [
                'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $namaFile . '"',
                'Cache-Control'       => 'max-age=0',
            ]
        );
    }

    /**
     * Export daftar tagihan siswa milik satu wali murid menggunakan template Excel.
     * Template: file-excel-revisi/Riwayat-Tagihan-Wali-Santri.xlsx
     * Kolom: No | Siswa | NIS | Kelas | Tagihan (ringkasan lunas/total)
     */
    public function exportTagihanWaliMurid(User $user): StreamedResponse
    {
        // Load siswa beserta tagihan
        $user->load(['siswa.tagihan']);

        // ── 1. Buka template ──────────────────────────────────
        $templatePath = base_path('file-excel-revisi/Riwayat-Tagihan-Wali-Santri.xlsx');
        $spreadsheet  = IOFactory::load($templatePath);
        $sheet        = $spreadsheet->getActiveSheet();

        // ── 2. Info wali murid di row 5 & 6 (kosong) ─────────
        $sheet->mergeCells('B5:K5');
        $sheet->mergeCells('B6:K6');

        $sheet->setCellValue('B5', 'Nama Wali Murid : ' . $user->name . '     Email : ' . $user->email);
        $sheet->setCellValue('B6', 'Jumlah Santri Terdaftar : ' . $user->siswa->count() . ' Santri');

        foreach (['B5', 'B6'] as $cell) {
            $sheet->getStyle($cell)->applyFromArray([
                'font'      => ['bold' => false, 'size' => 10],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                ],
            ]);
        }
        $sheet->getRowDimension(5)->setRowHeight(18);
        $sheet->getRowDimension(6)->setRowHeight(18);

        // ── 3. Isi data siswa mulai row 8 ─────────────────────
        // Header row 7: No | Siswa (B:C) | NIS (D:F) | Kelas (G:H) | Tagihan (I:J)
        $startRow       = 8;
        $templateEndRow = 23;
        $siswas         = $user->siswa;

        foreach ($siswas as $index => $siswa) {
            $row = $startRow + $index;

            // Tambah merge & salin style jika melebihi template
            if ($row > $templateEndRow) {
                $prevRow = $row - 1;
                $sheet->mergeCells("B{$row}:C{$row}");
                $sheet->mergeCells("D{$row}:F{$row}");
                $sheet->mergeCells("G{$row}:H{$row}");
                $sheet->mergeCells("I{$row}:J{$row}");
                foreach (['A', 'B', 'D', 'G', 'I'] as $col) {
                    $sheet->duplicateStyle(
                        $sheet->getStyle("{$col}{$prevRow}"),
                        "{$col}{$row}"
                    );
                }
            }

            // Hitung ringkasan tagihan
            $tagihanTotal = $siswa->tagihan->count();
            $tagihanLunas = $siswa->tagihan->where('status_tagihan', 'Lunas')->count();
            $tagihanRingkas = $tagihanTotal > 0
                ? "{$tagihanLunas}/{$tagihanTotal} Lunas"
                : 'Belum ada tagihan';

            $sheet->setCellValue("A{$row}", $index + 1);
            $sheet->setCellValue("B{$row}", $siswa->nama_siswa);
            $sheet->setCellValue("D{$row}", $siswa->nis);
            $sheet->setCellValue("G{$row}", $siswa->kelas);
            $sheet->setCellValue("I{$row}", $tagihanRingkas);
        }

        // ── 4. Stream download ────────────────────────────────
        $namaFile = 'Riwayat_Tagihan_Wali_' . str_replace(' ', '_', $user->name) . '.xlsx';
        $writer   = new Xlsx($spreadsheet);

        return response()->streamDownload(
            function () use ($writer) {
                $writer->save('php://output');
            },
            $namaFile,
            [
                'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $namaFile . '"',
                'Cache-Control'       => 'max-age=0',
            ]
        );
    }
}
