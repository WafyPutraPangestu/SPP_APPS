<div>
    <header class="topbar">
        <div>
            <div class="label-caps">Kepala Sekolah</div>
            <h1 class="page-title" style="margin-top: 2px;">Laporan Keuangan SPP</h1>
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
             FILTER BAR
        ═══════════════════════════════════════ --}}
        <div class="bg-white rounded-xl"
            style="padding: 18px 22px; border: 1px solid rgba(0,0,0,0.06);
                    display: flex; flex-wrap: wrap; gap: 12px; align-items: center;">

            <div style="display: flex; align-items: center; gap: 8px; flex-shrink: 0;">
                <span style="font-size: 18px;">🗂️</span>
                <span class="section-title" style="font-size: 15px;">Filter Laporan</span>
            </div>

            <div style="width: 1px; height: 28px; background: rgba(0,0,0,0.08);"></div>

            <select wire:model.live="filterBulan"
                style="padding: 8px 12px; border-radius: var(--r-sm); border: 1px solid rgba(0,0,0,0.12);
                       font-family: var(--font-body); font-size: 13px; color: var(--ink);
                       background: var(--surface); cursor: pointer; outline: none; min-width: 130px;">
                <option value="">Semua Bulan</option>
                @foreach ($bulanList as $b)
                    <option value="{{ $b }}">{{ $b }}</option>
                @endforeach
            </select>

            <select wire:model.live="filterTahun"
                style="padding: 8px 12px; border-radius: var(--r-sm); border: 1px solid rgba(0,0,0,0.12);
                       font-family: var(--font-body); font-size: 13px; color: var(--ink);
                       background: var(--surface); cursor: pointer; outline: none; min-width: 110px;">
                <option value="">Semua Tahun</option>
                @foreach (range(date('Y'), date('Y') - 4) as $y)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endforeach
            </select>

            <select wire:model.live="filterKelas"
                style="padding: 8px 12px; border-radius: var(--r-sm); border: 1px solid rgba(0,0,0,0.12);
                       font-family: var(--font-body); font-size: 13px; color: var(--ink);
                       background: var(--surface); cursor: pointer; outline: none; min-width: 120px;">
                <option value="">Semua Kelas</option>
                @foreach ($kelasList as $kelas)
                    <option value="{{ $kelas }}">Kelas {{ $kelas }}</option>
                @endforeach
            </select>

            <select wire:model.live="filterKategori"
                style="padding: 8px 12px; border-radius: var(--r-sm); border: 1px solid rgba(0,0,0,0.12);
                       font-family: var(--font-body); font-size: 13px; color: var(--ink);
                       background: var(--surface); cursor: pointer; outline: none; min-width: 150px;">
                <option value="">Semua Kategori</option>
                @foreach ($kategoris as $kat)
                    <option value="{{ $kat->id_kategori }}">{{ $kat->tahun_ajaran }}</option>
                @endforeach
            </select>

            <select wire:model.live="filterStatus"
                style="padding: 8px 12px; border-radius: var(--r-sm); border: 1px solid rgba(0,0,0,0.12);
                       font-family: var(--font-body); font-size: 13px; color: var(--ink);
                       background: var(--surface); cursor: pointer; outline: none; min-width: 140px;">
                <option value="">Semua Status</option>
                <option value="Lunas">Lunas</option>
                <option value="Belum Lunas">Belum Lunas</option>
            </select>

            @if ($filterBulan || $filterTahun || $filterKelas || $filterKategori || $filterStatus)
                <button
                    wire:click="$set('filterBulan',''); $set('filterTahun',''); $set('filterKelas',''); $set('filterKategori',''); $set('filterStatus','')"
                    class="btn btn--ghost" style="padding: 8px 14px; font-size: 12px;">
                    ✕ Reset Filter
                </button>
            @endif


            <div style="margin-left: auto; display: flex; align-items: center; gap: 10px;">
                <a href="{{ route('kepala-sekolah.reports.export', [
                        'bulan' => $filterBulan,
                        'tahun' => $filterTahun,
                        'kelas' => $filterKelas,
                        'kategori' => $filterKategori,
                        'status' => $filterStatus,
                    ]) }}"
                    style="display: flex; align-items: center; gap: 6px; padding: 8px 16px;
                           background: var(--em-700); color: white; border: none; border-radius: var(--r-sm);
                           font-family: var(--font-body); font-size: 12.5px; font-weight: 600;
                           cursor: pointer; transition: all 0.2s; white-space: nowrap;
                           box-shadow: 0 2px 8px rgba(6,95,70,0.25); text-decoration: none;"
                    onmouseover="this.style.background='var(--em-800)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(6,95,70,0.35)'"
                    onmouseout="this.style.background='var(--em-700)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(6,95,70,0.25)'"
                >
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                        <polyline points="10 9 9 9 8 9"/>
                    </svg>
                    Export Excel
                </a>

                <div wire:loading
                    style="display: none; align-items: center; gap: 6px;
                                         font-size: 12px; color: var(--em-700);">
                    <div
                        style="width: 14px; height: 14px; border: 2px solid var(--em-300);
                                border-top-color: var(--em-700); border-radius: 50%;
                                animation: spin 0.6s linear infinite;">
                    </div>
                    Memuat...
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════
             RINGKASAN STATS
        ═══════════════════════════════════════ --}}
        <div class="grid grid-cols-2 xl:grid-cols-4 gap-5">

            <div class="stat-card stat-card--dark hover:-translate-y-1 hover:shadow-2xl transition-all duration-300">
                <div class="stat-label" style="color: var(--em-300);">Total Pemasukan</div>
                <div class="stat-value" style="font-size: 22px;">
                    Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                </div>
                <div class="stat-change" style="color: var(--em-300); opacity: 0.8;">Sudah diterima</div>
            </div>

            <div class="stat-card stat-card--gold hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                <div class="stat-label">Tunggakan</div>
                <div class="stat-value" style="color: var(--gd-900); font-size: 22px;">
                    Rp {{ number_format($totalTunggakan, 0, ',', '.') }}
                </div>
                <div class="stat-change" style="color: var(--gd-700);">Belum dibayar</div>
            </div>

            <div class="stat-card stat-card--white hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                <div class="stat-label">Tagihan Lunas</div>
                <div class="stat-value" style="color: var(--em-700);">{{ $totalLunas }}</div>
                <div class="stat-change">
                    <span style="font-family: var(--font-mono); font-weight: 600; color: var(--em-700);">
                        {{ $persen }}%
                    </span>
                    dari total
                </div>
            </div>

            <div class="stat-card stat-card--outline hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                <div class="stat-label">Belum Lunas</div>
                <div class="stat-value">{{ $totalBelum }}</div>
                <div class="stat-change text-muted">Perlu tindak lanjut</div>
            </div>

        </div>

        {{-- ══════════════════════════════════════
             REKAP PER KELAS
        ═══════════════════════════════════════ --}}
        <div>
            <div class="section-title" style="margin-bottom: 14px;">Rekap per Kelas</div>
            @if ($rekapKelas->isEmpty())
                <div
                    style="text-align: center; padding: 32px; background: var(--surface-card);
                            border-radius: var(--r-lg); border: 1px solid rgba(0,0,0,0.06);
                            color: var(--ink-faint); font-size: 13px;">
                    Tidak ada data untuk filter yang dipilih.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach ($rekapKelas as $k)
                        <div class="mini-card hover:shadow-md transition-shadow duration-200">
                            <div class="mini-card__accent"
                                style="{{ $k['persen'] >= 80
                                    ? 'background: linear-gradient(180deg, var(--em-500), var(--em-700));'
                                    : ($k['persen'] >= 50
                                        ? 'background: linear-gradient(180deg, var(--gd-400), var(--gd-700));'
                                        : 'background: linear-gradient(180deg, #ef4444, #991b1b);') }}">
                            </div>
                            <div style="padding-left: 10px;">
                                <div
                                    style="display: flex; justify-content: space-between;
                                            align-items: center; margin-bottom: 12px;">
                                    <div>
                                        <div
                                            style="font-family: var(--font-display); font-weight: 700;
                                                    font-size: 17px; letter-spacing: -0.3px;">
                                            Kelas {{ $k['kelas'] }}
                                        </div>
                                        <div style="font-size: 11.5px; color: var(--ink-muted); margin-top: 2px;">
                                            {{ $k['siswa'] }} siswa terdaftar
                                        </div>
                                    </div>
                                    <div style="text-align: right;">
                                        <div
                                            style="font-family: var(--font-mono); font-size: 22px; font-weight: 700;
                                                    line-height: 1;
                                                    color: {{ $k['persen'] >= 80 ? 'var(--em-700)' : ($k['persen'] >= 50 ? 'var(--gd-700)' : '#dc2626') }};">
                                            {{ $k['persen'] }}%
                                        </div>
                                        <div style="font-size: 10px; color: var(--ink-faint); margin-top: 2px;">
                                            ketercapaian
                                        </div>
                                    </div>
                                </div>

                                <div class="prog-bar" style="margin-bottom: 12px;">
                                    <div class="prog-fill"
                                        style="width: {{ $k['persen'] }}%;
                                                {{ $k['persen'] >= 80
                                                    ? 'background: linear-gradient(90deg, var(--em-700), var(--em-500));'
                                                    : ($k['persen'] >= 50
                                                        ? 'background: linear-gradient(90deg, var(--gd-700), var(--gd-400));'
                                                        : 'background: linear-gradient(90deg, #991b1b, #ef4444);') }}">
                                    </div>
                                </div>

                                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px;">
                                    <div
                                        style="background: rgba(6,95,70,0.07); border-radius: var(--r-sm);
                                                padding: 8px; text-align: center;">
                                        <div style="font-size: 15px; font-weight: 700; color: var(--em-700);">
                                            {{ $k['lunas'] }}
                                        </div>
                                        <div style="font-size: 10px; color: var(--ink-faint); margin-top: 2px;">Lunas
                                        </div>
                                    </div>
                                    <div
                                        style="background: rgba(217,119,6,0.07); border-radius: var(--r-sm);
                                                padding: 8px; text-align: center;">
                                        <div style="font-size: 15px; font-weight: 700; color: var(--gd-700);">
                                            {{ $k['belum_lunas'] }}
                                        </div>
                                        <div style="font-size: 10px; color: var(--ink-faint); margin-top: 2px;">Belum
                                        </div>
                                    </div>
                                    <div
                                        style="background: rgba(0,0,0,0.04); border-radius: var(--r-sm);
                                                padding: 8px; text-align: center;">
                                        <div class="amount"
                                            style="font-size: 11px; font-weight: 600; color: var(--ink-muted);">
                                            {{ number_format($k['nominal'] / 1000000, 1) }}jt
                                        </div>
                                        <div style="font-size: 10px; color: var(--ink-faint); margin-top: 2px;">Masuk
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- ══════════════════════════════════════
             TABEL DETAIL TAGIHAN
        ═══════════════════════════════════════ --}}
        <div>
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px;">
                <div class="section-title">Detail Tagihan</div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 12px; color: var(--ink-muted);">
                        {{ $tagihans->total() }} data ditemukan
                    </span>
                </div>
            </div>

            @if ($tagihans->isEmpty())
                <div
                    style="text-align: center; padding: 48px 24px; background: var(--surface-card);
                            border-radius: var(--r-xl); border: 1px solid rgba(0,0,0,0.06);">
                    <div style="font-size: 40px; margin-bottom: 12px;">📭</div>
                    <div class="section-title" style="color: var(--ink-muted);">Tidak Ada Data</div>
                    <p style="font-size: 13px; color: var(--ink-faint); margin-top: 6px;">
                        Ubah filter untuk melihat data lainnya.
                    </p>
                </div>
            @else
                <div class="table-card">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Siswa</th>
                                <th>Kelas</th>
                                <th>Periode</th>
                                <th>Kategori</th>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th>Dibayar Via</th>
                                <th>Waktu Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tagihans as $i => $t)
                                @php
                                    $p = $t->pembayaran->where('status_pembayaran', 'settlement')->first();
                                @endphp
                                <tr>
                                    <td style="color: var(--ink-faint); font-size: 12px;">
                                        {{ $tagihans->firstItem() + $i }}
                                    </td>
                                    <td>
                                        <div class="santri-info">
                                            <div class="santri-avatar santri-avatar--em"
                                                style="width: 28px; height: 28px; font-size: 9px; border-radius: 7px;">
                                                {{ strtoupper(substr($t->siswa->nama_siswa, 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="santri-name" style="font-size: 13px;">
                                                    {{ $t->siswa->nama_siswa }}
                                                </div>
                                                <div class="santri-id">{{ $t->siswa->nis }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span style="font-size: 13px; font-weight: 500;">{{ $t->siswa->kelas }}</span>
                                    </td>
                                    <td>
                                        <span style="font-size: 13px; font-weight: 500;">
                                            {{ $t->bulan }} {{ $t->tahun }}
                                        </span>
                                    </td>
                                    <td>
                                        <span style="font-size: 12px; color: var(--ink-muted);">
                                            {{ $t->kategori_spp->tahun_ajaran }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="amount" style="font-size: 13px; font-weight: 600;">
                                            Rp {{ number_format($t->kategori_spp->nominal_spp, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $t->status_tagihan === 'Lunas' ? 'badge--lunas' : 'badge--pending' }}">
                                            {{ $t->status_tagihan }}
                                        </span>
                                    </td>
                                    <td>
                                        <span style="font-size: 12px; color: var(--ink-muted);">
                                            {{ $p?->metode_bayar ?? '—' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span style="font-size: 12px; color: var(--ink-muted);">
                                            {{ $p?->waktu_pembayaran?->format('d M Y') ?? '—' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="display: flex; justify-content: center; margin-top: 8px;">
                    {{ $tagihans->links() }}
                </div>
            @endif
        </div>

    </main>
</div>

<style>
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>
