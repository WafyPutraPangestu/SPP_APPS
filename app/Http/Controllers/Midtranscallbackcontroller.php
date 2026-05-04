<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
    /**
     * Midtrans akan POST ke endpoint ini setiap kali status transaksi berubah.
     * Endpoint ini HARUS dikecualikan dari CSRF (sudah ditangani di bootstrap/app.php).
     */
    public function handle(Request $request): \Illuminate\Http\JsonResponse
    {
        $payload = $request->all();

        Log::info('Midtrans callback received', ['order_id' => $payload['order_id'] ?? null]);

        // ── 1. Verifikasi signature key ────────────────────────
        $serverKey         = config('midtrans.server_key');
        $orderId           = $payload['order_id']           ?? '';
        $statusCode        = $payload['status_code']        ?? '';
        $grossAmount       = $payload['gross_amount']       ?? '';
        $signatureKey      = $payload['signature_key']      ?? '';

        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signatureKey !== $expectedSignature) {
            Log::warning('Midtrans callback: invalid signature', ['order_id' => $orderId]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        /** @disregard P1005 */

        $pembayaran = Pembayaran::where('order_id', $orderId)->first();

        if (!$pembayaran) {
            Log::warning('Midtrans callback: pembayaran tidak ditemukan', ['order_id' => $orderId]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Jangan proses ulang yang sudah settlement/cancel
        if (in_array($pembayaran->status_pembayaran, ['settlement', 'cancel', 'expire'])) {
            return response()->json(['message' => 'Already processed']);
        }

        // ── 3. Map status Midtrans → status internal ───────────
        $transactionStatus = $payload['transaction_status'] ?? '';
        $fraudStatus       = $payload['fraud_status']       ?? '';
        $paymentType       = $payload['payment_type']       ?? null;

        $statusBaru = match (true) {
            $transactionStatus === 'capture' && $fraudStatus === 'accept' => 'settlement',
            $transactionStatus === 'settlement'                           => 'settlement',
            $transactionStatus === 'pending'                              => 'pending',
            $transactionStatus === 'deny'                                 => 'deny',
            $transactionStatus === 'expire'                               => 'expire',
            $transactionStatus === 'cancel'                               => 'cancel',
            default                                                       => $pembayaran->status_pembayaran,
        };

        // ── 4. Update pembayaran ───────────────────────────────
        $pembayaran->update([
            'status_pembayaran'       => $statusBaru,
            'midtrans_transaction_id' => $payload['transaction_id'] ?? $pembayaran->midtrans_transaction_id,
            'metode_bayar'            => $this->resolveMetode($paymentType, $payload),
            'waktu_pembayaran'        => $statusBaru === 'settlement'
                ? now()->parse($payload['settlement_time'] ?? now())
                : $pembayaran->waktu_pembayaran,
            'callback_payload'        => $payload,
        ]);

        if ($statusBaru === 'settlement') {
            /** @disregard P1005 */
            Tagihan::where('id_tagihan', $pembayaran->id_tagihan)
                ->update(['status_tagihan' => 'Lunas']);

            Log::info('Tagihan dilunasi via Midtrans', [
                'order_id'    => $orderId,
                'id_tagihan'  => $pembayaran->id_tagihan,
            ]);
        }

        return response()->json(['message' => 'OK']);
    }

    /**
     * Ubah payment_type Midtrans menjadi label yang lebih ramah.
     */
    private function resolveMetode(?string $paymentType, array $payload): string
    {
        return match ($paymentType) {
            'credit_card'       => 'Kartu Kredit',
            'bank_transfer'     => 'Transfer Bank ' . strtoupper($payload['va_numbers'][0]['bank'] ?? ''),
            'echannel'          => 'Mandiri Bill',
            'bca_klikpay'       => 'BCA KlikPay',
            'cimb_clicks'       => 'CIMB Clicks',
            'danamon_online'    => 'Danamon Online',
            'qris'              => 'QRIS',
            'gopay'             => 'GoPay',
            'shopeepay'         => 'ShopeePay',
            'akulaku'           => 'Akulaku',
            'kredivo'           => 'Kredivo',
            'indomaret'         => 'Indomaret',
            'alfamart'          => 'Alfamart',
            default             => ucfirst(str_replace('_', ' ', $paymentType ?? 'Lainnya')),
        };
    }
}
