<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body style="font-family: Arial, sans-serif; background-color: #f8faf7; margin: 0; padding: 20px;">

    <div
        style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; border: 1px solid #e5e7eb; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">

        <!-- Header -->
        <div
            style="background-color: #022c22; padding: 25px 20px; text-align: center; border-bottom: 4px solid #f59e0b;">
            <h1 style="color: #ffffff; margin: 0; font-size: 22px;">Ponpes La-Taksal</h1>
            <p
                style="color: #6ee7b7; margin: 5px 0 0 0; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">
                Pemberitahuan Pembayaran</p>
        </div>

        <!-- Body -->
        <div style="padding: 30px; background-color: #fdf8f0;">
            <p style="color: #0f1923; font-size: 15px;">Assalamualaikum Wr. Wb.</p>
            <p style="color: #0f1923; font-size: 15px; line-height: 1.6;">
                Bapak/Ibu Wali Murid dari santri <strong>{{ $tagihan->siswa->nama_siswa }}</strong> (Kelas
                {{ $tagihan->siswa->kelas }}),
            </p>
            <p style="color: #0f1923; font-size: 15px; line-height: 1.6;">
                Melalui email ini, kami mengingatkan bahwa tagihan SPP untuk bulan <strong>{{ $tagihan->bulan }}
                    {{ $tagihan->tahun }}</strong> belum dilunasi.
            </p>

            <div
                style="background-color: #ffffff; border: 1px dashed #d97706; padding: 15px; text-align: center; border-radius: 8px; margin: 25px 0;">
                <p style="margin: 0; font-size: 13px; color: #78350f; text-transform: uppercase;">Total Tagihan</p>
                <h2 style="margin: 5px 0 0 0; color: #b45309; font-size: 24px;">Rp
                    {{ number_format($tagihan->kategori_spp->nominal_spp, 0, ',', '.') }}</h2>
            </div>

            <p style="color: #0f1923; font-size: 15px; text-align: center; margin-bottom: 25px;">
                Mohon segera melakukan pembayaran melalui aplikasi PWA Wali Murid.
            </p>

            <div style="text-align: center;">
                <a href="{{ url('/') }}"
                    style="background-color: #10b981; color: #ffffff; text-decoration: none; padding: 12px 25px; border-radius: 6px; font-weight: bold; font-size: 15px; display: inline-block;">Masuk
                    ke Aplikasi</a>
            </div>
        </div>

        <!-- Footer -->
        <div style="background-color: #ffffff; padding: 20px; text-align: center; border-top: 1px solid #e5e7eb;">
            <p style="color: #94a3b8; font-size: 12px; margin: 0;">Terima kasih atas partisipasi Anda.</p>
            <p style="color: #94a3b8; font-size: 12px; margin: 4px 0 0 0;">Bendahara Pondok Pesantren La-Taksal</p>
        </div>

    </div>

</body>

</html>
