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

        $kategori2024 = kategori_spp::create([
            'tahun_ajaran' => '2024/2025',
            'nominal_spp'  => 250000,
        ]);

        $kategori2025 = kategori_spp::create([
            'tahun_ajaran' => '2025/2026',
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
        //  4. TAGIHAN — 12 bulan untuk tiap siswa
        // ══════════════════════════════════════════

        $bulanList = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];

        // Pola pembayaran: indeks 0–4 = sudah bayar, 5–11 = belum (simulasi semester)
        // Ini akan kita variasikan per siswa agar data terasa realistis

        $polaBayar = [
            // [bulanIndex => bayar?]
            0 => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],       // siswa 0: rajin, 10 bulan lunas
            1 => [0, 1, 2, 3, 4, 5],                // siswa 1: 6 bulan lunas
            2 => [0, 1, 2, 3, 4, 5, 6, 7],            // siswa 2: 8 bulan lunas
            3 => [0, 1, 2, 3],                    // siswa 3: 4 bulan lunas
            4 => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11], // siswa 4: lunas semua 12 bulan
            5 => [0, 1, 2],                      // siswa 5: hanya 3 bulan
            6 => [0, 1, 2, 3, 4, 5, 6, 7, 8],         // siswa 6: 9 bulan
            7 => [0, 1, 2, 3, 4],                  // siswa 7: 5 bulan
        ];

        foreach ($siswas as $idx => $siswa) {
            // Gunakan kategori 2024/2025 untuk semua tagihan
            $kategori = $kategori2024;

            foreach ($bulanList as $bulanIdx => $bulan) {
                $sudahBayar = in_array($bulanIdx, $polaBayar[$idx] ?? []);

                $tagihan = Tagihan::create([
                    'id_siswa'       => $siswa->id_siswa,
                    'id_kategori'    => $kategori->id_kategori,
                    'bulan'          => $bulan,
                    'tahun'          => 2025,
                    'status_tagihan' => $sudahBayar ? 'Lunas' : 'Belum Lunas',
                ]);

                if ($sudahBayar) {
                    // Tanggal bayar: awal bulan tersebut
                    $tglBayar = now()
                        ->setYear(2025)
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
        //  5. TAGIHAN BULAN BERJALAN (Mei 2026)
        //     Supaya dashboard "bulan ini" terisi
        // ══════════════════════════════════════════

        $bulanSekarang = 'Mei';
        $tahunSekarang = 2026;

        foreach ($siswas as $idx => $siswa) {
            // Siswa genap (0,2,4,6) = sudah bayar bulan ini
            $sudahBayar = ($idx % 2 === 0);

            $tagihan = Tagihan::create([
                'id_siswa'       => $siswa->id_siswa,
                'id_kategori'    => $kategori2025->id_kategori,
                'bulan'          => $bulanSekarang,
                'tahun'          => $tahunSekarang,
                'status_tagihan' => $sudahBayar ? 'Lunas' : 'Belum Lunas',
            ]);

            if ($sudahBayar) {
                $metode = collect(['QRIS', 'Transfer Bank', 'GoPay', 'Dana'])->random();

                Pembayaran::create([
                    'order_id'                => 'SPP-' . $tagihan->id_tagihan . '-' . strtoupper(Str::random(8)),
                    'id_tagihan'              => $tagihan->id_tagihan,
                    'jumlah_bayar'            => $kategori2025->nominal_spp,
                    'snap_token'              => null,
                    'midtrans_transaction_id' => 'TXN-' . strtoupper(Str::random(12)),
                    'metode_bayar'            => $metode,
                    'status_pembayaran'       => 'settlement',
                    'waktu_pembayaran'        => now()->setDay(rand(1, 4)),
                    'callback_payload'        => json_encode([
                        'transaction_status' => 'settlement',
                        'payment_type'       => strtolower(str_replace(' ', '_', $metode)),
                        'gross_amount'       => (string) $kategori2025->nominal_spp,
                    ]),
                ]);
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
                'jumlah_bayar'       => $kategori2024->nominal_spp,
                'snap_token'         => 'test-snap-token-' . Str::random(16),
                'status_pembayaran'  => 'pending',
                'waktu_pembayaran'   => null,
            ]);
        }
    }
}
