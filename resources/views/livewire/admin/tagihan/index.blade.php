<div class="content">

    {{-- ── FLASH MESSAGE ───────────────────────────────── --}}
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2" class="notif-card">
            <div class="notif-icon">✓</div>
            <div>
                <div class="notif-title">Berhasil</div>
                <div class="notif-body">{{ session('message') }}</div>
            </div>
        </div>
    @endif

    {{-- ── HEADER ───────────────────────────────────────── --}}
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <h1 class="page-title">Manajemen Tagihan</h1>
            <p class="text-muted mt-1" style="font-size:13px;">Kelola, buat, dan pantau seluruh tagihan SPP santri</p>
        </div>

        <div class="flex gap-2 flex-wrap">
            <button wire:click="openGenerate" class="btn btn--secondary">
                ⚡ Generate Massal
            </button>
            <button wire:click="openCreate"
                class="btn btn--primary shadow-md hover:shadow-xl transition-all duration-200">
                + Buat Tagihan
            </button>
        </div>
    </div>

    {{-- ── STAT CARDS ────────────────────────────────────── --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="stat-card stat-card--dark hover:-translate-y-1 hover:shadow-2xl transition-all duration-300">
            <div class="stat-label">Total Tagihan</div>
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-change" style="color:var(--em-300);">Seluruh periode</div>
        </div>
        <div class="stat-card stat-card--gold hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
            <div class="stat-label">Belum Lunas</div>
            <div class="stat-value">{{ $stats['belum_lunas'] }}</div>
            <div class="stat-change text-danger">Perlu ditindaklanjuti</div>
        </div>
        <div class="stat-card stat-card--white hover:shadow-xl transition-all duration-300">
            <div class="stat-label">Sudah Lunas</div>
            <div class="stat-value">{{ $stats['lunas'] }}</div>
            <div class="stat-change text-emerald">Pembayaran selesai</div>
        </div>
    </div>

    {{-- ── FILTER BAR ─────────────────────────────────────── --}}
    <div class="table-card" style="padding:16px 20px;">
        <div class="flex flex-wrap gap-3 items-end">

            {{-- Status --}}
            <div style="flex:1; min-width:140px;">
                <div class="label-caps" style="margin-bottom:6px;">Status</div>
                <select wire:model.live="filterStatus"
                    style="width:100%; background:var(--surface); border:1px solid rgba(0,0,0,0.1); border-radius:var(--r-sm); padding:8px 12px; font-size:13px; color:var(--ink); outline:none;">
                    <option value="">Semua Status</option>
                    <option value="Belum Lunas">Belum Lunas</option>
                    <option value="Lunas">Lunas</option>
                </select>
            </div>

            {{-- Kategori --}}
            <div style="flex:1; min-width:160px;">
                <div class="label-caps" style="margin-bottom:6px;">Tahun Ajaran</div>
                <select wire:model.live="filterKategori"
                    style="width:100%; background:var(--surface); border:1px solid rgba(0,0,0,0.1); border-radius:var(--r-sm); padding:8px 12px; font-size:13px; color:var(--ink); outline:none;">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategoris as $k)
                        <option value="{{ $k->id_kategori }}">{{ $k->tahun_ajaran }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Bulan --}}
            <div style="flex:1; min-width:140px;">
                <div class="label-caps" style="margin-bottom:6px;">Bulan</div>
                <select wire:model.live="filterBulan"
                    style="width:100%; background:var(--surface); border:1px solid rgba(0,0,0,0.1); border-radius:var(--r-sm); padding:8px 12px; font-size:13px; color:var(--ink); outline:none;">
                    <option value="">Semua Bulan</option>
                    @foreach ($bulanList as $b)
                        <option value="{{ $b }}">{{ $b }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tahun --}}
            <div style="flex:1; min-width:120px;">
                <div class="label-caps" style="margin-bottom:6px;">Tahun</div>
                <input type="number" wire:model.live="filterTahun" placeholder="2024"
                    style="width:100%; background:var(--surface); border:1px solid rgba(0,0,0,0.1); border-radius:var(--r-sm); padding:8px 12px; font-size:13px; color:var(--ink); outline:none;">
            </div>

            {{-- Reset --}}
            <div>
                <button
                    wire:click="$set('filterStatus',''); $set('filterKategori',''); $set('filterBulan',''); $set('filterTahun','')"
                    class="btn btn--ghost" style="padding:8px 16px; font-size:12px;">
                    Reset Filter
                </button>
            </div>

        </div>
    </div>

    {{-- ── TABLE ──────────────────────────────────────────── --}}
    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Santri</th>
                    <th>Tahun Ajaran</th>
                    <th>Periode</th>
                    <th>Nominal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tagihans as $tagihan)
                    <tr x-data="{ confirmDelete: false }">

                        {{-- Santri --}}
                        <td>
                            <div class="santri-info">
                                <div class="santri-avatar santri-avatar--em">
                                    {{ strtoupper(substr($tagihan->siswa->nama_siswa ?? '?', 0, 2)) }}
                                </div>
                                <div>
                                    <div class="santri-name">{{ $tagihan->siswa->nama_siswa ?? '—' }}</div>
                                    <div class="santri-id">{{ $tagihan->siswa->nis ?? '—' }} · Kelas
                                        {{ $tagihan->siswa->kelas ?? '—' }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Tahun Ajaran --}}
                        <td>
                            <span class="chip chip--default">
                                {{ $tagihan->kategori_spp->tahun_ajaran ?? '—' }}
                            </span>
                        </td>

                        {{-- Periode --}}
                        <td>
                            <div style="font-weight:500; font-size:13.5px;">{{ $tagihan->bulan }}</div>
                            <div class="santri-id">{{ $tagihan->tahun }}</div>
                        </td>

                        {{-- Nominal --}}
                        <td>
                            <span class="amount text-emerald">
                                Rp {{ number_format($tagihan->kategori_spp->nominal_spp ?? 0, 0, ',', '.') }}
                            </span>
                        </td>

                        {{-- Status --}}
                        <td>
                            @if ($tagihan->status_tagihan === 'Lunas')
                                <span class="badge badge--lunas">Lunas</span>
                            @else
                                <span class="badge badge--pending">Belum Lunas</span>

                                {{-- Tambahan Indikator Terlambat untuk Admin --}}
                                @if ($tagihan->is_terlambat)
                                    <div
                                        style="font-size:11px; color:#dc2626; margin-top:6px; display:flex; align-items:center; gap:4px; font-weight:500;">
                                        ⚠️ Lewat Jatuh Tempo
                                    </div>
                                @endif
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td>
                            <div class="flex items-center gap-2 flex-wrap">

                                {{-- Tandai Lunas --}}
                                @if ($tagihan->status_tagihan !== 'Lunas')
                                    <button wire:click="tandaiLunas({{ $tagihan->id_tagihan }})"
                                        wire:confirm="Tandai tagihan ini sebagai Lunas?" class="btn"
                                        style="padding:5px 12px; font-size:11px; background:rgba(6,95,70,0.1); color:var(--em-800); border:1px solid rgba(6,95,70,0.2);">
                                        ✓ Lunas
                                    </button>

                                    {{-- Kirim Email Pengingat --}}
                                    <button wire:click="kirimPengingatEmail({{ $tagihan->id_tagihan }})"
                                        wire:loading.attr="disabled" class="btn"
                                        style="padding:5px 12px; font-size:11px; background:rgba(217,119,6,0.08); color:var(--gd-700); border:1px solid rgba(217,119,6,0.2);">
                                        <span wire:loading.remove
                                            wire:target="kirimPengingatEmail({{ $tagihan->id_tagihan }})">📧
                                            Email</span>
                                        <span wire:loading
                                            wire:target="kirimPengingatEmail({{ $tagihan->id_tagihan }})">⏳...</span>
                                    </button>
                                @endif

                                {{-- Edit --}}
                                <button wire:click="openEdit({{ $tagihan->id_tagihan }})" class="btn btn--secondary"
                                    style="padding:5px 12px; font-size:11px;">
                                    Edit
                                </button>

                                {{-- Hapus --}}
                                <button @click="confirmDelete = true" class="btn"
                                    style="padding:5px 12px; font-size:11px; background:rgba(220,38,38,0.08); color:#991b1b;">
                                    Hapus
                                </button>
                            </div>

                            {{-- Confirm Delete --}}
                            <div x-show="confirmDelete" x-cloak
                                class="fixed inset-0 z-50 flex items-center justify-center"
                                style="background:rgba(2,44,34,0.75); backdrop-filter:blur(4px);">
                                <div class="table-card"
                                    style="max-width:380px; width:90%; padding:28px; border-radius:var(--r-xl);">
                                    <div
                                        style="font-family:var(--font-display); font-weight:700; font-size:18px; margin-bottom:8px;">
                                        Hapus Tagihan?</div>
                                    <p class="text-muted" style="font-size:13px; margin-bottom:20px;">
                                        Tagihan <strong>{{ $tagihan->bulan }} {{ $tagihan->tahun }}</strong> milik
                                        <strong>{{ $tagihan->siswa->nama_siswa ?? '—' }}</strong> akan dihapus
                                        permanen.
                                    </p>
                                    <div class="flex gap-3">
                                        <button @click="confirmDelete = false" class="btn btn--ghost"
                                            style="flex:1;">Batal</button>
                                        <button wire:click="delete({{ $tagihan->id_tagihan }})"
                                            @click="confirmDelete = false" class="btn"
                                            style="flex:1; background:#dc2626; color:white;">
                                            Ya, Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:56px 20px;">
                            <div style="font-size:36px; margin-bottom:12px;">📭</div>
                            <div
                                style="font-family:var(--font-display); font-weight:700; font-size:16px; color:var(--ink-muted);">
                                Tidak ada tagihan ditemukan
                            </div>
                            <p class="text-muted" style="font-size:12px; margin-top:4px;">
                                Coba ubah filter atau buat tagihan baru
                            </p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if ($tagihans->hasPages())
            <div
                style="padding:16px 20px; border-top:1px solid rgba(0,0,0,0.05); display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
                <span class="text-muted" style="font-size:12px;">
                    Menampilkan {{ $tagihans->firstItem() }}–{{ $tagihans->lastItem() }} dari
                    {{ $tagihans->total() }} tagihan
                </span>
                <div class="flex gap-2">
                    @if ($tagihans->onFirstPage())
                        <span class="btn btn--ghost"
                            style="padding:6px 14px; font-size:12px; opacity:0.4; cursor:not-allowed;">← Prev</span>
                    @else
                        <button wire:click="previousPage" class="btn btn--ghost"
                            style="padding:6px 14px; font-size:12px;">← Prev</button>
                    @endif
                    @if ($tagihans->hasMorePages())
                        <button wire:click="nextPage" class="btn btn--secondary"
                            style="padding:6px 14px; font-size:12px;">Next →</button>
                    @else
                        <span class="btn btn--secondary"
                            style="padding:6px 14px; font-size:12px; opacity:0.4; cursor:not-allowed;">Next →</span>
                    @endif
                </div>
            </div>
        @endif
    </div>


    {{-- ══════════════════════════════════════════════════
         MODAL: BUAT TAGIHAN
    ══════════════════════════════════════════════════ --}}
    <div x-show="$wire.showCreateModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center"
        style="background:rgba(2,44,34,0.8); backdrop-filter:blur(6px);"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100">

        <div class="pay-card" style="max-width:480px; width:90%; max-height:90vh; overflow-y:auto;">
            <div style="position:relative; z-index:2;">

                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
                    <div>
                        <div style="font-family:var(--font-display); font-weight:700; font-size:20px; color:white;">
                            Buat Tagihan
                        </div>
                        <div style="font-size:12px; color:var(--em-300); margin-top:3px;">Tagihan untuk satu santri
                        </div>
                    </div>
                    <button wire:click="$set('showCreateModal', false)"
                        style="background:rgba(255,255,255,0.1); border:none; color:white; width:32px; height:32px; border-radius:50%; cursor:pointer; font-size:16px; display:flex; align-items:center; justify-content:center;">
                        ✕
                    </button>
                </div>

                {{-- Santri --}}
                <div style="margin-bottom:16px;">
                    <label class="form-label">Santri</label>
                    <select wire:model="create_id_siswa" class="form-select">
                        <option value="">-- Pilih Santri --</option>
                        @foreach ($siswas as $s)
                            <option value="{{ $s->id_siswa }}">{{ $s->nama_siswa }} — {{ $s->nis }}</option>
                        @endforeach
                    </select>
                    @error('create_id_siswa')
                        <span
                            style="font-size:11px; color:#fca5a5; margin-top:4px; display:block;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div style="margin-bottom:16px;">
                    <label class="form-label">Tahun Ajaran / Kategori</label>
                    <select wire:model="create_id_kategori" class="form-select">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoris as $k)
                            <option value="{{ $k->id_kategori }}">{{ $k->tahun_ajaran }} — Rp
                                {{ number_format($k->nominal_spp, 0, ',', '.') }}</option>
                        @endforeach
                    </select>
                    @error('create_id_kategori')
                        <span
                            style="font-size:11px; color:#fca5a5; margin-top:4px; display:block;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Bulan & Tahun --}}
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:24px;">
                    <div>
                        <label class="form-label">Bulan</label>
                        <select wire:model="create_bulan" class="form-select">
                            <option value="">-- Bulan --</option>
                            @foreach ($bulanList as $b)
                                <option value="{{ $b }}">{{ $b }}</option>
                            @endforeach
                        </select>
                        @error('create_bulan')
                            <span
                                style="font-size:11px; color:#fca5a5; margin-top:4px; display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="form-label">Tahun</label>
                        <input type="number" wire:model="create_tahun" class="form-input" placeholder="2024"
                            min="2000" max="2100">
                        @error('create_tahun')
                            <span
                                style="font-size:11px; color:#fca5a5; margin-top:4px; display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex gap-3">
                    <button wire:click="$set('showCreateModal', false)" class="btn btn--ghost"
                        style="flex:1;">Batal</button>
                    <button wire:click="save" wire:loading.attr="disabled" class="btn btn--primary" style="flex:2;">
                        <span wire:loading.remove wire:target="save">Simpan Tagihan</span>
                        <span wire:loading wire:target="save">Menyimpan...</span>
                    </button>
                </div>

            </div>
        </div>
    </div>


    {{-- ══════════════════════════════════════════════════
         MODAL: GENERATE MASSAL
    ══════════════════════════════════════════════════ --}}
    <div x-show="$wire.showGenerateModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center"
        style="background:rgba(2,44,34,0.8); backdrop-filter:blur(6px);"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100">

        <div class="pay-card" style="max-width:460px; width:90%;">
            <div style="position:relative; z-index:2;">

                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
                    <div>
                        <div style="font-family:var(--font-display); font-weight:700; font-size:20px; color:white;">
                            ⚡ Generate Massal
                        </div>
                        <div style="font-size:12px; color:var(--em-300); margin-top:3px;">Buat tagihan untuk semua
                            santri sekaligus</div>
                    </div>
                    <button wire:click="$set('showGenerateModal', false)"
                        style="background:rgba(255,255,255,0.1); border:none; color:white; width:32px; height:32px; border-radius:50%; cursor:pointer; font-size:16px; display:flex; align-items:center; justify-content:center;">
                        ✕
                    </button>
                </div>

                {{-- Warning notice --}}
                <div
                    style="background:rgba(245,158,11,0.12); border:1px solid rgba(245,158,11,0.3); border-radius:var(--r-sm); padding:12px 14px; margin-bottom:20px; display:flex; gap:10px; align-items:flex-start;">
                    <span style="font-size:16px;">⚠️</span>
                    <div style="font-size:12px; color:var(--gd-300); line-height:1.6;">
                        Tagihan akan dibuat untuk <strong>seluruh santri aktif</strong>. Santri yang sudah memiliki
                        tagihan di periode yang sama akan dilewati otomatis.
                    </div>
                </div>

                {{-- Kategori --}}
                <div style="margin-bottom:16px;">
                    <label class="form-label">Tahun Ajaran / Kategori</label>
                    <select wire:model="generate_id_kategori" class="form-select ">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoris as $k)
                            <option value="{{ $k->id_kategori }}">{{ $k->tahun_ajaran }} — Rp
                                {{ number_format($k->nominal_spp, 0, ',', '.') }}</option>
                        @endforeach
                    </select>
                    @error('generate_id_kategori')
                        <span
                            style="font-size:11px; color:#fca5a5; margin-top:4px; display:block;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Bulan & Tahun --}}
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:24px;">
                    <div>
                        <label class="form-label">Bulan</label>
                        <select wire:model="generate_bulan" class="form-select ">
                            <option value="" class="text-white">-- Bulan --</option>
                            @foreach ($bulanList as $b)
                                <option value="{{ $b }}" class="">{{ $b }}</option>
                            @endforeach
                        </select>
                        @error('generate_bulan')
                            <span
                                style="font-size:11px; color:#fca5a5; margin-top:4px; display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="form-label">Tahun</label>
                        <input type="number" wire:model="generate_tahun" class="form-input" placeholder="2024"
                            min="2000" max="2100">
                        @error('generate_tahun')
                            <span
                                style="font-size:11px; color:#fca5a5; margin-top:4px; display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex gap-3">
                    <button wire:click="$set('showGenerateModal', false)" class="btn btn--ghost"
                        style="flex:1;">Batal</button>
                    <button wire:click="generate" wire:loading.attr="disabled" class="btn btn--primary"
                        style="flex:2;">
                        <span wire:loading.remove wire:target="generate">⚡ Generate Sekarang</span>
                        <span wire:loading wire:target="generate">Memproses...</span>
                    </button>
                </div>

            </div>
        </div>
    </div>


    {{-- ══════════════════════════════════════════════════
         MODAL: EDIT TAGIHAN
    ══════════════════════════════════════════════════ --}}
    <div x-show="$wire.showEditModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center"
        style="background:rgba(2,44,34,0.8); backdrop-filter:blur(6px);"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100">

        <div class="pay-card" style="max-width:480px; width:90%; max-height:90vh; overflow-y:auto;">
            <div style="position:relative; z-index:2;">

                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
                    <div>
                        <div style="font-family:var(--font-display); font-weight:700; font-size:20px; color:white;">
                            Edit Tagihan
                        </div>
                        <div style="font-size:12px; color:var(--em-300); margin-top:3px;">Koreksi data tagihan</div>
                    </div>
                    <button wire:click="$set('showEditModal', false)"
                        style="background:rgba(255,255,255,0.1); border:none; color:white; width:32px; height:32px; border-radius:50%; cursor:pointer; font-size:16px; display:flex; align-items:center; justify-content:center;">
                        ✕
                    </button>
                </div>

                {{-- Santri --}}
                <div style="margin-bottom:16px;">
                    <label class="form-label">Santri</label>
                    <select wire:model="edit_id_siswa" class="form-select">
                        <option value="">-- Pilih Santri --</option>
                        @foreach ($siswas as $s)
                            <option value="{{ $s->id_siswa }}">{{ $s->nama_siswa }} — {{ $s->nis }}</option>
                        @endforeach
                    </select>
                    @error('edit_id_siswa')
                        <span
                            style="font-size:11px; color:#fca5a5; margin-top:4px; display:block;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div style="margin-bottom:16px;">
                    <label class="form-label">Tahun Ajaran / Kategori</label>
                    <select wire:model="edit_id_kategori" class="form-select">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoris as $k)
                            <option value="{{ $k->id_kategori }}">{{ $k->tahun_ajaran }} — Rp
                                {{ number_format($k->nominal_spp, 0, ',', '.') }}</option>
                        @endforeach
                    </select>
                    @error('edit_id_kategori')
                        <span
                            style="font-size:11px; color:#fca5a5; margin-top:4px; display:block;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Bulan & Tahun --}}
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:16px;">
                    <div>
                        <label class="form-label">Bulan</label>
                        <select wire:model="edit_bulan" class="form-select">
                            <option value="">-- Bulan --</option>
                            @foreach ($bulanList as $b)
                                <option value="{{ $b }}">{{ $b }}</option>
                            @endforeach
                        </select>
                        @error('edit_bulan')
                            <span
                                style="font-size:11px; color:#fca5a5; margin-top:4px; display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="form-label">Tahun</label>
                        <input type="number" wire:model="edit_tahun" class="form-input" placeholder="2024"
                            min="2000" max="2100">
                        @error('edit_tahun')
                            <span
                                style="font-size:11px; color:#fca5a5; margin-top:4px; display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Status --}}
                <div style="margin-bottom:24px;">
                    <label class="form-label">Status Tagihan</label>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                        <label wire:click="$set('edit_status', 'Belum Lunas')"
                            style="cursor:pointer; padding:12px; border-radius:var(--r-sm); border:1.5px solid {{ $edit_status === 'Belum Lunas' ? 'rgba(217,119,6,0.6)' : 'rgba(255,255,255,0.1)' }}; background:{{ $edit_status === 'Belum Lunas' ? 'rgba(217,119,6,0.12)' : 'transparent' }}; transition:all 0.15s; display:flex; align-items:center; gap:8px;">
                            <span
                                style="width:14px; height:14px; border-radius:50%; border:2px solid {{ $edit_status === 'Belum Lunas' ? 'var(--gd-400)' : 'rgba(255,255,255,0.3)' }}; background:{{ $edit_status === 'Belum Lunas' ? 'var(--gd-400)' : 'transparent' }}; flex-shrink:0; transition:all 0.15s;"></span>
                            <span
                                style="font-size:12px; color:{{ $edit_status === 'Belum Lunas' ? 'var(--gd-300)' : 'rgba(255,255,255,0.5)' }}; font-weight:500;">Belum
                                Lunas</span>
                        </label>
                        <label wire:click="$set('edit_status', 'Lunas')"
                            style="cursor:pointer; padding:12px; border-radius:var(--r-sm); border:1.5px solid {{ $edit_status === 'Lunas' ? 'rgba(16,185,129,0.5)' : 'rgba(255,255,255,0.1)' }}; background:{{ $edit_status === 'Lunas' ? 'rgba(16,185,129,0.1)' : 'transparent' }}; transition:all 0.15s; display:flex; align-items:center; gap:8px;">
                            <span
                                style="width:14px; height:14px; border-radius:50%; border:2px solid {{ $edit_status === 'Lunas' ? 'var(--em-500)' : 'rgba(255,255,255,0.3)' }}; background:{{ $edit_status === 'Lunas' ? 'var(--em-500)' : 'transparent' }}; flex-shrink:0; transition:all 0.15s;"></span>
                            <span
                                style="font-size:12px; color:{{ $edit_status === 'Lunas' ? 'var(--em-300)' : 'rgba(255,255,255,0.5)' }}; font-weight:500;">Lunas</span>
                        </label>
                    </div>
                    @error('edit_status')
                        <span
                            style="font-size:11px; color:#fca5a5; margin-top:4px; display:block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button wire:click="$set('showEditModal', false)" class="btn btn--ghost"
                        style="flex:1;">Batal</button>
                    <button wire:click="update" wire:loading.attr="disabled" class="btn btn--primary"
                        style="flex:2;">
                        <span wire:loading.remove wire:target="update">Simpan Perubahan</span>
                        <span wire:loading wire:target="update">Menyimpan...</span>
                    </button>
                </div>

            </div>
        </div>
    </div>

</div>
