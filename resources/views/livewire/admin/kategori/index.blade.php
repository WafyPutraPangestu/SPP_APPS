<div class="content">

    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3500)"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="notif-card">
            <div class="notif-icon">✓</div>
            <div>
                <div class="notif-title">Berhasil</div>
                <div class="notif-body">{{ session('message') }}</div>
            </div>
        </div>
    @endif

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="page-title">Kategori SPP</h1>
            <p class="text-muted mt-1" style="font-size:13px;">Kelola tahun ajaran dan nominal iuran SPP</p>
        </div>
        <a href="/admin/kategori/create" wire:navigate
            class="btn btn--primary shadow-md hover:shadow-xl transition-all duration-200">
            + Tambah Kategori
        </a>
    </div>

    {{-- STAT --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="stat-card stat-card--dark hover:-translate-y-1 hover:shadow-2xl transition-all duration-300">
            <div class="stat-label">Total Kategori</div>
            <div class="stat-value">{{ $kategoris->total() }}</div>
            <div class="stat-change" style="color:var(--em-300);">Tahun ajaran terdaftar</div>
        </div>
        <div class="stat-card stat-card--gold hover:-translate-y-1 transition-all duration-300">
            <div class="stat-label">Halaman</div>
            <div class="stat-value">{{ $kategoris->currentPage() }} / {{ $kategoris->lastPage() }}</div>
            <div class="stat-change text-muted">Paginasi aktif</div>
        </div>
        <div class="stat-card stat-card--white hover:shadow-xl transition-all duration-300">
            <div class="stat-label">Ditampilkan</div>
            <div class="stat-value">{{ $kategoris->count() }}</div>
            <div class="stat-change text-muted">Data per halaman</div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Tahun Ajaran</th>
                    <th>Nominal SPP</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kategoris as $kategori)
                    <tr x-data="{ confirmDelete: false }">
                        <td>
                            <div class="santri-info">
                                <div class="santri-avatar santri-avatar--em">
                                    📅
                                </div>
                                <div>
                                    <div class="santri-name">{{ $kategori->tahun_ajaran }}</div>
                                    <div class="santri-id">ID: {{ $kategori->id_kategori }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="amount text-emerald" style="font-size:14px; font-weight:600;">
                                Rp {{ number_format($kategori->nominal_spp, 0, ',', '.') }}
                            </span>
                        </td>
                        <td>
                            <span class="text-muted" style="font-size:12px;">
                                {{ $kategori->created_at->format('d M Y') }}
                            </span>
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="/admin/kategori/{{ $kategori->id_kategori }}" wire:navigate
                                    class="btn btn--ghost" style="padding:6px 14px; font-size:12px;">
                                    Detail
                                </a>
                                <a href="/admin/kategori/{{ $kategori->id_kategori }}/edit" wire:navigate
                                    class="btn btn--secondary" style="padding:6px 14px; font-size:12px;">
                                    Edit
                                </a>
                                <button @click="confirmDelete = true" class="btn"
                                    style="padding:6px 14px; font-size:12px; background:rgba(220,38,38,0.08); color:#991b1b;">
                                    Hapus
                                </button>
                            </div>

                            <div x-show="confirmDelete" x-cloak
                                class="fixed inset-0 z-50 flex items-center justify-center"
                                style="background:rgba(2,44,34,0.75); backdrop-filter:blur(4px);">
                                <div class="table-card"
                                    style="max-width:380px; width:100%; padding:28px; border-radius:var(--r-xl);">
                                    <div
                                        style="font-family:var(--font-display); font-weight:700; font-size:18px; margin-bottom:8px;">
                                        Hapus Kategori?
                                    </div>
                                    <p class="text-muted" style="font-size:13px; margin-bottom:20px;">
                                        Kategori <strong>{{ $kategori->tahun_ajaran }}</strong> akan dihapus permanen.
                                        Seluruh tagihan yang terhubung juga akan ikut terhapus.
                                    </p>
                                    <div class="flex gap-3">
                                        <button @click="confirmDelete = false" class="btn btn--ghost"
                                            style="flex:1;">Batal</button>
                                        <button wire:click="delete({{ $kategori->id_kategori }})"
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
                        <td colspan="4" style="text-align:center; padding:48px 20px;">
                            <div style="font-size:32px; margin-bottom:12px;">📋</div>
                            <div
                                style="font-family:var(--font-display); font-weight:700; font-size:16px; color:var(--ink-muted);">
                                Belum ada kategori SPP
                            </div>
                            <p class="text-muted" style="font-size:12px; margin-top:4px;">Tambahkan kategori tahun
                                ajaran pertama</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($kategoris->hasPages())
            <div
                style="padding:16px 20px; border-top:1px solid rgba(0,0,0,0.05); display:flex; align-items:center; justify-content:space-between;">
                <span class="text-muted" style="font-size:12px;">
                    Menampilkan {{ $kategoris->firstItem() }}–{{ $kategoris->lastItem() }} dari
                    {{ $kategoris->total() }} kategori
                </span>
                <div class="flex gap-2">
                    @if ($kategoris->onFirstPage())
                        <span class="btn btn--ghost"
                            style="padding:6px 14px; font-size:12px; opacity:0.4; cursor:not-allowed;">← Prev</span>
                    @else
                        <button wire:click="previousPage" class="btn btn--ghost"
                            style="padding:6px 14px; font-size:12px;">← Prev</button>
                    @endif
                    @if ($kategoris->hasMorePages())
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

</div>
