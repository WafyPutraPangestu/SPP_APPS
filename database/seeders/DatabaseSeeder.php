<?php

namespace Database\Seeders;

use App\Models\kategori_spp;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ══════════════════════════════════════════
        //  1. USERS
        // ══════════════════════════════════════════

        $admin = User::create([
            'name'     => 'Admin La-Taksal',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
        ]);

        $kepsek = User::create([
            'name'     => 'Kepala Sekolah La-Taksal',
            'email'    => 'kepsek@gmail.com',
            'password' => Hash::make('password123'),
            'role'     => 'kepala_sekolah',
        ]);

        // Wali murid — buat beberapa agar data lebih kaya
        $waliData = [
            ['name' => 'Bapak Budi Santoso',    'email' => 'walimurid@gmail.com'],
            ['name' => 'Ibu Siti Rahayu',        'email' => 'siti@gmail.com'],
            ['name' => 'Bapak Ahmad Fauzi',      'email' => 'ahmad@gmail.com'],
            ['name' => 'Ibu Dewi Kurniawati',    'email' => 'dewi@gmail.com'],
            ['name' => 'Bapak Hendra Wijaya',    'email' => 'hendra@gmail.com'],
        ];

        $walis = collect($waliData)->map(fn($w) => User::create([
            'name'     => $w['name'],
            'email'    => $w['email'],
            'password' => Hash::make('password123'),
            'role'     => 'wali_murid',
        ]));

        // ══════════════════════════════════════════
        //  2. KATEGORI SPP
        // ══════════════════════════════════════════

        $kategori2025 = kategori_spp::create([
            'tahun_ajaran' => '2025/2026',
            'nominal_spp'  => 250000,
        ]);

        $kategori2026 = kategori_spp::create([
            'tahun_ajaran' => '2026/2027',
            'nominal_spp'  => 275000,
        ]);

        // ══════════════════════════════════════════
        //  3. SISWA  (tiap wali punya 1–2 anak)
        // ══════════════════════════════════════════

        $siswaData = [
            // wali index 0 — Bapak Budi
            ['id_user' => $walis[0]->id, 'nis' => '20240001', 'nama_siswa' => 'Muhammad Rizky Santoso',  'kelas' => 'VII-A'],
            ['id_user' => $walis[0]->id, 'nis' => '20240002', 'nama_siswa' => 'Salsabila Budi Santoso',  'kelas' => 'VIII-B'],

            // wali index 1 — Ibu Siti
            ['id_user' => $walis[1]->id, 'nis' => '20240003', 'nama_siswa' => 'Fadhil Rahayu',           'kelas' => 'VII-A'],

            // wali index 2 — Bapak Ahmad
            ['id_user' => $walis[2]->id, 'nis' => '20240004', 'nama_siswa' => 'Nurul Hidayah Fauzi',    'kelas' => 'IX-A'],
            ['id_user' => $walis[2]->id, 'nis' => '20240005', 'nama_siswa' => 'Habibie Ahmad Fauzi',    'kelas' => 'VII-B'],

            // wali index 3 — Ibu Dewi
            ['id_user' => $walis[3]->id, 'nis' => '20240006', 'nama_siswa' => 'Zahra Kurniawati',       'kelas' => 'VIII-A'],

            // wali index 4 — Bapak Hendra
            ['id_user' => $walis[4]->id, 'nis' => '20240007', 'nama_siswa' => 'Farhan Wijaya',          'kelas' => 'IX-B'],
            ['id_user' => $walis[4]->id, 'nis' => '20240008', 'nama_siswa' => 'Alya Hendra Wijaya',     'kelas' => 'VIII-B'],
        ];

        $siswas = collect($siswaData)->map(fn($s) => Siswa::create($s));

        // ══════════════════════════════════════════
        //  4. TAGIHAN — Hanya 2 bulan untuk demo (September & Oktober)
        // ══════════════════════════════════════════

        $bulanList = [
            'September', // index 0
            'Oktober',   // index 1
        ];

        $polaBayar = [
            // [bulanIndex => bayar?]
            0 => [0], // Lunas September (index 0), Oktober (index 1) belum lunas
            1 => [0],
            2 => [0],
            3 => [0],
            4 => [0],
            5 => [0],
            6 => [0],
            7 => [0],
        ];

        foreach ($siswas as $idx => $siswa) {
            // Gunakan kategori 2026/2027 untuk semua tagihan
            $kategori = $kategori2026;

            foreach ($bulanList as $bulanIdx => $bulan) {
                $sudahBayar = in_array($bulanIdx, $polaBayar[$idx] ?? []);

                $tagihan = Tagihan::create([
                    'id_siswa'       => $siswa->id_siswa,
                    'id_kategori'    => $kategori->id_kategori,
                    'bulan'          => $bulan,
                    'tahun'          => 2026,
                    'status_tagihan' => $sudahBayar ? 'Lunas' : 'Belum Lunas',
                ]);

                if ($sudahBayar) {
                    // Tanggal bayar: awal bulan tersebut
                    $tglBayar = now()
                        ->setYear(2026)
                        ->setMonth($bulanIdx + 1)
                        ->setDay(rand(1, 10))
                        ->setTime(rand(8, 17), rand(0, 59), 0);

                    $metodePilihan = collect(['QRIS', 'Transfer Bank', 'GoPay', 'OVO', 'Dana', 'BCA Virtual Account']);
                    $metode = $metodePilihan->random();

                    Pembayaran::create([
                        'order_id'                => 'SPP-' . $tagihan->id_tagihan . '-' . strtoupper(Str::random(8)),
                        'id_tagihan'              => $tagihan->id_tagihan,
                        'jumlah_bayar'            => $kategori->nominal_spp,
                        'snap_token'              => null,
                        'midtrans_transaction_id' => 'TXN-' . strtoupper(Str::random(12)),
                        'metode_bayar'            => $metode,
                        'status_pembayaran'       => 'settlement',
                        'waktu_pembayaran'        => $tglBayar,
                        'callback_payload'        => json_encode([
                            'transaction_status' => 'settlement',
                            'payment_type'       => strtolower(str_replace(' ', '_', $metode)),
                            'gross_amount'       => (string) $kategori->nominal_spp,
                        ]),
                    ]);
                }
            }
        }


        // ══════════════════════════════════════════
        //  6. SATU PEMBAYARAN PENDING (untuk test UI)
        // ══════════════════════════════════════════
        /** @disregard P1005 */
        $tagihanPending = Tagihan::where('status_tagihan', 'Belum Lunas')->first();
        if ($tagihanPending) {
            Pembayaran::create([
                'order_id'           => 'SPP-' . $tagihanPending->id_tagihan . '-PENDING01',
                'id_tagihan'         => $tagihanPending->id_tagihan,
                'jumlah_bayar'       => $kategori2026->nominal_spp,
                'snap_token'         => 'test-snap-token-' . Str::random(16),
                'status_pembayaran'  => 'pending',
                'waktu_pembayaran'   => null,
            ]);
        }
    }
}
