<div x-data="homeApp()" x-init="init()" style="overflow-x: hidden;">

    {{-- ══════════════════════════════════════════════
         HERO SECTION — Full viewport parallax
    ══════════════════════════════════════════════ --}}
    <section id="hero"
        style="min-height: 100vh; position: relative; display: flex; align-items: center;
               background: var(--em-950); overflow: hidden;">

        {{-- Animated geometric background --}}
        <canvas id="geometricCanvas"
            style="position: absolute; inset: 0; width: 100%; height: 100%; opacity: 0.18; pointer-events: none;"></canvas>

        {{-- Radial glows --}}
        <div
            style="position: absolute; top: -100px; left: -100px; width: 500px; height: 500px;
                    background: radial-gradient(circle, rgba(16,185,129,0.25) 0%, transparent 65%);
                    border-radius: 50%; pointer-events: none; animation: driftA 12s ease-in-out infinite alternate;">
        </div>
        <div
            style="position: absolute; bottom: -80px; right: -80px; width: 600px; height: 600px;
                    background: radial-gradient(circle, rgba(245,158,11,0.15) 0%, transparent 65%);
                    border-radius: 50%; pointer-events: none; animation: driftB 15s ease-in-out infinite alternate;">
        </div>
        <div
            style="position: absolute; top: 40%; left: 60%; width: 300px; height: 300px;
                    background: radial-gradient(circle, rgba(16,185,129,0.12) 0%, transparent 65%);
                    border-radius: 50%; pointer-events: none; animation: driftA 9s ease-in-out infinite alternate;">
        </div>

        {{-- Parallax star dots --}}
        <div id="parallaxLayer" style="position: absolute; inset: 0; pointer-events: none;"></div>

        {{-- Floating particles --}}
        <div id="particles" style="position: absolute; inset: 0; pointer-events: none;"></div>

        {{-- Hero content --}}
        <div
            style="max-width: 1280px; margin: 0 auto; padding: 0 24px; position: relative; z-index: 10;
                    width: 100%;">
            <div style="max-width: 720px;">

                {{-- Label badge --}}
                <div class="hero-badge" style="opacity: 0; animation: fadeUp 0.6s 0.2s ease forwards;">
                    <span
                        style="display: inline-flex; align-items: center; gap: 8px; padding: 6px 16px;
                                 border-radius: 999px; background: rgba(16,185,129,0.12);
                                 border: 1px solid rgba(16,185,129,0.3); font-size: 11.5px;
                                 font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase;
                                 color: var(--em-300);">
                        <span
                            style="width: 6px; height: 6px; background: var(--em-500);
                                     border-radius: 50%; animation: pulse 2s infinite;"></span>
                        Sistem Pembayaran Modern
                    </span>
                </div>

                {{-- Main headline --}}
                <h1
                    style="font-family: var(--font-display); font-weight: 900; font-size: clamp(40px, 7vw, 80px);
                            color: white; line-height: 1.05; letter-spacing: -2px; margin: 20px 0 0;
                            opacity: 0; animation: fadeUp 0.7s 0.35s ease forwards;">
                    Bayar SPP<br>
                    <span
                        style="background: linear-gradient(135deg, var(--gd-300), var(--gd-500), var(--em-500));
                                 -webkit-background-clip: text; -webkit-text-fill-color: transparent;
                                 background-clip: text;">
                        Lebih Mudah
                    </span>
                </h1>

                {{-- Sub --}}
                <p
                    style="font-size: 16px; color: rgba(255,255,255,0.55); line-height: 1.8; margin: 24px 0 0;
                           max-width: 520px; opacity: 0; animation: fadeUp 0.7s 0.5s ease forwards;">
                    Platform pembayaran SPP digital untuk Pondok Pesantren
                    <strong style="color: var(--em-300);">La-Taksal Panongan</strong>.
                    Transparan, real-time, dan terpercaya.
                </p>

                {{-- CTA buttons --}}
                <div
                    style="display: flex; gap: 14px; margin-top: 36px; flex-wrap: wrap;
                            opacity: 0; animation: fadeUp 0.7s 0.65s ease forwards;">
                    @guest
                        <a href="{{ route('login') }}" wire:navigate
                            style="display: inline-flex; align-items: center; gap: 9px; padding: 14px 28px;
                                   background: linear-gradient(135deg, var(--gd-400), var(--gd-500));
                                   color: var(--em-950); font-weight: 700; font-size: 14px;
                                   border-radius: var(--r-md); text-decoration: none;
                                   box-shadow: 0 8px 32px rgba(245,158,11,0.35);
                                   transition: transform 0.2s, box-shadow 0.2s;"
                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 40px rgba(245,158,11,0.45)'"
                            onmouseout="this.style.transform=''; this.style.boxShadow='0 8px 32px rgba(245,158,11,0.35)'">
                            Masuk Sekarang
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    @endguest
                    @auth
                        @if (Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard.index') }}" wire:navigate
                                style="display: inline-flex; align-items: center; gap: 9px; padding: 14px 28px;
                                       background: linear-gradient(135deg, var(--gd-400), var(--gd-500));
                                       color: var(--em-950); font-weight: 700; font-size: 14px;
                                       border-radius: var(--r-md); text-decoration: none;
                                       box-shadow: 0 8px 32px rgba(245,158,11,0.35);
                                       transition: transform 0.2s, box-shadow 0.2s;"
                                onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform=''">
                                Buka Dashboard →
                            </a>
                        @else
                            <a href="{{ route('wali-murid.dashboard.index') }}" wire:navigate
                                style="display: inline-flex; align-items: center; gap: 9px; padding: 14px 28px;
                                       background: linear-gradient(135deg, var(--gd-400), var(--gd-500));
                                       color: var(--em-950); font-weight: 700; font-size: 14px;
                                       border-radius: var(--r-md); text-decoration: none;
                                       box-shadow: 0 8px 32px rgba(245,158,11,0.35);
                                       transition: transform 0.2s, box-shadow 0.2s;"
                                onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform=''">
                                Lihat Tagihan Saya →
                            </a>
                        @endif
                    @endauth

                    <a href="#fitur"
                        style="display: inline-flex; align-items: center; gap: 9px; padding: 14px 28px;
                               background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.75);
                               font-weight: 600; font-size: 14px; border-radius: var(--r-md);
                               text-decoration: none; border: 1px solid rgba(255,255,255,0.12);
                               transition: background 0.2s, color 0.2s;"
                        onmouseover="this.style.background='rgba(255,255,255,0.1)'; this.style.color='white'"
                        onmouseout="this.style.background='rgba(255,255,255,0.06)'; this.style.color='rgba(255,255,255,0.75)'">
                        Pelajari Fitur
                    </a>
                </div>

                {{-- Stats strip --}}
                <div
                    style="display: flex; gap: 32px; margin-top: 52px; padding-top: 32px;
                            border-top: 1px solid rgba(255,255,255,0.08); flex-wrap: wrap;
                            opacity: 0; animation: fadeUp 0.7s 0.8s ease forwards;">
                    @foreach ([['num' => '100%', 'label' => 'Digital & Paperless'], ['num' => 'Real-time', 'label' => 'Update Status'], ['num' => 'Midtrans', 'label' => 'Payment Gateway']] as $stat)
                        <div>
                            <div
                                style="font-family: var(--font-display); font-weight: 700; font-size: 22px;
                                        color: var(--gd-400); letter-spacing: -0.5px;">
                                {{ $stat['num'] }}
                            </div>
                            <div
                                style="font-size: 12px; color: rgba(255,255,255,0.4); margin-top: 2px;
                                        letter-spacing: 0.3px;">
                                {{ $stat['label'] }}
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

        {{-- Scroll indicator --}}
        <div
            style="position: absolute; bottom: 32px; left: 50%; transform: translateX(-50%);
                    display: flex; flex-direction: column; align-items: center; gap: 8px;
                    opacity: 0; animation: fadeIn 1s 1.2s ease forwards;">
            <span
                style="font-size: 10px; letter-spacing: 2px; text-transform: uppercase;
                         color: rgba(255,255,255,0.3);">Scroll</span>
            <div
                style="width: 1px; height: 40px; background: linear-gradient(180deg, rgba(255,255,255,0.3), transparent);
                        animation: scrollLine 2s ease-in-out infinite;">
            </div>
        </div>

    </section>

    {{-- ══════════════════════════════════════════════
         MARQUEE STRIP
    ══════════════════════════════════════════════ --}}
    <div
        style="background: var(--em-900); border-top: 1px solid rgba(16,185,129,0.15);
                border-bottom: 1px solid rgba(16,185,129,0.15); overflow: hidden; padding: 14px 0;">
        <div style="display: flex; animation: marquee 20s linear infinite; white-space: nowrap;">
            @foreach (range(0, 3) as $i)
                <span
                    style="display: inline-flex; align-items: center; gap: 24px; padding: 0 24px;
                             font-size: 12px; font-weight: 600; letter-spacing: 1.5px;
                             text-transform: uppercase; color: var(--em-500);">
                    <span>✦ Pembayaran Online</span>
                    <span style="color: var(--gd-400);">✦ Real-time Monitoring</span>
                    <span>✦ Laporan Otomatis</span>
                    <span style="color: var(--gd-400);">✦ Aman & Terpercaya</span>
                    <span>✦ Midtrans Integrated</span>
                    <span style="color: var(--gd-400);">✦ La-Taksal Panongan</span>
                </span>
            @endforeach
        </div>
    </div>

    {{-- ══════════════════════════════════════════════
         FITUR SECTION
    ══════════════════════════════════════════════ --}}
    <section id="fitur"
        style="padding: 100px 24px; background: var(--surface); position: relative; overflow: hidden;">

        {{-- bg decoration --}}
        <div
            style="position: absolute; top: -200px; right: -200px; width: 600px; height: 600px;
                    background: radial-gradient(circle, rgba(6,95,70,0.06) 0%, transparent 65%);
                    border-radius: 50%; pointer-events: none;">
        </div>

        <div style="max-width: 1280px; margin: 0 auto;">

            {{-- Section header --}}
            <div class="scroll-reveal" style="text-align: center; margin-bottom: 64px;">
                <div
                    style="display: inline-flex; align-items: center; gap: 8px; padding: 5px 16px;
                            border-radius: 999px; background: rgba(6,95,70,0.08);
                            border: 1px solid rgba(6,95,70,0.15); margin-bottom: 16px;">
                    <span
                        style="font-size: 11px; font-weight: 600; letter-spacing: 1.5px;
                                 text-transform: uppercase; color: var(--em-700);">Fitur
                        Unggulan</span>
                </div>
                <h2
                    style="font-family: var(--font-display); font-weight: 900;
                            font-size: clamp(28px, 4vw, 48px); color: var(--ink);
                            letter-spacing: -1.5px; line-height: 1.1; margin: 0;">
                    Semua yang Anda Butuhkan,<br>
                    <span style="color: var(--em-800);">Dalam Satu Platform</span>
                </h2>
                <p
                    style="font-size: 15px; color: var(--ink-muted); margin: 16px auto 0;
                           max-width: 480px; line-height: 1.7;">
                    Dirancang khusus untuk kebutuhan administrasi keuangan pondok pesantren modern.
                </p>
            </div>

            {{-- Feature grid --}}
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">

                @php
                    $features = [
                        [
                            'icon' => '💳',
                            'color' => 'em',
                            'title' => 'Bayar Online',
                            'desc' =>
                                'Wali murid dapat membayar SPP kapan saja dan di mana saja melalui berbagai metode pembayaran yang tersedia di Midtrans.',
                            'tag' => 'Midtrans Gateway',
                        ],
                        [
                            'icon' => '📊',
                            'color' => 'gold',
                            'title' => 'Dashboard Real-time',
                            'desc' =>
                                'Kepala sekolah dan admin dapat memantau status pembayaran secara langsung tanpa harus menunggu laporan manual.',
                            'tag' => 'Live Monitoring',
                        ],
                        [
                            'icon' => '🔔',
                            'color' => 'blue',
                            'title' => 'Notifikasi Otomatis',
                            'desc' =>
                                'Sistem mengirim pengingat tagihan secara otomatis sehingga tidak ada pembayaran yang terlewat.',
                            'tag' => 'Auto Reminder',
                        ],
                        [
                            'icon' => '📋',
                            'color' => 'em',
                            'title' => 'Generate Tagihan Massal',
                            'desc' =>
                                'Admin cukup satu klik untuk membuat tagihan bulanan bagi seluruh santri — hemat waktu, bebas salah tulis.',
                            'tag' => 'Bulk Generate',
                        ],
                        [
                            'icon' => '🧾',
                            'color' => 'gold',
                            'title' => 'Riwayat Lengkap',
                            'desc' =>
                                'Setiap transaksi tercatat otomatis. Wali murid dapat melihat riwayat pembayaran kapan saja.',
                            'tag' => 'Full History',
                        ],
                        [
                            'icon' => '🔒',
                            'color' => 'blue',
                            'title' => 'Aman & Terenkripsi',
                            'desc' =>
                                'Data transaksi diproses melalui gateway bersertifikasi PCI-DSS dengan enkripsi end-to-end.',
                            'tag' => 'Bank-grade Security',
                        ],
                    ];
                @endphp

                @foreach ($features as $i => $f)
                    <div class="scroll-reveal feature-card"
                        style="background: var(--surface-card); border-radius: var(--r-xl);
                               border: 1px solid rgba(0,0,0,0.06); padding: 28px;
                               position: relative; overflow: hidden; cursor: default;
                               transition: transform 0.3s, box-shadow 0.3s;
                               animation-delay: {{ $i * 0.1 }}s;"
                        onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 20px 48px rgba(0,0,0,0.1)'"
                        onmouseout="this.style.transform=''; this.style.boxShadow=''">

                        {{-- glow on hover (top-left accent) --}}
                        <div
                            style="position: absolute; top: 0; left: 0; right: 0; height: 2px;
                                    background: linear-gradient(90deg,
                                        {{ $f['color'] === 'em' ? 'var(--em-700), var(--em-500)' : ($f['color'] === 'gold' ? 'var(--gd-700), var(--gd-400)' : '#1e40af, #60a5fa') }});
                                    opacity: 0.6;">
                        </div>

                        <div
                            style="width: 48px; height: 48px; border-radius: 14px; display: flex;
                                    align-items: center; justify-content: center; font-size: 22px; margin-bottom: 18px;
                                    background: {{ $f['color'] === 'em' ? 'rgba(6,95,70,0.1)' : ($f['color'] === 'gold' ? 'rgba(217,119,6,0.1)' : 'rgba(30,64,175,0.1)') }};">
                            {{ $f['icon'] }}
                        </div>

                        <div
                            style="display: inline-block; padding: 3px 10px; border-radius: 999px;
                                    font-size: 10px; font-weight: 600; letter-spacing: 1px;
                                    text-transform: uppercase; margin-bottom: 12px;
                                    background: {{ $f['color'] === 'em' ? 'rgba(6,95,70,0.08)' : ($f['color'] === 'gold' ? 'rgba(217,119,6,0.08)' : 'rgba(30,64,175,0.08)') }};
                                    color: {{ $f['color'] === 'em' ? 'var(--em-800)' : ($f['color'] === 'gold' ? 'var(--gd-700)' : '#1e40af') }};">
                            {{ $f['tag'] }}
                        </div>

                        <h3
                            style="font-family: var(--font-display); font-weight: 700; font-size: 18px;
                                   color: var(--ink); margin: 0 0 10px; letter-spacing: -0.4px;">
                            {{ $f['title'] }}
                        </h3>
                        <p style="font-size: 13.5px; color: var(--ink-muted); line-height: 1.7; margin: 0;">
                            {{ $f['desc'] }}
                        </p>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════
         HOW IT WORKS
    ══════════════════════════════════════════════ --}}
    <section style="padding: 100px 24px; background: var(--em-950); position: relative; overflow: hidden;">

        <div style="position: absolute; inset: 0; pointer-events: none;">
            <div
                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
                        width: 800px; height: 800px; border-radius: 50%;
                        background: radial-gradient(circle, rgba(16,185,129,0.08) 0%, transparent 60%);">
            </div>
        </div>

        <div style="max-width: 1280px; margin: 0 auto; position: relative; z-index: 2;">

            <div class="scroll-reveal" style="text-align: center; margin-bottom: 64px;">
                <h2
                    style="font-family: var(--font-display); font-weight: 900;
                            font-size: clamp(28px, 4vw, 48px); color: white;
                            letter-spacing: -1.5px; line-height: 1.1; margin: 0 0 16px;">
                    Cara Kerja Sistem
                </h2>
                <p style="font-size: 15px; color: var(--em-300); max-width: 420px; margin: 0 auto; line-height: 1.7;">
                    Proses sederhana dari tagihan hingga konfirmasi pembayaran.
                </p>
            </div>

            <div
                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 0; position: relative;">

                {{-- connector line --}}
                <div style="position: absolute; top: 36px; left: 10%; right: 10%; height: 1px;
                            background: linear-gradient(90deg, transparent, rgba(16,185,129,0.3) 20%,
                            rgba(245,158,11,0.3) 50%, rgba(16,185,129,0.3) 80%, transparent);
                            pointer-events: none;"
                    class="hidden-mobile">
                </div>

                @php
                    $steps = [
                        [
                            'num' => '01',
                            'icon' => '📋',
                            'title' => 'Tagihan Dibuat',
                            'desc' =>
                                'Admin membuat tagihan bulanan untuk seluruh santri secara massal dalam satu klik.',
                        ],
                        [
                            'num' => '02',
                            'icon' => '🔔',
                            'title' => 'Notifikasi Dikirim',
                            'desc' => 'Wali murid menerima informasi tagihan yang harus dibayarkan bulan ini.',
                        ],
                        [
                            'num' => '03',
                            'icon' => '💳',
                            'title' => 'Pembayaran Online',
                            'desc' => 'Wali murid memilih metode bayar dan menyelesaikan transaksi via Midtrans.',
                        ],
                        [
                            'num' => '04',
                            'icon' => '✅',
                            'title' => 'Konfirmasi Otomatis',
                            'desc' => 'Status tagihan berubah Lunas secara otomatis. Riwayat tersimpan selamanya.',
                        ],
                    ];
                @endphp

                @foreach ($steps as $i => $step)
                    <div class="scroll-reveal"
                        style="text-align: center; padding: 0 24px; position: relative;
                                animation-delay: {{ $i * 0.15 }}s;">
                        <div
                            style="width: 72px; height: 72px; border-radius: 50%; margin: 0 auto 20px;
                                    display: flex; align-items: center; justify-content: center;
                                    font-size: 26px; position: relative; z-index: 2;
                                    background: rgba(16,185,129,0.12);
                                    border: 1.5px solid rgba(16,185,129,0.3);
                                    box-shadow: 0 0 0 8px rgba(16,185,129,0.05);">
                            {{ $step['icon'] }}
                            <div
                                style="position: absolute; top: -4px; right: -4px; width: 22px; height: 22px;
                                        border-radius: 50%; background: var(--gd-400);
                                        display: flex; align-items: center; justify-content: center;
                                        font-family: var(--font-mono); font-size: 9px;
                                        font-weight: 700; color: var(--em-950);">
                                {{ $step['num'] }}
                            </div>
                        </div>
                        <h3
                            style="font-family: var(--font-display); font-weight: 700; font-size: 16px;
                                   color: white; margin: 0 0 10px; letter-spacing: -0.3px;">
                            {{ $step['title'] }}
                        </h3>
                        <p style="font-size: 13px; color: rgba(255,255,255,0.45); line-height: 1.7; margin: 0;">
                            {{ $step['desc'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════
         ROLE CARDS
    ══════════════════════════════════════════════ --}}
    <section style="padding: 100px 24px; background: var(--surface);">
        <div style="max-width: 1280px; margin: 0 auto;">

            <div class="scroll-reveal" style="text-align: center; margin-bottom: 56px;">
                <h2
                    style="font-family: var(--font-display); font-weight: 900;
                            font-size: clamp(28px, 4vw, 48px); color: var(--ink);
                            letter-spacing: -1.5px; margin: 0 0 12px;">
                    Untuk Semua Peran
                </h2>
                <p style="font-size: 15px; color: var(--ink-muted); max-width: 400px; margin: 0 auto;">
                    Platform dirancang dengan antarmuka khusus setiap pengguna.
                </p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">

                @php
                    $roles = [
                        [
                            'icon' => '⚙️',
                            'role' => 'Admin / Bendahara',
                            'color' => '#064e3b',
                            'accent' => 'var(--em-500)',
                            'items' => [
                                'Kelola data santri & wali',
                                'Generate tagihan massal',
                                'Tandai lunas manual',
                                'Pantau semua transaksi',
                            ],
                        ],
                        [
                            'icon' => '👨‍👩‍👧',
                            'role' => 'Wali Murid',
                            'color' => '#78350f',
                            'accent' => 'var(--gd-400)',
                            'items' => [
                                'Lihat tagihan aktif',
                                'Bayar online 24/7',
                                'Riwayat pembayaran',
                                'Konfirmasi instan',
                            ],
                        ],
                        [
                            'icon' => '🏫',
                            'role' => 'Kepala Sekolah',
                            'color' => '#1e3a5f',
                            'accent' => '#60a5fa',
                            'items' => [
                                'Dashboard ringkasan',
                                'Laporan keuangan',
                                'Monitor realisasi',
                                'Rekap per periode',
                            ],
                        ],
                    ];
                @endphp

                @foreach ($roles as $i => $role)
                    <div class="scroll-reveal"
                        style="border-radius: var(--r-xl); overflow: hidden;
                               border: 1px solid rgba(0,0,0,0.07);
                               transition: transform 0.3s, box-shadow 0.3s;
                               animation-delay: {{ $i * 0.12 }}s;"
                        onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 24px 56px rgba(0,0,0,0.12)'"
                        onmouseout="this.style.transform=''; this.style.boxShadow=''">

                        {{-- Header --}}
                        <div
                            style="padding: 28px; background: {{ $role['color'] }}; position: relative; overflow: hidden;">
                            <div
                                style="position: absolute; bottom: -30px; right: -30px; width: 120px; height: 120px;
                                        border-radius: 50%; background: rgba(255,255,255,0.05); pointer-events: none;">
                            </div>
                            <div style="font-size: 32px; margin-bottom: 12px;">{{ $role['icon'] }}</div>
                            <div
                                style="font-family: var(--font-display); font-weight: 700; font-size: 20px;
                                        color: white; letter-spacing: -0.4px;">
                                {{ $role['role'] }}
                            </div>
                        </div>

                        {{-- Features list --}}
                        <div style="padding: 24px; background: var(--surface-card);">
                            <ul
                                style="list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 12px;">
                                @foreach ($role['items'] as $item)
                                    <li
                                        style="display: flex; align-items: center; gap: 10px; font-size: 13.5px; color: var(--ink-muted);">
                                        <span
                                            style="width: 18px; height: 18px; border-radius: 50%;
                                                     background: {{ $role['color'] }}20;
                                                     display: flex; align-items: center; justify-content: center;
                                                     flex-shrink: 0; font-size: 10px;">✓</span>
                                        {{ $item }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════
         CTA FINAL
    ══════════════════════════════════════════════ --}}
    <section style="padding: 100px 24px; background: var(--em-950); position: relative; overflow: hidden;">

        <div style="position: absolute; inset: 0; pointer-events: none; overflow: hidden;">
            <div
                style="position: absolute; top: -100px; left: -100px; width: 400px; height: 400px;
                        background: radial-gradient(circle, rgba(16,185,129,0.2) 0%, transparent 65%);
                        border-radius: 50%; animation: driftA 10s ease-in-out infinite alternate;">
            </div>
            <div
                style="position: absolute; bottom: -80px; right: -80px; width: 500px; height: 500px;
                        background: radial-gradient(circle, rgba(245,158,11,0.12) 0%, transparent 65%);
                        border-radius: 50%; animation: driftB 13s ease-in-out infinite alternate;">
            </div>
        </div>

        <div style="max-width: 640px; margin: 0 auto; text-align: center; position: relative; z-index: 2;">
            <div class="scroll-reveal">
                <div style="font-size: 48px; margin-bottom: 20px; animation: float 4s ease-in-out infinite;">🕌</div>
                <h2
                    style="font-family: var(--font-display); font-weight: 900;
                            font-size: clamp(28px, 5vw, 52px); color: white;
                            letter-spacing: -1.5px; line-height: 1.1; margin: 0 0 20px;">
                    Siap Memulai?
                </h2>
                <p style="font-size: 16px; color: rgba(255,255,255,0.5); line-height: 1.8; margin: 0 0 36px;">
                    Bergabunglah dengan sistem administrasi keuangan modern
                    Pondok Pesantren La-Taksal Panongan.
                </p>
                @guest
                    <a href="{{ route('login') }}" wire:navigate
                        style="display: inline-flex; align-items: center; gap: 10px; padding: 16px 36px;
                               background: linear-gradient(135deg, var(--gd-400), var(--gd-500));
                               color: var(--em-950); font-weight: 700; font-size: 15px;
                               border-radius: var(--r-md); text-decoration: none;
                               box-shadow: 0 8px 32px rgba(245,158,11,0.4);
                               transition: transform 0.2s, box-shadow 0.2s;"
                        onmouseover="this.style.transform='translateY(-3px) scale(1.02)'; this.style.boxShadow='0 16px 48px rgba(245,158,11,0.5)'"
                        onmouseout="this.style.transform=''; this.style.boxShadow='0 8px 32px rgba(245,158,11,0.4)'">
                        Masuk ke Sistem
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <path d="M4 9h10M10 5l4 4-4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </a>
                @endguest
                @auth
                    <p style="font-size: 14px; color: var(--em-300);">
                        Anda sudah masuk sebagai <strong>{{ Auth::user()->name }}</strong> 👋
                    </p>
                @endauth
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════
         FOOTER
    ══════════════════════════════════════════════ --}}
    <footer
        style="background: #011a12; border-top: 1px solid rgba(16,185,129,0.1);
                   padding: 32px 24px; text-align: center;">
        <div
            style="font-family: var(--font-display); font-weight: 700; font-size: 16px;
                    color: white; margin-bottom: 6px;">
            La-Taksal SPP</div>
        <div style="font-size: 12px; color: rgba(255,255,255,0.25); letter-spacing: 0.5px;">
            © {{ now()->year }} Pondok Pesantren La-Taksal Panongan · Sistem Pembayaran SPP Digital
        </div>
    </footer>

