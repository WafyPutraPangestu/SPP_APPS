<div>
    <header class="topbar">
        <div>
            <div class="label-caps">Portal Wali Murid</div>
            <h1 class="page-title" style="margin-top: 2px;">Tagihan SPP</h1>
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

        {{-- FLASH MESSAGE --}}
        @if (session()->has('message'))
            <div class="notif-card" x-data="{ show: true }" x-show="show"
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
                <div class="notif-icon">✅</div>
                <div>
                    <div class="notif-title">Berhasil</div>
                    <div class="notif-body">{{ session('message') }}</div>
                </div>
                <button @click="show = false"
                    style="margin-left: auto; background: none; border: none; cursor: pointer; color: var(--gd-700); font-size: 18px; line-height: 1;">×</button>
            </div>
        @endif

        {{-- ── STAT CARDS ──────────────────────────── --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <div class="stat-card stat-card--dark hover:-translate-y-1 hover:shadow-2xl transition-all duration-300">
                <div class="stat-label" style="color: var(--em-300);">Total Tagihan</div>
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-change" style="color: var(--em-300); opacity: 0.8;">Seluruh periode</div>
            </div>

            <div class="stat-card stat-card--gold hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                <div class="stat-label">Belum Lunas</div>
                <div class="stat-value" style="color: var(--gd-900);">{{ $stats['belum_lunas'] }}</div>
                <div class="stat-change" style="color: var(--gd-700);">
                    Rp {{ number_format($stats['total_nominal'], 0, ',', '.') }}
                </div>
            </div>

            <div class="stat-card stat-card--white hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                <div class="stat-label">Sudah Lunas</div>
                <div class="stat-value" style="color: var(--em-800);">{{ $stats['lunas'] }}</div>
                <div class="stat-change text-emerald">Pembayaran selesai ✓</div>
            </div>

        </div>

        {{-- ── FILTER ──────────────────────────────── --}}
        <div class="bg-white rounded-xl"
            style="padding: 16px 20px; border: 1px solid rgba(0,0,0,0.06); display: flex; flex-wrap: wrap; gap: 12px; align-items: center;">

            <span class="label-caps" style="flex-shrink: 0;">Filter :</span>

            <select wire:model.live="filterStatus"
                style="padding: 7px 12px; border-radius: var(--r-sm); border: 1px solid rgba(0,0,0,0.12);
                           font-family: var(--font-body); font-size: 13px; color: var(--ink); background: var(--surface); cursor: pointer; outline: none;">
                <option value="">Semua Status</option>
                <option value="Belum Lunas">Belum Lunas</option>
                <option value="Lunas">Lunas</option>
            </select>

            <select wire:model.live="filterBulan"
                style="padding: 7px 12px; border-radius: var(--r-sm); border: 1px solid rgba(0,0,0,0.12);
                           font-family: var(--font-body); font-size: 13px; color: var(--ink); background: var(--surface); cursor: pointer; outline: none;">
                <option value="">Semua Bulan</option>
                @foreach ($bulanList as $b)
                    <option value="{{ $b }}">{{ $b }}</option>
                @endforeach
            </select>

            <select wire:model.live="filterTahun"
                style="padding: 7px 12px; border-radius: var(--r-sm); border: 1px solid rgba(0,0,0,0.12);
                           font-family: var(--font-body); font-size: 13px; color: var(--ink); background: var(--surface); cursor: pointer; outline: none;">
                <option value="">Semua Tahun</option>
                @foreach (range(date('Y'), date('Y') - 4) as $y)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endforeach
            </select>

            @if ($filterStatus || $filterBulan || $filterTahun)
                <button wire:click="$set('filterStatus', ''); $set('filterBulan', ''); $set('filterTahun', '')"
                    class="btn btn--ghost" style="padding: 7px 14px; font-size: 12px;">
                    ✕ Reset
                </button>
            @endif

        </div>

        {{-- ── TAGIHAN CARDS GRID ───────────────────── --}}
        @if ($tagihans->isEmpty())
            <div style="text-align: center; padding: 64px 24px;">
                <div style="font-size: 48px; margin-bottom: 16px;">📭</div>
                <div class="section-title" style="color: var(--ink-muted);">Tidak Ada Tagihan</div>
                <p style="color: var(--ink-faint); font-size: 13px; margin-top: 8px;">
                    Belum ada tagihan yang cocok dengan filter yang dipilih.
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                @foreach ($tagihans as $tagihan)
                    @php
                        $isLunas = $tagihan->status_tagihan === 'Lunas';
                        $hasPending = $tagihan->pembayaran->where('status_pembayaran', 'pending')->isNotEmpty();
                        $isTerlambat = $tagihan->is_terlambat;
                    @endphp

                    <div class="mini-card hover:-translate-y-1 hover:shadow-lg transition-all duration-300"
                        style="cursor: pointer; position: relative; {{ $isTerlambat && !$isLunas ? 'border: 1px solid rgba(220,38,38,0.4);' : '' }}"
                        wire:key="tagihan-{{ $tagihan->id_tagihan }}">

                        <div class="mini-card__accent"
                            style="{{ $isLunas ? 'background: linear-gradient(180deg, var(--em-500), var(--em-700));' : ($isTerlambat ? 'background: linear-gradient(180deg, #ef4444, #991b1b);' : 'background: linear-gradient(180deg, var(--gd-400), var(--gd-700));') }}">
                        </div>

                        {{-- STATUS BADGE --}}
                        <div
                            style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px; padding-left: 4px;">
                            <div style="display: flex; gap: 8px;">
                                <span class="badge {{ $isLunas ? 'badge--lunas' : 'badge--pending' }}">
                                    {{ $tagihan->status_tagihan }}
                                </span>

                                {{-- Munculkan peringatan merah jika lewat jatuh tempo --}}
                                @if ($isTerlambat && !$isLunas)
                                    <span class="badge"
                                        style="background: rgba(220,38,38,0.1); color: #dc2626; border: 1px solid rgba(220,38,38,0.2);">
                                        ⚠️ Terlewat
                                    </span>
                                @endif
                            </div>
                            <span class="label-caps">{{ $tagihan->tahun }}</span>
                        </div>

                        {{-- SISWA INFO --}}
                        <div class="santri-info" style="margin-bottom: 14px; padding-left: 4px;">
                            <div class="santri-avatar santri-avatar--em"
                                style="width: 38px; height: 38px; font-size: 13px;">
                                {{ strtoupper(substr($tagihan->siswa->nama_siswa, 0, 2)) }}
                            </div>
                            <div>
                                <div class="santri-name">{{ $tagihan->siswa->nama_siswa }}</div>
                                <div class="santri-id">{{ $tagihan->siswa->nis }} · Kelas
                                    {{ $tagihan->siswa->kelas }}</div>
                            </div>
                        </div>

                        {{-- BULAN & NOMINAL --}}
                        <div style="padding-left: 4px; margin-bottom: 16px;">
                            <div style="display: flex; justify-content: space-between; align-items: baseline;">
                                <div>
                                    <div class="label-caps" style="margin-bottom: 2px;">Bulan</div>
                                    <div
                                        style="font-family: var(--font-display); font-weight: 700; font-size: 18px; letter-spacing: -0.3px;">
                                        {{ $tagihan->bulan }}
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <div class="label-caps" style="margin-bottom: 2px;">Nominal</div>
                                    <div class="amount"
                                        style="font-size: 16px; font-weight: 600;
                                             color: {{ $isLunas ? 'var(--em-700)' : 'var(--gd-700)' }};">
                                        Rp {{ number_format($tagihan->kategori_spp->nominal_spp, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- TAHUN AJARAN --}}
                        <div style="padding-left: 4px; margin-bottom: 18px;">
                            <div class="label-caps" style="margin-bottom: 2px;">Tahun Ajaran</div>
                            <div style="font-size: 13px; color: var(--ink-muted);">
                                {{ $tagihan->kategori_spp->tahun_ajaran }}
                            </div>
                        </div>

                        {{-- ACTION --}}
                        <a href="{{ route('wali-murid.tagihan.show', $tagihan->id_tagihan) }}"
                            style="display: block; padding-left: 4px;">
                            @if ($isLunas)
                                <button class="btn btn--ghost btn--full"
                                    style="border-color: var(--em-500); color: var(--em-700);">
                                    <span>✓</span> Lihat Detail
                                </button>
                            @elseif ($hasPending)
                                <button class="btn btn--primary btn--full">
                                    ⏳ Lanjutkan Pembayaran
                                </button>
                            @else
                                <button class="btn btn--primary btn--full"
                                    style="background: linear-gradient(135deg, var(--gd-400), var(--gd-500));">
                                    💳 Bayar Sekarang
                                </button>
                            @endif
                        </a>

                    </div>
                @endforeach
            </div>

            {{-- PAGINATION --}}
            <div style="display: flex; justify-content: center;">
                {{ $tagihans->links() }}
            </div>
        @endif

    </main>
</div>

</div>
