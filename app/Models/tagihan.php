<?php
// ── App\Models\Tagihan ───────────────────────────────────────────

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

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
}
