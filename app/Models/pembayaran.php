<?php
// ── App\Models\Pembayaran ────────────────────────────────────────

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'order_id',
    'id_tagihan',
    'jumlah_bayar',
    'snap_token',
    'midtrans_transaction_id',
    'metode_bayar',
    'status_pembayaran',
    'waktu_pembayaran',
    'callback_payload',
])]
class Pembayaran extends Model
{
    protected $primaryKey = 'id_pembayaran';

    protected $casts = [
        'callback_payload' => 'array',
        'waktu_pembayaran' => 'datetime',
    ];

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'id_tagihan', 'id_tagihan');
    }
}
