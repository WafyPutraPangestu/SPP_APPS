<?php

namespace App\Exports;

use App\Models\Tagihan;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Maatwebsite\Excel\Facades\Excel;

class TagihanExport
{
    protected $filterStatus;
    protected $filterKategori;
    protected $filterBulan;
    protected $filterTahun;

    public function __construct($filterStatus = null, $filterKategori = null, $filterBulan = null, $filterTahun = null)
    {
        $this->filterStatus   = $filterStatus;
        $this->filterKategori = $filterKategori;
        $this->filterBulan    = $filterBulan;
        $this->filterTahun    = $filterTahun;
    }

    public function download(): BinaryFileResponse
    {
        // 1. Load template
        $templatePath = base_path('file-excel-revisi/Data-Manajemen-Tagihan.xlsx');
        $spreadsheet  = IOFactory::load($templatePath);
        $sheet        = $spreadsheet->getActiveSheet();

        // 2. Ambil data sesuai filter
        $tagihans = Tagihan::with(['siswa', 'kategori_spp'])
            ->when($this->filterStatus,   fn($q) => $q->where('status_tagihan', $this->filterStatus))
            ->when($this->filterKategori, fn($q) => $q->where('id_kategori', $this->filterKategori))
            ->when($this->filterBulan,    fn($q) => $q->where('bulan', $this->filterBulan))
            ->when($this->filterTahun,    fn($q) => $q->where('tahun', $this->filterTahun))
            ->orderBy('status_tagihan', 'asc')
            ->orderBy('tahun', 'desc')
            ->orderByRaw("FIELD(bulan, 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember') DESC")
            ->latest('id_tagihan')
            ->get();

        // 3. Isi data mulai dari baris 8
        $startRow = 8;
        foreach ($tagihans as $i => $tagihan) {
            $row = $startRow + $i;
            $no  = $i + 1;

            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $tagihan->siswa->nama_siswa ?? '—');
            $sheet->setCellValue('D' . $row, $tagihan->siswa->nis ?? '—');
            $sheet->setCellValue('G' . $row, $tagihan->siswa->kelas ?? '—');
            $sheet->setCellValue('I' . $row, $tagihan->bulan . ' ' . $tagihan->tahun);
            $sheet->setCellValue('K' . $row, 'Rp ' . number_format($tagihan->kategori_spp->nominal_spp ?? 0, 0, ',', '.'));
            $sheet->setCellValue('M' . $row, $tagihan->status_tagihan);
            $sheet->setCellValue('O' . $row, $tagihan->kategori_spp->tahun_ajaran ?? '—');
        }

        // 4. Simpan ke file temp dan download
        $filename = 'Data-Manajemen-Tagihan-' . now()->format('Ymd-His') . '.xlsx';
        $tmpPath  = storage_path('app/' . $filename);

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($tmpPath);

        return response()->download($tmpPath, $filename)->deleteFileAfterSend(true);
    }
}
