<div>
    <header class="topbar">
        <div>
            <div class="label-caps">Portal Wali Murid</div>
            <h1 class="page-title" style="margin-top: 2px;">Riwayat Pembayaran</h1>
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

        {{-- ── STAT CARDS ──────────────────────────── --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <div class="stat-card stat-card--dark hover:-translate-y-1 hover:shadow-2xl transition-all duration-300">
                <div class="stat-label" style="color: var(--em-300);">Total Transaksi</div>
                <div class="stat-value">{{ $stats['total_transaksi'] }}</div>
                <div class="stat-change" style="color: var(--em-300); opacity: 0.8;">Seluruh periode</div>
            </div>

            <div class="stat-card stat-card--white hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                <div class="stat-label">Total Dibayarkan</div>
                <div class="stat-value" style="color: var(--em-800); font-size: 22px;">
                    Rp {{ number_format($stats['total_berhasil'], 0, ',', '.') }}
                </div>
                <div class="stat-change text-emerald">Pembayaran berhasil ✓</div>
            </div>

            <div class="stat-card stat-card--gold hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                <div class="stat-label">Transaksi Pending</div>
                <div class="stat-value" style="color: var(--gd-900);">{{ $stats['total_pending'] }}</div>
                <div class="stat-change" style="color: var(--gd-700);">Menunggu konfirmasi</div>
            </div>

        </div>

        {{-- ── FILTER & SEARCH ─────────────────────── --}}
        <div class="bg-white rounded-xl"
            style="padding: 16px 20px; border: 1px solid rgba(0,0,0,0.06); display: flex; flex-wrap: wrap; gap: 12px; align-items: center;">

            {{-- Search --}}
            <div style="position: relative; flex: 1; min-width: 200px;">
                <span
                    style="position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
                             color: var(--ink-faint); font-size: 14px; pointer-events: none;">🔍</span>
                <input wire:model.live.debounce.300ms="search" type="text"
                    placeholder="Cari order ID atau nama siswa..."
                    style="width: 100%; padding: 7px 12px 7px 32px; border-radius: var(--r-sm);
                              border: 1px solid rgba(0,0,0,0.12); font-family: var(--font-body);
                              font-size: 13px; color: var(--ink); background: var(--surface); outline: none;">
            </div>

            <span class="label-caps" style="flex-shrink: 0;">Filter :</span>

            <select wire:model.live="filterStatus"
                style="padding: 7px 12px; border-radius: var(--r-sm); border: 1px solid rgba(0,0,0,0.12);
                       font-family: var(--font-body); font-size: 13px; color: var(--ink);
                       background: var(--surface); cursor: pointer; outline: none;">
                <option value="">Semua Status</option>
                <option value="settlement">Berhasil</option>
                <option value="pending">Pending</option>
                <option value="expire">Kadaluarsa</option>
                <option value="cancel">Dibatalkan</option>
            </select>

            <select wire:model.live="filterBulan"
                style="padding: 7px 12px; border-radius: var(--r-sm); border: 1px solid rgba(0,0,0,0.12);
                       font-family: var(--font-body); font-size: 13px; color: var(--ink);
                       background: var(--surface); cursor: pointer; outline: none;">
                <option value="">Semua Bulan</option>
                @foreach ($bulanList as $b)
                    <option value="{{ $b }}">{{ $b }}</option>
                @endforeach
            </select>

            <select wire:model.live="filterTahun"
                style="padding: 7px 12px; border-radius: var(--r-sm); border: 1px solid rgba(0,0,0,0.12);
                       font-family: var(--font-body); font-size: 13px; color: var(--ink);
                       background: var(--surface); cursor: pointer; outline: none;">
                <option value="">Semua Tahun</option>
                @foreach (range(date('Y'), date('Y') - 4) as $y)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endforeach
            </select>

            @if ($filterStatus || $filterBulan || $filterTahun || $search)
                <button
                    wire:click="$set('filterStatus',''); $set('filterBulan',''); $set('filterTahun',''); $set('search','')"
                    class="btn btn--ghost" style="padding: 7px 14px; font-size: 12px;">
                    ✕ Reset
                </button>
            @endif

        </div>

        {{-- ── TABEL RIWAYAT ───────────────────────── --}}
        @if ($pembayarans->isEmpty())
            <div style="text-align: center; padding: 64px 24px;">
                <div style="font-size: 48px; margin-bottom: 16px;">🧾</div>
                <div class="section-title" style="color: var(--ink-muted);">Belum Ada Riwayat</div>
                <p style="color: var(--ink-faint); font-size: 13px; margin-top: 8px;">
                    Transaksi pembayaran akan muncul di sini setelah Anda melakukan pembayaran.
                </p>
                <a href="{{ route('wali-murid.tagihan.index') }}" class="btn btn--primary"
                    style="margin-top: 20px; display: inline-flex;">
                    Lihat Tagihan
                </a>
            </div>
        @else
            <div class="table-card">
                <table>
                    <thead>
                        <tr>
                            <th>Transaksi</th>
                            <th>Siswa</th>
                            <th>Periode</th>
                            <th>Metode</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembayarans as $p)
                            @php
                                $statusMap = [
                                    'settlement' => ['badge--lunas', 'Berhasil'],
                                    'pending' => ['badge--pending', 'Pending'],
                                    'expire' => ['badge--telat', 'Kadaluarsa'],
                                    'cancel' => ['badge--telat', 'Dibatalkan'],
                                    'deny' => ['badge--telat', 'Ditolak'],
                                ];
                                [$badgeClass, $label] = $statusMap[$p->status_pembayaran] ?? [
                                    'badge--info',
                                    ucfirst($p->status_pembayaran),
                                ];
                            @endphp
                            <tr>
                                {{-- ORDER ID --}}
                                <td>
                                    <span class="amount" style="font-size: 11.5px; color: var(--ink-muted);">
                                        {{ $p->order_id }}
                                    </span>
                                </td>

                                {{-- SISWA --}}
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

                                {{-- PERIODE --}}
                                <td>
                                    <div style="font-size: 13px; font-weight: 500;">
                                        {{ $p->tagihan->bulan }} {{ $p->tagihan->tahun }}
                                    </div>
                                    <div style="font-size: 11px; color: var(--ink-faint);">
                                        {{ $p->tagihan->kategori_spp->tahun_ajaran }}
                                    </div>
                                </td>

                                {{-- METODE --}}
                                <td>
                                    <span style="font-size: 12.5px; color: var(--ink-muted);">
                                        {{ $p->metode_bayar ?? '—' }}
                                    </span>
                                </td>

                                {{-- JUMLAH --}}
                                <td>
                                    <span class="amount"
                                        style="font-size: 13.5px; font-weight: 600;
                                                 color: {{ $p->status_pembayaran === 'settlement' ? 'var(--em-700)' : 'var(--ink)' }};">
                                        Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}
                                    </span>
                                </td>

                                {{-- STATUS --}}
                                <td>
                                    <span class="badge {{ $badgeClass }}">{{ $label }}</span>
                                </td>

                                {{-- WAKTU --}}
                                <td>
                                    <span style="font-size: 12px; color: var(--ink-muted);">
                                        {{ ($p->waktu_pembayaran ?? $p->created_at)->format('d M Y') }}
                                    </span>
                                    <div style="font-size: 11px; color: var(--ink-faint);">
                                        {{ ($p->waktu_pembayaran ?? $p->created_at)->format('H:i') }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div style="display: flex; justify-content: center;">
                {{ $pembayarans->links() }}
            </div>
        @endif

    </main>
</div>
