<div class="content">

    {{-- ══ GREETING ══════════════════════════════════════════ --}}
    <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
        <div>
            <div class="label-caps" style="margin-bottom:4px;">Selamat datang kembali</div>
            <h1 class="page-title">Dashboard Keuangan 🕌</h1>
            <p class="text-muted" style="font-size:13px; margin-top:4px;">
                {{ now()->translatedFormat('l, d F Y') }} · Pondok Pesantren La-Taksal Panongan
            </p>
        </div>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <a href="/admin/tagihan" wire:navigate class="btn btn--secondary">📋 Kelola Tagihan</a>
            <a href="/admin/siswa/create" wire:navigate class="btn btn--primary">+ Santri Baru</a>
        </div>
    </div>

    {{-- ══ STAT CARDS ═════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">

        <div class="stat-card stat-card--dark hover:-translate-y-1 hover:shadow-2xl transition-all duration-300 cursor-pointer"
            onclick="window.location='/admin/siswa'">
            <div class="stat-label">Total Santri</div>
            <div class="stat-value">{{ $totalSiswa }}</div>
            <div class="stat-change" style="color:var(--em-300);">Terdaftar aktif</div>
            <div style="position:absolute; bottom:16px; right:16px; font-size:28px; opacity:0.15;">🎒</div>
        </div>

        <div class="stat-card stat-card--gold hover:-translate-y-1 hover:shadow-xl transition-all duration-300 cursor-pointer"
            onclick="window.location='/admin/tagihan'">
            <div class="stat-label">Belum Lunas</div>
            <div class="stat-value">{{ $tagBelum }}</div>
            <div class="stat-change text-danger">Perlu ditagih</div>
            <div style="position:absolute; bottom:16px; right:16px; font-size:28px; opacity:0.15;">⚠️</div>
        </div>

        <div class="stat-card stat-card--white hover:shadow-xl transition-all duration-300 cursor-pointer"
            onclick="window.location='/admin/tagihan'">
            <div class="stat-label">Sudah Lunas</div>
            <div class="stat-value">{{ $tagLunas }}</div>
            <div class="stat-change text-emerald">↑ Pembayaran masuk</div>
            <div style="position:absolute; bottom:16px; right:16px; font-size:28px; opacity:0.1;">✅</div>
        </div>

        <div class="stat-card stat-card--outline hover:bg-emerald-50 hover:-translate-y-1 transition-all duration-300 cursor-pointer"
            onclick="window.location='/admin/users'">
            <div class="stat-label">Wali Murid</div>
            <div class="stat-value">{{ $totalWali }}</div>
            <div class="stat-change text-muted">Akun terdaftar</div>
            <div style="position:absolute; bottom:16px; right:16px; font-size:28px; opacity:0.1;">👨‍👩‍👧</div>
        </div>

    </div>

    {{-- ══ PROGRESS TERKUMPUL ══════════════════════════════════ --}}
    <div style="background:var(--em-950); border-radius:var(--r-xl); padding:28px; position:relative; overflow:hidden;">

        {{-- glow orbs --}}
        <div
            style="position:absolute; top:-60px; right:-60px; width:200px; height:200px; border-radius:50%; background:radial-gradient(circle, rgba(16,185,129,0.2) 0%, transparent 70%); pointer-events:none;">
        </div>
        <div
            style="position:absolute; bottom:-40px; left:40px; width:160px; height:160px; border-radius:50%; background:radial-gradient(circle, rgba(245,158,11,0.12) 0%, transparent 70%); pointer-events:none;">
        </div>

        <div style="position:relative; z-index:2;">
            <div
                style="display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:16px; margin-bottom:24px;">
                <div>
                    <div class="label-caps" style="color:var(--em-500); margin-bottom:6px;">Realisasi Penerimaan SPP
                    </div>
                    <div
                        style="font-family:var(--font-display); font-weight:900; font-size:32px; color:white; letter-spacing:-1px;">
                        Rp {{ number_format($terkumpul, 0, ',', '.') }}
                    </div>
                    <div style="font-size:12px; color:var(--em-300); margin-top:4px;">
                        dari potensi Rp {{ number_format($potensi, 0, ',', '.') }}
                    </div>
                </div>
                <div style="text-align:right;">
                    <div
                        style="font-family:var(--font-display); font-weight:700; font-size:42px; color:var(--gd-400); letter-spacing:-2px;">
                        {{ $persen }}%
                    </div>
                    <div style="font-size:11px; color:rgba(255,255,255,0.4);">Tingkat realisasi</div>
                </div>
            </div>

            {{-- Progress bar --}}
            <div class="prog-bar" style="height:10px; background:rgba(255,255,255,0.08);">
                <div class="prog-fill prog-fill--gold"
                    style="width:{{ min($persen, 100) }}%; transition:width 1s ease;"></div>
            </div>

            <div style="display:flex; justify-content:space-between; margin-top:10px;">
                <span style="font-size:11px; color:rgba(255,255,255,0.35);">Rp 0</span>
                <span style="font-size:11px; color:rgba(255,255,255,0.35);">Target: Rp
                    {{ number_format($potensi, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    {{-- ══ REKAP BULANAN + TUNGGAKAN ═══════════════════════════ --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- REKAP CHART (2/3) --}}
        <div class="table-card" style="grid-column: span 2; padding:0; overflow:hidden;">
            <div style="padding:20px 24px 16px; border-bottom:1px solid rgba(0,0,0,0.05);">
                <div class="section-title">Rekap Bulanan {{ now()->year }}</div>
                <p class="text-muted" style="font-size:12px; margin-top:2px;">Perbandingan tagihan lunas vs belum lunas
                    per bulan</p>
            </div>
            <div style="padding:20px 24px;">
                @php $maxVal = $rekapBulan->max(fn($r) => $r['lunas'] + $r['belum']) ?: 1; @endphp
                <div style="display:flex; align-items:flex-end; gap:6px; height:140px; margin-bottom:8px;">
                    @foreach ($rekapBulan as $r)
                        @php
                            $total = $r['lunas'] + $r['belum'];
                            $hTotal = $total > 0 ? round(($total / $maxVal) * 120) : 0;
                            $hLunas = $total > 0 ? round(($r['lunas'] / $total) * $hTotal) : 0;
                            $hBelum = $hTotal - $hLunas;
                        @endphp
                        <div style="flex:1; display:flex; flex-direction:column; align-items:center; gap:2px;"
                            title="{{ $r['bulan'] }}: {{ $r['lunas'] }} lunas, {{ $r['belum'] }} belum">
                            @if ($hBelum > 0)
                                <div
                                    style="width:100%; height:{{ $hBelum }}px; background:rgba(217,119,6,0.35); border-radius:3px 3px 0 0;">
                                </div>
                            @endif
                            @if ($hLunas > 0)
                                <div
                                    style="width:100%; height:{{ $hLunas }}px; background:linear-gradient(180deg, var(--em-500), var(--em-700)); border-radius:{{ $hBelum > 0 ? '0' : '3px 3px 0 0' }};">
                                </div>
                            @endif
                            @if ($hTotal === 0)
                                <div
                                    style="width:100%; height:4px; background:rgba(0,0,0,0.06); border-radius:3px; margin-top:auto;">
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div style="display:flex; gap:6px;">
                    @foreach ($rekapBulan as $r)
                        <div
                            style="flex:1; text-align:center; font-size:9px; color:var(--ink-muted); font-weight:600; letter-spacing:0.5px;">
                            {{ strtoupper(substr($r['bulan'], 0, 3)) }}
                        </div>
                    @endforeach
                </div>
                <div style="display:flex; gap:16px; margin-top:16px;">
                    <div style="display:flex; align-items:center; gap:6px;">
                        <div
                            style="width:10px; height:10px; border-radius:2px; background:linear-gradient(180deg, var(--em-500), var(--em-700));">
                        </div>
                        <span style="font-size:11px; color:var(--ink-muted);">Lunas</span>
                    </div>
                    <div style="display:flex; align-items:center; gap:6px;">
                        <div style="width:10px; height:10px; border-radius:2px; background:rgba(217,119,6,0.5);"></div>
                        <span style="font-size:11px; color:var(--ink-muted);">Belum Lunas</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- TOP TUNGGAKAN (1/3) --}}
        <div class="table-card" style="padding:0; overflow:hidden;">
            <div style="padding:20px 20px 14px; border-bottom:1px solid rgba(0,0,0,0.05);">
                <div class="section-title">⚠ Top Tunggakan</div>
                <p class="text-muted" style="font-size:12px; margin-top:2px;">Santri dengan tagihan terbanyak</p>
            </div>
            <div style="padding:12px 0;">
                @forelse ($santriTunggakan as $i => $santri)
                    <div
                        style="display:flex; align-items:center; gap:12px; padding:10px 20px; border-bottom:0.5px solid rgba(0,0,0,0.04);">
                        <div
                            style="font-family:var(--font-mono); font-size:11px; color:var(--ink-faint); width:16px; text-align:center;">
                            {{ $i + 1 }}
                        </div>
                        <div class="santri-avatar santri-avatar--{{ ['em', 'gold', 'blue', 'pink', 'em'][$i % 5] }}">
                            {{ strtoupper(substr($santri->nama_siswa, 0, 2)) }}
                        </div>
                        <div style="flex:1; min-width:0;">
                            <div
                                style="font-size:13px; font-weight:500; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                {{ $santri->nama_siswa }}
                            </div>
                            <div style="font-size:11px; color:var(--ink-muted);">Kelas {{ $santri->kelas }}</div>
                        </div>
                        <span class="badge badge--telat">{{ $santri->belum_lunas_count }}x</span>
                    </div>
                @empty
                    <div style="padding:32px 20px; text-align:center;">
                        <div style="font-size:24px; margin-bottom:8px;">🎉</div>
                        <div style="font-size:13px; color:var(--ink-muted); font-weight:500;">Semua santri lunas!</div>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- ══ TAGIHAN MENUNGGU + PEMBAYARAN TERBARU ═══════════════ --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        {{-- TAGIHAN MENUNGGU --}}
        <div class="table-card" style="overflow:hidden;">
            <div
                style="padding:20px 20px 14px; border-bottom:1px solid rgba(0,0,0,0.05); display:flex; align-items:center; justify-content:space-between;">
                <div>
                    <div class="section-title">Tagihan Menunggu</div>
                    <p class="text-muted" style="font-size:12px; margin-top:2px;">5 tagihan belum lunas terbaru</p>
                </div>
                <a href="/admin/tagihan" wire:navigate
                    style="font-size:11px; color:var(--em-700); font-weight:600; text-decoration:none;">
                    Lihat semua →
                </a>
            </div>
            <table style="width:100%; border-collapse:collapse;">
                <tbody>
                    @forelse ($tagihanMenunggu as $t)
                        <tr style="border-bottom:0.5px solid rgba(0,0,0,0.04);">
                            <td style="padding:12px 20px;">
                                <div class="santri-info">
                                    <div class="santri-avatar santri-avatar--gold">
                                        {{ strtoupper(substr($t->siswa->nama_siswa ?? '?', 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="santri-name">{{ $t->siswa->nama_siswa ?? '—' }}</div>
                                        <div class="santri-id">{{ $t->bulan }} {{ $t->tahun }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:12px 20px; text-align:right;">
                                <span class="amount text-emerald" style="display:block; font-size:12px;">
                                    Rp {{ number_format($t->kategori_spp->nominal_spp ?? 0, 0, ',', '.') }}
                                </span>
                                <span class="badge badge--pending" style="margin-top:4px;">Belum Lunas</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" style="padding:36px; text-align:center;">
                                <div style="font-size:24px; margin-bottom:8px;">🎉</div>
                                <div class="text-muted" style="font-size:13px;">Tidak ada tagihan menunggu</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PEMBAYARAN TERBARU --}}
        <div class="table-card" style="overflow:hidden;">
            <div
                style="padding:20px 20px 14px; border-bottom:1px solid rgba(0,0,0,0.05); display:flex; align-items:center; justify-content:space-between;">
                <div>
                    <div class="section-title">Pembayaran Terbaru</div>
                    <p class="text-muted" style="font-size:12px; margin-top:2px;">5 transaksi masuk terakhir</p>
                </div>
            </div>
            <table style="width:100%; border-collapse:collapse;">
                <tbody>
                    @forelse ($pembayaranTerbaru as $p)
                        @php
                            $statusColor = match ($p->status_pembayaran) {
                                'settlement', 'capture' => 'badge--lunas',
                                'pending' => 'badge--pending',
                                default => 'badge--info',
                            };
                        @endphp
                        <tr style="border-bottom:0.5px solid rgba(0,0,0,0.04);">
                            <td style="padding:12px 20px;">
                                <div class="santri-info">
                                    <div class="santri-avatar santri-avatar--blue">
                                        {{ strtoupper(substr($p->tagihan->siswa->nama_siswa ?? '?', 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="santri-name">{{ $p->tagihan->siswa->nama_siswa ?? '—' }}</div>
                                        <div class="santri-id amount">{{ $p->order_id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:12px 20px; text-align:right;">
                                <span class="amount text-emerald"
                                    style="display:block; font-size:13px; font-weight:600;">
                                    Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}
                                </span>
                                <span class="badge {{ $statusColor }}" style="margin-top:4px;">
                                    {{ ucfirst($p->status_pembayaran) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" style="padding:36px; text-align:center;">
                                <div style="font-size:24px; margin-bottom:8px;">💳</div>
                                <div class="text-muted" style="font-size:13px;">Belum ada transaksi</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    {{-- ══ KATEGORI SPP + QUICK ACTIONS ═══════════════════════ --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- QUICK ACTIONS --}}
        <div style="display:flex; flex-direction:column; gap:12px;">

            <div class="label-caps" style="margin-bottom:2px;">Aksi Cepat</div>

            <a href="/admin/tagihan" wire:navigate class="mini-card"
                style="text-decoration:none; cursor:pointer; transition:box-shadow 0.2s; display:block;"
                onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow=''">
                <div class="mini-card__accent"></div>
                <div style="padding-left:8px; display:flex; align-items:center; gap:12px;">
                    <span style="font-size:22px;">📋</span>
                    <div>
                        <div style="font-weight:600; font-size:13.5px; color:var(--ink);">Kelola Tagihan</div>
                        <div class="text-muted" style="font-size:11px;">Buat, edit, generate massal</div>
                    </div>
                </div>
            </a>

            <a href="/admin/siswa/create" wire:navigate class="mini-card"
                style="text-decoration:none; cursor:pointer; transition:box-shadow 0.2s; display:block;"
                onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow=''">
                <div class="mini-card__accent"
                    style="background:linear-gradient(180deg, var(--gd-400), var(--gd-700));"></div>
                <div style="padding-left:8px; display:flex; align-items:center; gap:12px;">
                    <span style="font-size:22px;">🎒</span>
                    <div>
                        <div style="font-weight:600; font-size:13.5px; color:var(--ink);">Daftar Santri Baru</div>
                        <div class="text-muted" style="font-size:11px;">Tambah data siswa</div>
                    </div>
                </div>
            </a>

            <a href="/admin/users/create" wire:navigate class="mini-card"
                style="text-decoration:none; cursor:pointer; transition:box-shadow 0.2s; display:block;"
                onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow=''">
                <div class="mini-card__accent" style="background:linear-gradient(180deg, #3b82f6, #1e40af);"></div>
                <div style="padding-left:8px; display:flex; align-items:center; gap:12px;">
                    <span style="font-size:22px;">👤</span>
                    <div>
                        <div style="font-weight:600; font-size:13.5px; color:var(--ink);">Buat Akun Wali</div>
                        <div class="text-muted" style="font-size:11px;">Tambah wali murid baru</div>
                    </div>
                </div>
            </a>

            <a href="/admin/kategori/create" wire:navigate class="mini-card"
                style="text-decoration:none; cursor:pointer; transition:box-shadow 0.2s; display:block;"
                onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow=''">
                <div class="mini-card__accent"
                    style="background:linear-gradient(180deg, var(--em-500), var(--em-700));"></div>
                <div style="padding-left:8px; display:flex; align-items:center; gap:12px;">
                    <span style="font-size:22px;">📅</span>
                    <div>
                        <div style="font-weight:600; font-size:13.5px; color:var(--ink);">Tambah Kategori SPP</div>
                        <div class="text-muted" style="font-size:11px;">Tahun ajaran & nominal baru</div>
                    </div>
                </div>
            </a>
        </div>

        {{-- KATEGORI SPP --}}
        <div class="table-card" style="grid-column: span 2; overflow:hidden;">
            <div
                style="padding:20px 20px 14px; border-bottom:1px solid rgba(0,0,0,0.05); display:flex; align-items:center; justify-content:space-between;">
                <div>
                    <div class="section-title">Kategori SPP Aktif</div>
                    <p class="text-muted" style="font-size:12px; margin-top:2px;">Tahun ajaran & nominal terdaftar</p>
                </div>
                <a href="/admin/kategori" wire:navigate
                    style="font-size:11px; color:var(--em-700); font-weight:600; text-decoration:none;">
                    Kelola →
                </a>
            </div>
            <div style="padding:16px 20px; display:flex; flex-direction:column; gap:12px;">
                @forelse ($kategoris as $k)
                    @php
                        $kLunas = $k->tagihan->where('status_tagihan', 'Lunas')->count();
                        $kTotal = $k->tagihan->count();
                        $kPersen = $kTotal > 0 ? round(($kLunas / $kTotal) * 100) : 0;
                    @endphp
                    <div style="display:flex; align-items:center; gap:16px;">
                        <div style="flex:1;">
                            <div
                                style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                                <div>
                                    <span style="font-weight:600; font-size:13px;">{{ $k->tahun_ajaran }}</span>
                                    <span class="amount"
                                        style="font-size:11px; color:var(--ink-muted); margin-left:8px;">
                                        Rp {{ number_format($k->nominal_spp, 0, ',', '.') }}/bln
                                    </span>
                                </div>
                                <span
                                    style="font-size:11px; font-weight:600; color:{{ $kPersen >= 80 ? 'var(--em-700)' : ($kPersen >= 50 ? 'var(--gd-700)' : '#991b1b') }};">
                                    {{ $kPersen }}%
                                </span>
                            </div>
                            <div class="prog-bar">
                                <div class="prog-fill {{ $kPersen >= 80 ? 'prog-fill--em' : ($kPersen >= 50 ? 'prog-fill--gold' : '') }}"
                                    style="width:{{ $kPersen }}%; {{ $kPersen < 50 ? 'background:linear-gradient(90deg, #dc2626, #f87171);' : '' }} transition:width 1s ease;">
                                </div>
                            </div>
                            <div style="font-size:10.5px; color:var(--ink-faint); margin-top:4px;">
                                {{ $kLunas }} lunas dari {{ $kTotal }} tagihan
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align:center; padding:24px;">
                        <div class="text-muted" style="font-size:13px;">Belum ada kategori SPP</div>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