</div>

{{-- ══════════════════════════════════════════════
     STYLES
══════════════════════════════════════════════ --}}
<style>
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(28px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes driftA {
        from {
            transform: translate(0, 0) scale(1);
        }

        to {
            transform: translate(40px, 30px) scale(1.1);
        }
    }

    @keyframes driftB {
        from {
            transform: translate(0, 0) scale(1);
        }

        to {
            transform: translate(-30px, -40px) scale(1.08);
        }
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: 0.5;
            transform: scale(0.85);
        }
    }

    @keyframes scrollLine {
        0% {
            opacity: 0;
            transform: scaleY(0);
            transform-origin: top;
        }

        50% {
            opacity: 1;
            transform: scaleY(1);
            transform-origin: top;
        }

        100% {
            opacity: 0;
            transform: scaleY(1);
            transform-origin: bottom;
        }
    }

    @keyframes marquee {
        from {
            transform: translateX(0);
        }

        to {
            transform: translateX(-50%);
        }
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    @keyframes particleFade {
        0% {
            opacity: 0;
            transform: translateY(0) scale(0);
        }

        20% {
            opacity: 0.7;
            transform: translateY(-20px) scale(1);
        }

        100% {
            opacity: 0;
            transform: translateY(-80px) scale(0.3);
        }
    }

    .scroll-reveal {
        opacity: 0;
        transform: translateY(32px);
        transition: opacity 0.7s ease, transform 0.7s ease;
    }

    .scroll-reveal.revealed {
        opacity: 1;
        transform: translateY(0);
    }
</style>

{{-- ══════════════════════════════════════════════
     SCRIPTS
══════════════════════════════════════════════ --}}
<script>
    function homeApp() {
        return {
            init() {
                this.initCanvas();
                this.initParallax();
                this.initParticles();
                this.initScrollReveal();
            },

            // ── Geometric canvas ──────────────────
            initCanvas() {
                const canvas = document.getElementById('geometricCanvas');
                if (!canvas) return;
                const ctx = canvas.getContext('2d');

                function resize() {
                    canvas.width = canvas.offsetWidth;
                    canvas.height = canvas.offsetHeight;
                }
                resize();
                window.addEventListener('resize', resize);

                // Islamic geometric: 8-pointed star grid
                function drawStar(ctx, x, y, r, color) {
                    ctx.save();
                    ctx.strokeStyle = color;
                    ctx.lineWidth = 0.6;
                    ctx.beginPath();
                    for (let i = 0; i < 8; i++) {
                        const angle = (i * Math.PI) / 4;
                        const x1 = x + r * Math.cos(angle);
                        const y1 = y + r * Math.sin(angle);
                        const x2 = x + (r * 0.4) * Math.cos(angle + Math.PI / 8);
                        const y2 = y + (r * 0.4) * Math.sin(angle + Math.PI / 8);
                        if (i === 0) {
                            ctx.moveTo(x1, y1);
                            ctx.lineTo(x2, y2);
                        } else {
                            ctx.lineTo(x1, y1);
                            ctx.lineTo(x2, y2);
                        }
                    }
                    ctx.closePath();
                    ctx.stroke();

                    // outer hexagon
                    ctx.beginPath();
                    for (let i = 0; i < 6; i++) {
                        const angle = (i * Math.PI) / 3 - Math.PI / 6;
                        const px = x + r * 1.2 * Math.cos(angle);
                        const py = y + r * 1.2 * Math.sin(angle);
                        if (i === 0) ctx.moveTo(px, py);
                        else ctx.lineTo(px, py);
                    }
                    ctx.closePath();
                    ctx.stroke();
                    ctx.restore();
                }

                let t = 0;

                function draw() {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    const spacing = 120;
                    const cols = Math.ceil(canvas.width / spacing) + 2;
                    const rows = Math.ceil(canvas.height / spacing) + 2;

                    for (let r = 0; r < rows; r++) {
                        for (let c = 0; c < cols; c++) {
                            const x = c * spacing - (spacing / 2);
                            const y = r * spacing - (spacing / 2);
                            const dist = Math.sqrt(
                                Math.pow((x - canvas.width / 2) / canvas.width, 2) +
                                Math.pow((y - canvas.height / 2) / canvas.height, 2)
                            );
                            const alpha = Math.max(0, 0.6 - dist * 1.2 + 0.15 * Math.sin(t * 0.4 + c + r));
                            const isGold = (c + r) % 5 === 0;
                            const color = isGold ?
                                `rgba(245,158,11,${alpha * 0.8})` :
                                `rgba(16,185,129,${alpha})`;
                            drawStar(ctx, x, y, 30 + 6 * Math.sin(t * 0.3 + c * 0.5 + r * 0.3), color);
                        }
                    }
                    t += 0.015;
                    requestAnimationFrame(draw);
                }
                draw();
            },

            // ── Parallax dots ─────────────────────
            initParallax() {
                const layer = document.getElementById('parallaxLayer');
                if (!layer) return;

                const dots = Array.from({
                    length: 60
                }, () => {
                    const el = document.createElement('div');
                    el.style.cssText = `
                        position: absolute;
                        border-radius: 50%;
                        pointer-events: none;
                        left: ${Math.random() * 100}%;
                        top: ${Math.random() * 100}%;
                        width: ${1 + Math.random() * 2.5}px;
                        height: ${1 + Math.random() * 2.5}px;
                        background: ${Math.random() > 0.5 ? 'rgba(110,231,183,0.6)' : 'rgba(252,211,77,0.5)'};
                        opacity: ${0.3 + Math.random() * 0.5};
                    `;
                    el._speed = 0.02 + Math.random() * 0.05;
                    layer.appendChild(el);
                    return el;
                });

                window.addEventListener('mousemove', (e) => {
                    const cx = e.clientX / window.innerWidth - 0.5;
                    const cy = e.clientY / window.innerHeight - 0.5;
                    dots.forEach(d => {
                        d.style.transform =
                            `translate(${cx * 60 * d._speed * 20}px, ${cy * 60 * d._speed * 20}px)`;
                        d.style.transition = 'transform 1.2s cubic-bezier(0.23,1,0.32,1)';
                    });
                });
            },

            // ── Floating particles ────────────────
            initParticles() {
                const container = document.getElementById('particles');
                if (!container) return;

                function spawnParticle() {
                    const el = document.createElement('div');
                    const size = 3 + Math.random() * 5;
                    el.style.cssText = `
                        position: absolute;
                        left: ${10 + Math.random() * 80}%;
                        bottom: ${Math.random() * 30}%;
                        width: ${size}px; height: ${size}px;
                        border-radius: 50%;
                        background: ${Math.random() > 0.5 ? 'rgba(16,185,129,0.6)' : 'rgba(245,158,11,0.5)'};
                        animation: particleFade ${3 + Math.random() * 4}s ease forwards;
                        pointer-events: none;
                    `;
                    container.appendChild(el);
                    el.addEventListener('animationend', () => el.remove());
                }

                setInterval(spawnParticle, 600);
            },

            // ── Scroll reveal ─────────────────────
            initScrollReveal() {
                const obs = new IntersectionObserver((entries) => {
                    entries.forEach((e, i) => {
                        if (e.isIntersecting) {
                            const delay = parseFloat(e.target.style.animationDelay || '0') * 1000;
                            setTimeout(() => e.target.classList.add('revealed'), delay);
                            obs.unobserve(e.target);
                        }
                    });
                }, {
                    threshold: 0.12
                });

                document.querySelectorAll('.scroll-reveal').forEach(el => obs.observe(el));
            }
        }
    }
</script>
