<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['id_siswa', 'id_user', 'nis', 'nama_siswa', 'kelas'])]
class Siswa extends Model
{
    protected $primaryKey = 'id_siswa';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class, 'id_siswa', 'id_siswa');
    }
}
