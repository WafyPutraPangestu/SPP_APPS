<?php
// ── App\Models\Tagihan ───────────────────────────────────────────

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

#[Fillable(['id_siswa', 'id_kategori', 'bulan', 'tahun', 'status_tagihan'])]
class Tagihan extends Model
{
    protected $primaryKey = 'id_tagihan';

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public function kategori_spp()
    {
        return $this->belongsTo(kategori_spp::class, 'id_kategori', 'id_kategori');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_tagihan', 'id_tagihan');
    }
    public function getIsTerlambatAttribute()
    {
        // Jika sudah lunas, tidak mungkin terlambat
        if ($this->status_tagihan === 'Lunas') {
            return false;
        }

        // Mapping nama bulan Indonesia ke angka
        $bulanMap = [
            'Januari' => 1,
            'Februari' => 2,
            'Maret' => 3,
            'April' => 4,
            'Mei' => 5,
            'Juni' => 6,
            'Juli' => 7,
            'Agustus' => 8,
            'September' => 9,
            'Oktober' => 10,
            'November' => 11,
            'Desember' => 12
        ];

        $bulanAngka = $bulanMap[$this->bulan] ?? null;

        if (!$bulanAngka) {
            return false;
        }

        // Tentukan batas waktu (contoh: Tanggal 10 pukul 23:59:59 di bulan dan tahun tagihan)
        $jatuhTempo = Carbon::createFromDate($this->tahun, $bulanAngka, 10)->addMonth()->endOfDay();

        // Kembalikan nilai true jika waktu saat ini melebihi jatuh tempo
        return now()->greaterThan($jatuhTempo);
    }
}
