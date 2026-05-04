<?php
// ── App\Models\kategori_spp ──────────────────────────────────────

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['tahun_ajaran', 'nominal_spp'])]
class kategori_spp extends Model
{
    protected $primaryKey = 'id_kategori';

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class, 'id_kategori', 'id_kategori');
    }
}
