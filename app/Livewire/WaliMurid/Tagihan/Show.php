<?php

namespace App\Livewire\WaliMurid\Tagihan;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class Show extends Component
{
    public int $tagihanId;
    public ?Tagihan $tagihan = null;
    public ?string $snapToken = null;
    public bool $loading = false;
    public string $errorMsg = '';

    public function mount($tagihanId): void
    {
        $this->tagihanId = (int) $tagihanId;

        $siswaIds = Auth::user()->siswa()->pluck('id_siswa');

        $this->tagihan = Tagihan::with(['siswa', 'kategori_spp', 'pembayaran'])
            ->whereIn('id_siswa', $siswaIds)
            ->findOrFail($this->tagihanId);
    }

    public function bayar(): void
    {
        $this->loading  = true;
        $this->errorMsg = '';

        try {
            $tagihan = $this->tagihan;

            if ($tagihan->status_tagihan === 'Lunas') {
                $this->errorMsg = 'Tagihan ini sudah lunas.';
                $this->loading  = false;
                return;
            }
            /** @disregard P1005 */
            $existing = Pembayaran::where('id_tagihan', $tagihan->id_tagihan)
                ->where('status_pembayaran', 'pending')
                ->whereNotNull('snap_token')
                ->latest()
                ->first();

            if ($existing?->snap_token) {
                $this->snapToken = $existing->snap_token;
                $this->loading   = false;
                $this->dispatch('open-snap', token: $this->snapToken);
                return;
            }

            $orderId = 'SPP-' . $tagihan->id_tagihan . '-' . strtoupper(Str::random(8));

            \Midtrans\Config::$serverKey    = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            \Midtrans\Config::$isSanitized  = true;
            \Midtrans\Config::$is3ds        = true;

            $siswa = $tagihan->siswa;
            $user  = Auth::user();

            $params = [
                'transaction_details' => [
                    'order_id'     => $orderId,
                    'gross_amount' => $tagihan->kategori_spp->nominal_spp,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email'      => $user->email,
                ],
                'item_details' => [[
                    'id'       => $tagihan->id_tagihan,
                    'price'    => $tagihan->kategori_spp->nominal_spp,
                    'quantity' => 1,
                    'name'     => "SPP {$siswa->nama_siswa} – {$tagihan->bulan} {$tagihan->tahun}",
                ]],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            Pembayaran::create([
                'order_id'          => $orderId,
                'id_tagihan'        => $tagihan->id_tagihan,
                'jumlah_bayar'      => $tagihan->kategori_spp->nominal_spp,
                'snap_token'        => $snapToken,
                'status_pembayaran' => 'pending',
            ]);

            $this->snapToken = $snapToken;
            $this->dispatch('open-snap', token: $snapToken);
        } catch (\Exception $e) {
            $this->errorMsg = 'Gagal menghubungi payment gateway. Silakan coba lagi.';
            logger()->error('Midtrans error: ' . $e->getMessage());
        }

        $this->loading = false;
    }

    public function refreshStatus(): void
    {
        $this->tagihan = Tagihan::with(['siswa', 'kategori_spp', 'pembayaran'])
            ->find($this->tagihanId);
    }

    public function render()
    {
        return view('livewire.wali-murid.tagihan.show');
    }
}
