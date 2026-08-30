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
                Reset Password</p>
        </div>

        <!-- Body -->
        <div style="padding: 30px; background-color: #fdf8f0;">
            <p style="color: #0f1923; font-size: 15px;">Assalamualaikum Wr. Wb.</p>
            <p style="color: #0f1923; font-size: 15px; line-height: 1.6;">
                Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.
            </p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $url }}"
                    style="background-color: #f59e0b; color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 8px; font-weight: bold; font-size: 15px; display: inline-block; box-shadow: 0 4px 12px rgba(245,158,11,0.3);">
                    Reset Password
                </a>
            </div>

            <p style="color: #6b7280; font-size: 13px; line-height: 1.6; text-align: center;">
                Link ini akan kadaluarsa dalam <strong>60 menit</strong>.<br>
                Jika Anda tidak merasa meminta reset password, abaikan email ini.
            </p>

            <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 25px 0;">

            <p style="color: #9ca3af; font-size: 11px; line-height: 1.5;">
                Jika tombol di atas tidak berfungsi, salin dan tempel link berikut di browser Anda:<br>
                <span style="color: #6b7280; word-break: break-all;">{{ $url }}</span>
            </p>
        </div>

        <!-- Footer -->
        <div style="background-color: #ffffff; padding: 20px; text-align: center; border-top: 1px solid #e5e7eb;">
            <p style="color: #94a3b8; font-size: 12px; margin: 0;">Terima kasih.</p>
            <p style="color: #94a3b8; font-size: 12px; margin: 4px 0 0 0;">Sistem Pembayaran SPP — Ponpes La-Taksal
            </p>
        </div>

    </div>

</body>

</html>
