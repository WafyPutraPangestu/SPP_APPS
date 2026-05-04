<div>
    <header class="topbar">
        <div>
            <div class="label-caps">Kepala Sekolah</div>
            <h1 class="page-title" style="margin-top: 2px;">Dashboard Keuangan</h1>
        </div>
        <div class="topbar-right">
            <div style="text-align: right;">
                <div style="font-size: 13px; font-weight: 600; color: var(--ink);">{{ Auth::user()->name }}</div>
                <div class="label-caps" style="color: var(--em-700);">Kepala Sekolah</div>
            </div>
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
        </div>
    </header>

    <main class="content">

        {{-- ══════════════════════════════════════
             HERO BANNER
        ═══════════════════════════════════════ --}}
        <div class="pay-card" style="position: relative; overflow: hidden;">
            <div
                style="position: absolute; top: -40px; right: -40px; width: 250px; height: 250px;
                        border-radius: 50%; pointer-events: none;
                        background: radial-gradient(circle, rgba(245,158,11,0.15) 0%, transparent 70%);">
            </div>
            <div
                style="position: absolute; bottom: -60px; left: 30%; width: 200px; height: 200px;
                        border-radius: 50%; pointer-events: none;
                        background: radial-gradient(circle, rgba(16,185,129,0.12) 0%, transparent 70%);">
            </div>

            <div
                style="position: relative; z-index: 2; display: flex; flex-wrap: wrap;
                        align-items: center; justify-content: space-between; gap: 24px;">
                <div>
                    <div class="label-caps" style="color: var(--em-300); margin-bottom: 8px;">
                        Total Pemasukan SPP
                    </div>
                    <div
                        style="font-family: var(--font-display); font-weight: 900; font-size: 36px;
                                color: white; letter-spacing: -1px; line-height: 1;">
                        Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                    </div>
                    <div style="margin-top: 12px; display: flex; align-items: center; gap: 16px; flex-wrap: wrap;">
                        <div>
                            <div class="label-caps" style="color: rgba(255,255,255,0.4); margin-bottom: 3px;">Bulan ini
                            </div>
                            <div class="amount" style="color: var(--gd-300); font-size: 16px; font-weight: 600;">
                                Rp {{ number_format($pemasukanBulanIni, 0, ',', '.') }}
                            </div>
                        </div>
                        @if (!is_null($growthPersen))
                            <div
                                style="display: flex; align-items: center; gap: 6px; padding: 6px 12px;
                                        border-radius: var(--r-pill);
                                        background: {{ $growthPersen >= 0 ? 'rgba(16,185,129,0.2)' : 'rgba(220,38,38,0.2)' }};
                                        border: 1px solid {{ $growthPersen >= 0 ? 'rgba(16,185,129,0.3)' : 'rgba(220,38,38,0.3)' }};">
                                <span style="font-size: 14px;">{{ $growthPersen >= 0 ? '📈' : '📉' }}</span>
                                <span
                                    style="font-size: 12px; font-weight: 600;
                                             color: {{ $growthPersen >= 0 ? 'var(--em-300)' : '#fca5a5' }};">
                                    {{ $growthPersen >= 0 ? '+' : '' }}{{ $growthPersen }}% vs bulan lalu
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
                <div style="text-align: right;">
                    <div class="label-caps" style="color: rgba(255,255,255,0.4); margin-bottom: 6px;">Tunggakan</div>
                    <div class="amount" style="font-size: 22px; color: #fca5a5; font-weight: 600;">
                        Rp {{ number_format($tunggakan, 0, ',', '.') }}
                    </div>
                    <a href="{{ route('kepala-sekolah.reports.index') }}" class="btn btn--primary"
                        style="margin-top: 12px; padding: 9px 20px; font-size: 12.5px;
                              box-shadow: 0 4px 20px rgba(245,158,11,0.3);">
                        📊 Lihat Laporan
                    </a>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════
             STAT CARDS
        ═══════════════════════════════════════ --}}
        <div class="grid grid-cols-2 xl:grid-cols-4 gap-5">
            <div class="stat-card stat-card--dark hover:-translate-y-1 hover:shadow-2xl transition-all duration-300">
                <div class="stat-label" style="color: var(--em-300);">Total Siswa</div>
                <div class="stat-value">{{ $totalSiswa }}</div>
                <div class="stat-change" style="color: var(--em-300); opacity: 0.75;">Terdaftar aktif</div>
            </div>
            <div class="stat-card stat-card--white hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                <div class="stat-label">Total Tagihan</div>
                <div class="stat-value">{{ $totalTagihan }}</div>
                <div class="stat-change text-muted">Seluruh periode</div>
            </div>
            <div class="stat-card stat-card--white hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                <div class="stat-label">Sudah Lunas</div>
                <div class="stat-value" style="color: var(--em-700);">{{ $totalLunas }}</div>
                <div class="stat-change text-emerald">✓ Pembayaran selesai</div>
            </div>
            <div class="stat-card stat-card--gold hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                <div class="stat-label">Belum Lunas</div>
                <div class="stat-value" style="color: var(--gd-900);">{{ $totalBelum }}</div>
                <div class="stat-change" style="color: var(--gd-700);">Perlu ditindak</div>
            </div>
        </div>

        {{-- ══════════════════════════════════════
             CHART + PER KELAS
        ═══════════════════════════════════════ --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

            {{-- BAR CHART 6 BULAN --}}
            <div class="table-card lg:col-span-3" style="padding: 24px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
                    <div class="section-title">Tren Pemasukan 6 Bulan</div>
                    <span class="label-caps">Rp</span>
                </div>

                @php
                    $maxVal = $chartData->max('nominal') ?: 1;
                @endphp

                <div style="display: flex; align-items: flex-end; gap: 10px; height: 160px;">
                    @foreach ($chartData as $item)
                        @php $height = $maxVal > 0 ? round(($item['nominal'] / $maxVal) * 100) : 0; @endphp
                        <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 6px; height: 100%;"
                            x-data="{ tip: false }" @mouseenter="tip = true" @mouseleave="tip = false"
                            style="position: relative;">

                            {{-- Tooltip --}}
                            <div x-show="tip"
                                style="position: absolute; bottom: 100%; left: 50%; transform: translateX(-50%);
                                        background: var(--em-900); color: white; border-radius: var(--r-sm);
                                        padding: 5px 10px; font-size: 11px; white-space: nowrap; margin-bottom: 6px;
                                        border: 1px solid rgba(16,185,129,0.2); z-index: 10;
                                        box-shadow: 0 4px 12px rgba(0,0,0,0.2); pointer-events: none;">
                                Rp {{ number_format($item['nominal'], 0, ',', '.') }}
                            </div>

                            <div style="flex: 1; width: 100%; display: flex; align-items: flex-end;">
                                <div style="width: 100%; height: {{ $height }}%; min-height: 4px;
                                            background: {{ $item['nominal'] > 0 ? 'linear-gradient(180deg, var(--em-500), var(--em-800))' : 'rgba(0,0,0,0.06)' }};
                                            border-radius: 6px 6px 0 0; transition: opacity 0.2s; cursor: pointer;"
                                    onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                </div>
                            </div>
                            <div style="font-size: 11px; color: var(--ink-muted); font-weight: 500;">
                                {{ $item['label'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- PROGRESS PER KELAS --}}
            <div class="table-card lg:col-span-2" style="padding: 24px;">
                <div class="section-title" style="margin-bottom: 20px;">Ketercapaian per Kelas</div>

                @forelse ($perKelas as $k)
                    <div style="margin-bottom: 18px;">
                        <div
                            style="display: flex; justify-content: space-between; align-items: baseline;
                                    margin-bottom: 6px;">
                            <div style="font-size: 13px; font-weight: 600;">Kelas {{ $k['kelas'] }}</div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="font-size: 11.5px; color: var(--ink-muted);">
                                    {{ $k['lunas'] }}/{{ $k['total'] }}
                                </span>
                                <span
                                    style="font-family: var(--font-mono); font-size: 12px; font-weight: 600;
                                             color: {{ $k['persen'] >= 80 ? 'var(--em-700)' : ($k['persen'] >= 50 ? 'var(--gd-700)' : '#991b1b') }};">
                                    {{ $k['persen'] }}%
                                </span>
                            </div>
                        </div>
                        <div class="prog-bar">
                            <div class="prog-fill {{ $k['persen'] >= 80 ? 'prog-fill--em' : ($k['persen'] >= 50 ? 'prog-fill--gold' : '') }}"
                                style="width: {{ $k['persen'] }}%;
                                        {{ $k['persen'] < 50 ? 'background: linear-gradient(90deg, #dc2626, #ef4444);' : '' }}">
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-top: 4px;">
                            <span style="font-size: 10.5px; color: var(--ink-faint);">{{ $k['siswa'] }} siswa</span>
                            <span style="font-size: 10.5px; color: var(--ink-faint);">{{ $k['total'] - $k['lunas'] }}
                                belum bayar</span>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; color: var(--ink-faint); font-size: 13px; padding: 24px 0;">
                        Belum ada data kelas.
                    </div>
                @endforelse
            </div>

        </div>

        {{-- ══════════════════════════════════════
             TRANSAKSI TERBARU + KATEGORI SPP
        ═══════════════════════════════════════ --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- TRANSAKSI TERBARU --}}
            <div class="lg:col-span-2">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px;">
                    <div class="section-title">Transaksi Terbaru</div>
                    <a href="{{ route('kepala-sekolah.reports.index') }}"
                        style="font-size: 12px; color: var(--em-700); text-decoration: none; font-weight: 600;">
                        Lihat laporan →
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
                            @forelse ($transaksiTerbaru as $p)
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
                                        <span style="font-size: 13px;">
                                            {{ $p->tagihan->bulan }} {{ $p->tagihan->tahun }}
                                        </span>
                                    </td>
                                    <td>
                                        <span style="font-size: 12px; color: var(--ink-muted);">
                                            {{ $p->metode_bayar ?? '—' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="amount"
                                            style="font-size: 13px; font-weight: 600; color: var(--em-700);">
                                            Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span style="font-size: 12px; color: var(--ink-muted);">
                                            {{ ($p->waktu_pembayaran ?? $p->created_at)->format('d M, H:i') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5"
                                        style="text-align: center; padding: 32px; color: var(--ink-faint);">
                                        Belum ada transaksi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- KATEGORI SPP --}}
            <div>
                <div class="section-title" style="margin-bottom: 14px;">Kategori SPP Aktif</div>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    @forelse ($kategoris as $kat)
                        <div class="mini-card">
                            <div class="mini-card__accent"
                                style="background: linear-gradient(180deg, var(--gd-400), var(--em-700));"></div>
                            <div style="padding-left: 10px;">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                    <div>
                                        <div style="font-size: 13px; font-weight: 600; margin-bottom: 2px;">
                                            {{ $kat->tahun_ajaran }}
                                        </div>
                                        <div class="amount"
                                            style="font-size: 15px; font-weight: 600; color: var(--gd-700);">
                                            Rp {{ number_format($kat->nominal_spp, 0, ',', '.') }}
                                        </div>
                                    </div>
                                    <span
                                        style="background: rgba(6,95,70,0.1); color: var(--em-700);
                                                 padding: 3px 9px; border-radius: var(--r-pill);
                                                 font-size: 11px; font-weight: 600;">
                                        {{ $kat->tagihan_count }} tagihan
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; color: var(--ink-faint); font-size: 13px; padding: 24px;">
                            Belum ada kategori.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </main>
</div>
