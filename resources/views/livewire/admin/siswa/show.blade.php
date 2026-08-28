<div class="content">

    <div class="flex items-center gap-4">
        <a href="/admin/siswa" wire:navigate class="btn btn--ghost" style="padding:8px 14px; font-size:13px;">
            ← Kembali
        </a>
        <div>
            <h1 class="page-title">Detail Santri</h1>
            <p class="text-muted mt-1" style="font-size:13px;">Informasi lengkap dan riwayat tagihan</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6" style="align-items:start;">

        {{-- PROFILE CARD --}}
        <div class="pay-card">
            <div style="position:relative; z-index:2; text-align:center;">
                <div class="avatar"
                    style="width:72px; height:72px; font-size:26px; font-weight:700; margin:0 auto 16px;">
                    {{ strtoupper(substr($siswa->nama_siswa, 0, 2)) }}
                </div>
                <div
                    style="font-family:var(--font-display); font-weight:700; font-size:20px; color:white; margin-bottom:4px;">
                    {{ $siswa->nama_siswa }}
                </div>
                <div style="font-size:12px; color:var(--em-300); font-family:var(--font-mono); margin-bottom:16px;">
                    NIS: {{ $siswa->nis }}
                </div>
                <span class="chip chip--active" style="margin-bottom:20px; display:inline-block;">
                    Kelas {{ $siswa->kelas }}
                </span>

                <div style="border-top:1px solid rgba(255,255,255,0.08); padding-top:16px; text-align:left;">

                    <div style="margin-bottom:12px;">
                        <div
                            style="font-size:10px; letter-spacing:1.2px; text-transform:uppercase; color:rgba(255,255,255,0.4); margin-bottom:4px;">
                            Wali Murid
                        </div>
                        @if ($siswa->user)
                            <div style="font-size:13px; color:white; font-weight:500;">{{ $siswa->user->name }}</div>
                            <div style="font-size:11px; color:var(--em-300);">{{ $siswa->user->email }}</div>
                        @else
                            <span class="badge badge--telat">Tidak ada</span>
                        @endif
                    </div>

                    <div>
                        <div
                            style="font-size:10px; letter-spacing:1.2px; text-transform:uppercase; color:rgba(255,255,255,0.4); margin-bottom:4px;">
                            Terdaftar
                        </div>
                        <div style="font-size:12px; color:white; font-family:var(--font-mono);">
                            {{ $siswa->created_at->format('d M Y') }}
                        </div>
                    </div>
                </div>

                <a href="/admin/siswa/{{ $siswa->id_siswa }}/edit" wire:navigate class="btn btn--primary btn--full"
                    style="margin-top:20px;">
                    Edit Data
                </a>
            </div>
        </div>

        {{-- TAGIHAN LIST --}}
        <div style="grid-column: span 2;">
            <div class="table-card">
                <div
                    style="padding:20px 20px 14px; border-bottom:1px solid rgba(0,0,0,0.05); display:flex; align-items:center; justify-content:space-between;">
                    <div>
                        <div class="section-title">Riwayat Tagihan</div>
                        <p class="text-muted" style="font-size:12px; margin-top:2px;">Seluruh tagihan SPP santri ini</p>
                    </div>
                    <div style="display:flex; align-items:center; gap:10px;">
                        @php
                            $tagihanLunas = $siswa->tagihan->where('status_tagihan', 'Lunas')->count();
                            $tagihanTotal = $siswa->tagihan->count();
                        @endphp
                        @if ($tagihanTotal > 0)
                            <span
                                class="{{ $tagihanLunas === $tagihanTotal ? 'badge badge--lunas' : 'badge badge--pending' }}">
                                {{ $tagihanLunas }}/{{ $tagihanTotal }} Lunas
                            </span>
                        @endif
                        <a href="{{ route('admin.siswa.export-tagihan', $siswa->id_siswa) }}"
                            class="btn btn--primary"
                            style="font-size:12px; padding:6px 14px; display:inline-flex; align-items:center; gap:6px; text-decoration:none;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3" />
                            </svg>
                            Export Excel
                        </a>
                    </div>
                </div>

                @if ($siswa->tagihan->isEmpty())
                    <div style="padding:48px 20px; text-align:center;">
                        <div style="font-size:32px; margin-bottom:12px;">📋</div>
                        <div
                            style="font-family:var(--font-display); font-weight:700; font-size:15px; color:var(--ink-muted);">
                            Belum ada tagihan
                        </div>
                        <p class="text-muted" style="font-size:12px; margin-top:4px;">Tagihan SPP akan muncul di sini
                        </p>
                    </div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>Bulan / Tahun</th>
                                <th>Tahun Ajaran</th>
                                <th>Nominal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswa->tagihan as $tagihan)
                                <tr>
                                    <td>
                                        <div style="font-weight:500; font-size:13.5px;">{{ $tagihan->bulan }}</div>
                                        <div class="santri-id">{{ $tagihan->tahun }}</div>
                                    </td>
                                    <td>
                                        <span class="text-muted" style="font-size:12.5px;">
                                            {{ $tagihan->kategori_spp->tahun_ajaran ?? '—' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="amount text-emerald">
                                            Rp
                                            {{ number_format($tagihan->kategori_spp->nominal_spp ?? 0, 0, ',', '.') }}
                                        </span>
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
