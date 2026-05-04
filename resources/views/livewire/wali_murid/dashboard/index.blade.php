<div>
    <header class="topbar">
        <div>
            <div class="label-caps">Selamat Datang</div>
            <h1 class="page-title" style="margin-top: 2px;">
                Assalamu'alaikum, {{ explode(' ', Auth::user()->name)[0] }} 👋
            </h1>
        </div>
        <div class="topbar-right">
            <div style="text-align: right;">
                <div style="font-size: 13px; font-weight: 600; color: var(--ink);">{{ Auth::user()->name }}</div>
                <div class="label-caps" style="color: var(--em-700);">Wali Murid</div>
            </div>
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
        </div>
    </header>

    <main class="content">

        {{-- ══════════════════════════════════════
             TAGIHAN BULAN INI — highlight banner
        ═══════════════════════════════════════ --}}
        @if ($tagihanBulanIni->isNotEmpty())
            @php $allLunas = $tagihanBulanIni->every(fn($t) => $t->status_tagihan === 'Lunas'); @endphp

            <div class="pay-card" style="position: relative;">
                {{-- decorative orb extra --}}
                <div
                    style="position: absolute; top: -20px; left: 50%; transform: translateX(-50%);
                            width: 300px; height: 300px; border-radius: 50%; pointer-events: none;
                            background: radial-gradient(circle, rgba(245,158,11,0.07) 0%, transparent 70%);">
                </div>

                <div
                    style="position: relative; z-index: 2; display: flex; flex-wrap: wrap;
                            align-items: center; justify-content: space-between; gap: 20px;">
                    <div>
                        <div class="label-caps" style="color: var(--em-300); margin-bottom: 6px;">
                            Tagihan Bulan Ini
                        </div>
                        <div
                            style="font-family: var(--font-display); font-weight: 900; font-size: 28px;
                                    color: white; letter-spacing: -0.5px; line-height: 1.1;">
                            {{ $bulanIni }} {{ $tahunIni }}
                        </div>
                        <div style="margin-top: 10px; display: flex; gap: 8px; flex-wrap: wrap;">
                            @foreach ($tagihanBulanIni as $tb)
                                <span class="badge"
                                    style="{{ $tb->status_tagihan === 'Lunas'
                                        ? 'background: rgba(16,185,129,0.2); color: var(--em-300); border: 1px solid rgba(16,185,129,0.3);'
                                        : 'background: rgba(245,158,11,0.2); color: var(--gd-300); border: 1px solid rgba(245,158,11,0.3);' }}">
                                    {{ $tb->status_tagihan }}
                                    · Rp {{ number_format($tb->kategori_spp->nominal_spp, 0, ',', '.') }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    @if (!$allLunas)
                        <a href="{{ route('wali-murid.tagihan.index') }}" class="btn btn--primary"
                            style="font-size: 14px; padding: 13px 28px;
                                  box-shadow: 0 4px 24px rgba(245,158,11,0.35);">
                            💳 Bayar Sekarang
                        </a>
                    @else
                        <div
                            style="display: flex; align-items: center; gap: 10px;
                                    background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3);
                                    border-radius: var(--r-md); padding: 12px 20px;">
                            <span style="font-size: 24px;">✅</span>
                            <div>
                                <div style="color: var(--em-300); font-weight: 600; font-size: 14px;">Lunas</div>
                                <div style="color: rgba(255,255,255,0.5); font-size: 12px;">Bulan ini sudah terbayar
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- ══════════════════════════════════════
             STAT CARDS
        ═══════════════════════════════════════ --}}
        <div class="grid grid-cols-2 xl:grid-cols-4 gap-5">

            <div class="stat-card stat-card--dark hover:-translate-y-1 hover:shadow-2xl transition-all duration-300">
                <div class="stat-label" style="color: var(--em-300);">Total Tagihan</div>
                <div class="stat-value">{{ $stats['total_tagihan'] }}</div>
                <div class="stat-change" style="color: var(--em-300); opacity: 0.75;">Seluruh periode</div>
            </div>

            <div class="stat-card stat-card--gold hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                <div class="stat-label">Belum Lunas</div>
                <div class="stat-value" style="color: var(--gd-900);">{{ $stats['belum_lunas'] }}</div>
                <div class="stat-change" style="color: var(--gd-700);">
                    Rp {{ number_format($stats['tunggakan'], 0, ',', '.') }}
                </div>
            </div>

            <div class="stat-card stat-card--white hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                <div class="stat-label">Sudah Lunas</div>
                <div class="stat-value" style="color: var(--em-800);">{{ $stats['lunas'] }}</div>
                <div class="stat-change text-emerald">Terbayar ✓</div>
            </div>

            <div class="stat-card stat-card--outline hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                <div class="stat-label">Total Dibayar</div>
                <div class="stat-value" style="font-size: 20px;">
                    Rp {{ number_format($stats['total_dibayar'], 0, ',', '.') }}
                </div>
                <div class="stat-change text-muted">Akumulasi</div>
            </div>

        </div>

        {{-- ══════════════════════════════════════
             ROW: SISWA + TAGIHAN BELUM LUNAS
        ═══════════════════════════════════════ --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- KARTU SISWA --}}
            <div>
                <div class="section-title" style="margin-bottom: 14px;">Data Siswa</div>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @forelse ($siswas as $siswa)
                        <div class="mini-card" style="transition: box-shadow 0.2s;">
                            <div class="mini-card__accent"></div>
                            <div
                                style="padding-left: 8px; display: flex; align-items: center;
                                        justify-content: space-between; gap: 12px;">
                                <div class="santri-info">
                                    <div class="santri-avatar santri-avatar--em"
                                        style="width: 44px; height: 44px; font-size: 15px; border-radius: 13px;">
                                        {{ strtoupper(substr($siswa->nama_siswa, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div
                                            style="font-family: var(--font-display); font-weight: 700;
                                                    font-size: 16px; letter-spacing: -0.3px;">
                                            {{ $siswa->nama_siswa }}
                                        </div>
                                        <div style="display: flex; gap: 10px; margin-top: 3px;">
                                            <span class="santri-id">NIS: {{ $siswa->nis }}</span>
                                            <span class="santri-id">·</span>
                                            <span class="santri-id">Kelas {{ $siswa->kelas }}</span>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('wali-murid.tagihan.index') }}"
                                    style="flex-shrink: 0; padding: 6px 14px; border-radius: var(--r-pill);
                                          background: rgba(6,95,70,0.08); color: var(--em-700);
                                          font-size: 12px; font-weight: 600; text-decoration: none;
                                          border: 1px solid rgba(6,95,70,0.15); transition: background 0.15s;"
                                    onmouseover="this.style.background='rgba(6,95,70,0.14)'"
                                    onmouseout="this.style.background='rgba(6,95,70,0.08)'">
                                    Tagihan →
                                </a>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 40px 24px; color: var(--ink-faint); font-size: 13px;">
                            Belum ada data siswa yang terdaftar.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- TAGIHAN BELUM LUNAS --}}
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px;">
                    <div class="section-title">Tagihan Belum Lunas</div>
                    @if ($stats['belum_lunas'] > 0)
                        <a href="{{ route('wali-murid.tagihan.index') }}"
                            style="font-size: 12px; color: var(--em-700); text-decoration: none;
                                  font-weight: 600; display: flex; align-items: center; gap: 4px;">
                            Lihat semua →
                        </a>
                    @endif
                </div>

                @forelse ($tagihanBelumLunas as $t)
                    <div style="display: flex; align-items: center; justify-content: space-between;
                                padding: 14px 18px; background: var(--surface-card);
                                border: 1px solid rgba(0,0,0,0.06); border-radius: var(--r-md);
                                margin-bottom: 10px; transition: box-shadow 0.2s, transform 0.2s;"
                        onmouseover="this.style.boxShadow='0 4px 16px rgba(0,0,0,0.08)'; this.style.transform='translateY(-1px)'"
                        onmouseout="this.style.boxShadow='none'; this.style.transform='none'">

                        <div style="display: flex; align-items: center; gap: 12px;">
                            {{-- Dot indikator --}}
                            <div
                                style="width: 10px; height: 10px; border-radius: 50%;
                                        background: var(--gd-500); flex-shrink: 0;
                                        box-shadow: 0 0 0 3px rgba(245,158,11,0.2);">
                            </div>
                            <div>
                                <div style="font-weight: 600; font-size: 13.5px;">
                                    {{ $t->siswa->nama_siswa }}
                                </div>
                                <div style="font-size: 12px; color: var(--ink-muted); margin-top: 1px;">
                                    {{ $t->bulan }} {{ $t->tahun }}
                                    · {{ $t->kategori_spp->tahun_ajaran }}
                                </div>
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="text-align: right;">
                                <div class="amount" style="font-size: 13.5px; font-weight: 600; color: var(--gd-700);">
                                    Rp {{ number_format($t->kategori_spp->nominal_spp, 0, ',', '.') }}
                                </div>
                            </div>
                            <a href="{{ route('wali-murid.tagihan.show', $t->id_tagihan) }}" class="btn btn--primary"
                                style="padding: 6px 14px; font-size: 12px; white-space: nowrap;
                                      box-shadow: 0 2px 8px rgba(245,158,11,0.25);">
                                Bayar
                            </a>
                        </div>
                    </div>
                @empty
                    <div
                        style="text-align: center; padding: 40px 24px; background: var(--surface-card);
                                border: 1px solid rgba(0,0,0,0.06); border-radius: var(--r-lg);">
                        <div style="font-size: 36px; margin-bottom: 10px;">🎉</div>
                        <div style="font-weight: 600; color: var(--em-800); font-size: 14px;">Semua Lunas!</div>
                        <div style="font-size: 12px; color: var(--ink-faint); margin-top: 4px;">
                            Tidak ada tagihan yang tertunggak saat ini.
                        </div>
                    </div>
                @endforelse
            </div>

        </div>

        {{-- ══════════════════════════════════════
             RIWAYAT PEMBAYARAN TERBARU
        ═══════════════════════════════════════ --}}
        @if ($riwayatTerbaru->isNotEmpty())
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px;">
                    <div class="section-title">Pembayaran Terakhir</div>
                    <a href="{{ route('wali-murid.riwayat.index') }}"
                        style="font-size: 12px; color: var(--em-700); text-decoration: none; font-weight: 600;">
                        Lihat semua →
                    </a>
                </div>

                <div class="table-card">
                    <table>
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>Periode</th>
                                <th>Metode</th>
                                <th>Jumlah</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($riwayatTerbaru as $p)
                                <tr>
                                    <td>
                                        <div class="santri-info">
                                            <div class="santri-avatar santri-avatar--em"
                                                style="width: 30px; height: 30px; font-size: 10px; border-radius: 8px;">
                                                {{ strtoupper(substr($p->tagihan->siswa->nama_siswa, 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="santri-name" style="font-size: 13px;">
                                                    {{ $p->tagihan->siswa->nama_siswa }}
                                                </div>
                                                <div class="santri-id">Kelas {{ $p->tagihan->siswa->kelas }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span style="font-size: 13px; font-weight: 500;">
                                            {{ $p->tagihan->bulan }} {{ $p->tagihan->tahun }}
                                        </span>
                                    </td>
                                    <td>
                                        <span style="font-size: 12.5px; color: var(--ink-muted);">
                                            {{ $p->metode_bayar ?? '—' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="amount"
                                            style="font-size: 13.5px; font-weight: 600; color: var(--em-700);">
                                            Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span style="font-size: 12px; color: var(--ink-muted);">
                                            {{ ($p->waktu_pembayaran ?? $p->created_at)->format('d M Y, H:i') }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- ══════════════════════════════════════
             NOTIF: JIKA TIDAK ADA SISWA
        ═══════════════════════════════════════ --}}
        @if ($siswas->isEmpty())
            <div class="notif-card">
                <div class="notif-icon">ℹ️</div>
                <div>
                    <div class="notif-title">Akun Belum Terhubung</div>
                    <div class="notif-body">
                        Akun Anda belum terhubung ke data siswa. Silakan hubungi admin untuk menghubungkan akun Anda.
                    </div>
                </div>
            </div>
        @endif

    </main>
</div>
