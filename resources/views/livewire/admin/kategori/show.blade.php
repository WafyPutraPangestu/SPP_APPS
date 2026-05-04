<div class="content">

    <div class="flex items-center gap-4">
        <a href="/admin/kategori" wire:navigate class="btn btn--ghost" style="padding:8px 14px; font-size:13px;">
            ← Kembali
        </a>
        <div>
            <h1 class="page-title">Detail Kategori SPP</h1>
            <p class="text-muted mt-1" style="font-size:13px;">Informasi lengkap dan tagihan terkait</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6" style="align-items:start;">

        {{-- INFO CARD --}}
        <div class="pay-card">
            <div style="position:relative; z-index:2; text-align:center;">
                <div class="brand-icon" style="width:64px; height:64px; font-size:28px; margin:0 auto 16px;">📅</div>
                <div
                    style="font-family:var(--font-display); font-weight:700; font-size:22px; color:white; margin-bottom:4px;">
                    {{ $kategori->tahun_ajaran }}
                </div>
                <div style="font-size:12px; color:var(--em-300); margin-bottom:20px;">Tahun Ajaran</div>

                <div class="stat-card stat-card--outline" style="margin-bottom:20px; text-align:center;">
                    <div class="stat-label">Nominal / Bulan</div>
                    <div class="stat-value" style="font-size:22px;">
                        Rp {{ number_format($kategori->nominal_spp, 0, ',', '.') }}
                    </div>
                </div>

                <div style="border-top:1px solid rgba(255,255,255,0.08); padding-top:16px; text-align:left;">
                    <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                        <span
                            style="font-size:10px; letter-spacing:1px; text-transform:uppercase; color:rgba(255,255,255,0.4);">ID
                            Kategori</span>
                        <span
                            style="font-size:12px; color:white; font-family:var(--font-mono);">{{ $kategori->id_kategori }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                        <span
                            style="font-size:10px; letter-spacing:1px; text-transform:uppercase; color:rgba(255,255,255,0.4);">Dibuat</span>
                        <span
                            style="font-size:12px; color:white; font-family:var(--font-mono);">{{ $kategori->created_at->format('d M Y') }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between;">
                        <span
                            style="font-size:10px; letter-spacing:1px; text-transform:uppercase; color:rgba(255,255,255,0.4);">Total
                            Tagihan</span>
                        <span
                            style="font-size:12px; color:var(--gd-300); font-family:var(--font-mono); font-weight:600;">
                            {{ $kategori->tagihan->count() }} Tagihan
                        </span>
                    </div>
                </div>

                <a href="/admin/kategori/{{ $kategori->id_kategori }}/edit" wire:navigate
                    class="btn btn--primary btn--full" style="margin-top:20px;">
                    Edit Kategori
                </a>
            </div>
        </div>

        {{-- TAGIHAN TERKAIT --}}
        <div style="grid-column: span 2;">
            <div class="table-card">
                <div
                    style="padding:20px 20px 14px; border-bottom:1px solid rgba(0,0,0,0.05); display:flex; align-items:center; justify-content:space-between;">
                    <div>
                        <div class="section-title">Tagihan Terkait</div>
                        <p class="text-muted" style="font-size:12px; margin-top:2px;">
                            Seluruh tagihan yang menggunakan kategori ini
                        </p>
                    </div>
                    @php
                        $lunas = $kategori->tagihan->where('status_tagihan', 'Lunas')->count();
                        $total = $kategori->tagihan->count();
                    @endphp
                    @if ($total > 0)
                        <span class="{{ $lunas === $total ? 'badge badge--lunas' : 'badge badge--pending' }}">
                            {{ $lunas }}/{{ $total }} Lunas
                        </span>
                    @endif
                </div>

                @if ($kategori->tagihan->isEmpty())
                    <div style="padding:48px 20px; text-align:center;">
                        <div style="font-size:32px; margin-bottom:12px;">📭</div>
                        <div
                            style="font-family:var(--font-display); font-weight:700; font-size:15px; color:var(--ink-muted);">
                            Belum ada tagihan
                        </div>
                        <p class="text-muted" style="font-size:12px; margin-top:4px;">
                            Tagihan yang menggunakan kategori ini akan muncul di sini
                        </p>
                    </div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>Santri</th>
                                <th>Bulan / Tahun</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kategori->tagihan as $tagihan)
                                <tr>
                                    <td>
                                        <div class="santri-info">
                                            <div class="santri-avatar santri-avatar--em">
                                                {{ strtoupper(substr($tagihan->siswa->nama_siswa ?? '?', 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="santri-name">{{ $tagihan->siswa->nama_siswa ?? '—' }}</div>
                                                <div class="santri-id">NIS: {{ $tagihan->siswa->nis ?? '—' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-weight:500;">{{ $tagihan->bulan }}</div>
                                        <div class="santri-id">{{ $tagihan->tahun }}</div>
                                    </td>
                                    <td>
                                        @if ($tagihan->status_tagihan === 'Lunas')
                                            <span class="badge badge--lunas">Lunas</span>
                                        @else
                                            <span class="badge badge--pending">Belum Lunas</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

    </div>

</div>
