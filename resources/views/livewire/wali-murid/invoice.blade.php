<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pembayaran #{{ $pembayaran->order_id }}</title>

    {{-- Memakai design system yang sama dengan dashboard (app.css) --}}
    @vite(['resources/css/app.css'])

    <style>
        body {
            font-family: var(--font-body);
            background: var(--surface);
            color: var(--ink);
        }

        .invoice-shell {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 16px;
        }

        .invoice-paper {
            width: 100%;
            max-width: 720px;
            background: var(--surface-card);
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: var(--r-xl);
            box-shadow: 0 20px 60px rgba(2, 44, 34, 0.12);
            padding: 48px;
            position: relative;
            overflow: hidden;
        }

        /* Watermark LUNAS */
        .invoice-watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-28deg);
            font-family: var(--font-display);
            font-weight: 900;
            font-size: 130px;
            color: var(--em-500);
            opacity: 0.055;
            pointer-events: none;
            white-space: nowrap;
        }

        .invoice-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            border-bottom: 2px solid var(--gd-300);
            padding-bottom: 24px;
            margin-bottom: 32px;
            position: relative;
            z-index: 2;
        }

        .invoice-brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .invoice-brand-icon {
            width: 52px;
            height: 52px;
            border-radius: var(--r-md);
            background: linear-gradient(135deg, var(--em-800), var(--em-950));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 8px 20px rgba(6, 95, 70, 0.25);
            flex-shrink: 0;
        }

        .invoice-brand-name {
            font-family: var(--font-display);
            font-weight: 900;
            font-size: 20px;
            color: var(--em-950);
            letter-spacing: -0.3px;
            line-height: 1.2;
        }

        .invoice-brand-address {
            font-size: 11.5px;
            color: var(--ink-muted);
            margin-top: 2px;
        }

        .invoice-meta {
            text-align: right;
        }

        .invoice-meta-title {
            font-family: var(--font-display);
            font-weight: 900;
            font-size: 26px;
            color: var(--em-950);
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }

        .invoice-meta-row {
            font-size: 11.5px;
            color: var(--ink-muted);
            margin-top: 6px;
        }

        .invoice-meta-value {
            font-family: var(--font-mono);
            font-size: 12.5px;
            font-weight: 500;
            color: var(--ink);
        }

        .invoice-section {
            position: relative;
            z-index: 2;
        }

        .invoice-billed {
            background: var(--cream-100);
            border: 1px solid var(--cream-200);
            border-radius: var(--r-lg);
            padding: 20px 22px;
            margin-bottom: 28px;
            display: flex;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .invoice-billed-name {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 17px;
            color: var(--em-950);
        }

        .invoice-billed-detail {
            font-size: 12.5px;
            color: var(--ink-muted);
            margin-top: 4px;
        }

        .invoice-billed-right {
            text-align: right;
            font-size: 12.5px;
            color: var(--ink-muted);
        }

        .invoice-billed-right strong {
            color: var(--ink);
            font-weight: 600;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 28px;
        }

        .invoice-table thead th {
            text-align: left;
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: 1.3px;
            text-transform: uppercase;
            color: var(--ink-muted);
            padding: 0 0 12px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        }

        .invoice-table thead th.align-right {
            text-align: right;
        }

        .invoice-table tbody td {
            padding: 18px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            font-size: 13.5px;
            vertical-align: top;
        }

        .invoice-table tbody td.align-right {
            text-align: right;
            font-family: var(--font-mono);
            font-weight: 500;
            white-space: nowrap;
        }

        .invoice-item-title {
            font-weight: 600;
            color: var(--ink);
            display: block;
        }

        .invoice-item-sub {
            font-size: 11.5px;
            color: var(--ink-muted);
        }

        .invoice-total-wrap {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 40px;
        }

        .invoice-total-box {
            width: 100%;
            max-width: 280px;
            background: var(--em-950);
            border-radius: var(--r-lg);
            padding: 18px 22px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .invoice-total-label {
            font-size: 11px;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            font-weight: 600;
            color: var(--em-300);
        }

        .invoice-total-value {
            font-family: var(--font-mono);
            font-weight: 600;
            font-size: 18px;
        }

        .invoice-footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 24px;
            padding-top: 28px;
            border-top: 1px solid rgba(0, 0, 0, 0.06);
        }

        .invoice-footer-note {
            font-size: 11px;
            color: var(--ink-faint);
            max-width: 280px;
            line-height: 1.6;
        }

        .invoice-signature {
            text-align: center;
            flex-shrink: 0;
            position: relative;
        }

        .invoice-signature-line {
            font-size: 12.5px;
            color: var(--ink-muted);
            margin-bottom: 56px;
        }

        .invoice-signature-name {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 13px;
            color: var(--em-950);
            border-top: 1px solid rgba(0, 0, 0, 0.15);
            padding-top: 8px;
            position: relative;
            z-index: 1;
        }

        /* Stempel, ditumpuk di atas garis tanda tangan */
        .invoice-stamp {
            position: absolute;
            width: 108px;
            height: auto;
            top: -8px;
            left: 50%;
            transform: translateX(-50%) rotate(-6deg);
            opacity: 0.9;
            mix-blend-mode: multiply;
            pointer-events: none;
            z-index: 0;
        }

        .invoice-toolbar {
            position: fixed;
            top: 24px;
            left: 24px;
            display: flex;
            gap: 12px;
            z-index: 10;
        }

        /* ─── PRINT ─── */
        @media print {
            body {
                background: white;
            }

            .no-print {
                display: none !important;
            }

            .invoice-shell {
                padding: 0;
            }

            .invoice-paper {
                box-shadow: none !important;
                border: none !important;
                border-radius: 0 !important;
                padding: 0 !important;
                max-width: 100% !important;
            }

            .invoice-watermark {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        @media (max-width: 640px) {
            .invoice-paper {
                padding: 28px 20px;
            }

            .invoice-header {
                flex-direction: column;
                gap: 20px;
            }

            .invoice-meta {
                text-align: left;
            }

            .invoice-watermark {
                font-size: 80px;
            }
        }
    </style>
</head>

<body onload="window.print()">

    {{-- Toolbar (hanya tampil di layar, tidak ikut tercetak) --}}
    <div class="invoice-toolbar no-print">
        <button onclick="window.close()" class="btn btn--ghost">
            ← Tutup Tab
        </button>
        <button onclick="window.print()" class="btn btn--secondary">
            🖨️ Cetak Invoice
        </button>
    </div>

    <div class="invoice-shell">
        <div class="invoice-paper">

            <div class="invoice-watermark">LUNAS</div>

            {{-- HEADER --}}
            <div class="invoice-header">
                <div class="invoice-brand">
                    <div class="invoice-brand-icon">🕌</div>
                    <div>
                        <div class="invoice-brand-name">Ponpes La-Taksal</div>
                        <div class="invoice-brand-address">Jl. Panongan, Banten, Indonesia</div>
                    </div>
                </div>

                <div class="invoice-meta">
                    <div class="invoice-meta-title">INVOICE</div>
                    <span class="badge badge--lunas">Lunas</span>
                    <div class="invoice-meta-row">
                        Order ID<br>
                        <span class="invoice-meta-value">{{ $pembayaran->order_id }}</span>
                    </div>
                    <div class="invoice-meta-row">
                        Tanggal Terbit<br>
                        <span class="invoice-meta-value">
                            {{ $pembayaran->waktu_pembayaran
                                ? $pembayaran->waktu_pembayaran->format('d F Y, H:i')
                                : $pembayaran->updated_at->format('d F Y, H:i') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- DITERIMA DARI --}}
            <div class="invoice-section">
                <div class="invoice-billed">
                    <div>
                        <div class="label-caps text-gold" style="margin-bottom:8px;">Diterima Dari</div>
                        <div class="invoice-billed-name">{{ $pembayaran->tagihan->siswa->nama_siswa }}</div>
                        <div class="invoice-billed-detail mono">NIS: {{ $pembayaran->tagihan->siswa->nis }}</div>
                    </div>
                    <div class="invoice-billed-right">
                        <div>Kelas: <strong>{{ $pembayaran->tagihan->siswa->kelas }}</strong></div>
                        <div style="margin-top:6px;">Metode:
                            <strong>{{ $pembayaran->metode_bayar ?? 'Online Payment' }}</strong>
                        </div>
                    </div>
                </div>

                {{-- RINCIAN --}}
                <table class="invoice-table">
                    <thead>
                        <tr>
                            <th style="width:70%">Deskripsi</th>
                            <th class="align-right" style="width:30%">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <span class="invoice-item-title">
                                    SPP Bulan {{ $pembayaran->tagihan->bulan }} {{ $pembayaran->tagihan->tahun }}
                                </span>
                                <span class="invoice-item-sub">
                                    Tahun Ajaran {{ $pembayaran->tagihan->kategori_spp->tahun_ajaran }}
                                </span>
                            </td>
                            <td class="align-right">
                                Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                {{-- TOTAL --}}
                <div class="invoice-total-wrap">
                    <div class="invoice-total-box">
                        <span class="invoice-total-label">Total Bayar</span>
                        <span class="invoice-total-value">
                            Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="invoice-footer">
                <p class="invoice-footer-note">
                    Ini adalah bukti pembayaran yang sah dan diterbitkan secara otomatis oleh sistem.
                    Terima kasih atas partisipasi Anda dalam memajukan pendidikan di Ponpes La-Taksal.
                </p>
                <div class="invoice-signature">
                    <div class="invoice-signature-line">Mengetahui,</div>
                    <img src="{{ asset('build/gambar/stempel.png') }}" alt="Stempel" class="invoice-stamp">
                    <div class="invoice-signature-name">Bendahara La-Taksal</div>
                </div>
            </div>

        </div>
    </div>

</body>

</html>
