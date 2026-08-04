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
            <h1 class="page-title">Manajemen Santri</h1>
            <p class="text-muted mt-1" style="font-size:13px;">Kelola data siswa / santri yang terdaftar</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.siswa.export') }}"
                style="display: flex; align-items: center; gap: 6px; padding: 8px 16px;
                       background: var(--em-700); color: white; border: none; border-radius: var(--r-sm);
                       font-family: var(--font-body); font-size: 12.5px; font-weight: 600;
                       text-decoration: none; transition: all 0.2s; white-space: nowrap;
                       box-shadow: 0 2px 8px rgba(6,95,70,0.25);"
                onmouseover="this.style.background='var(--em-800)'; this.style.transform='translateY(-1px)'"
                onmouseout="this.style.background='var(--em-700)'; this.style.transform='translateY(0)'"
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
            <a href="/admin/siswa/create" wire:navigate
                class="btn btn--primary shadow-md hover:shadow-xl transition-all duration-200">
                + Tambah Santri
            </a>
        </div>
    </div>

    {{-- STAT --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="stat-card stat-card--dark hover:-translate-y-1 hover:shadow-2xl transition-all duration-300">
            <div class="stat-label">Total Santri</div>
            <div class="stat-value">{{ $siswas->total() }}</div>
            <div class="stat-change" style="color:var(--em-300);">Terdaftar di sistem</div>
        </div>
        <div class="stat-card stat-card--gold hover:-translate-y-1 transition-all duration-300">
            <div class="stat-label">Halaman</div>
            <div class="stat-value">{{ $siswas->currentPage() }} / {{ $siswas->lastPage() }}</div>
            <div class="stat-change text-muted">Paginasi aktif</div>
        </div>
        <div class="stat-card stat-card--white hover:shadow-xl transition-all duration-300">
            <div class="stat-label">Ditampilkan</div>
            <div class="stat-value">{{ $siswas->count() }}</div>
            <div class="stat-change text-muted">Data per halaman</div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Santri</th>
                    <th>NIS</th>
                    <th>Kelas</th>
                    <th>Wali Murid</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($siswas as $siswa)
                    <tr x-data="{ confirmDelete: false }">
                        <td>
                            <div class="santri-info">
                                <div class="santri-avatar santri-avatar--em">
                                    {{ strtoupper(substr($siswa->nama_siswa, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="santri-name">{{ $siswa->nama_siswa }}</div>
                                    <div class="santri-id">ID: {{ $siswa->id_siswa }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="amount">{{ $siswa->nis }}</span></td>
                        <td><span class="chip chip--default">{{ $siswa->kelas }}</span></td>
                        <td>
                            @if ($siswa->user)
                                <div class="santri-info">
                                    <div class="santri-avatar santri-avatar--gold">
                                        {{ strtoupper(substr($siswa->user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="santri-name" style="font-size:12.5px;">{{ $siswa->user->name }}
                                        </div>
                                        <div class="santri-id">{{ $siswa->user->email }}</div>
                                    </div>
                                </div>
                            @else
                                <span class="badge badge--telat">Tidak ada</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="/admin/siswa/{{ $siswa->id_siswa }}" wire:navigate class="btn btn--ghost"
                                    style="padding:6px 14px; font-size:12px;">
                                    Detail
                                </a>
                                <a href="/admin/siswa/{{ $siswa->id_siswa }}/edit" wire:navigate
                                    class="btn btn--secondary" style="padding:6px 14px; font-size:12px;">
                                    Edit
                                </a>
                                <button @click="confirmDelete = true" class="btn"
                                    style="padding:6px 14px; font-size:12px; background:rgba(220,38,38,0.08); color:#991b1b;">
                                    Hapus
                                </button>
                            </div>

                            {{-- Confirm Delete Modal --}}
                            <div x-show="confirmDelete" x-cloak
                                class="fixed inset-0 z-50 flex items-center justify-center"
                                style="background:rgba(2,44,34,0.75); backdrop-filter:blur(4px);">
                                <div class="table-card"
                                    style="max-width:380px; width:100%; padding:28px; border-radius:var(--r-xl);">
                                    <div
                                        style="font-family:var(--font-display); font-weight:700; font-size:18px; margin-bottom:8px;">
                                        Hapus Data Santri?
                                    </div>
                                    <p class="text-muted" style="font-size:13px; margin-bottom:20px;">
                                        Data <strong>{{ $siswa->nama_siswa }}</strong> akan dihapus permanen beserta
                                        seluruh tagihan terkait.
                                    </p>
                                    <div class="flex gap-3">
                                        <button @click="confirmDelete = false" class="btn btn--ghost"
                                            style="flex:1;">Batal</button>
                                        <button wire:click="delete({{ $siswa->id_siswa }})"
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
                        <td colspan="5" style="text-align:center; padding:48px 20px;">
                            <div style="font-size:32px; margin-bottom:12px;">🎒</div>
                            <div
                                style="font-family:var(--font-display); font-weight:700; font-size:16px; color:var(--ink-muted);">
                                Belum ada data santri
                            </div>
                            <p class="text-muted" style="font-size:12px; margin-top:4px;">Tambahkan data santri pertama
                                Anda</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- PAGINATION --}}
        @if ($siswas->hasPages())
            <div
                style="padding:16px 20px; border-top:1px solid rgba(0,0,0,0.05); display:flex; align-items:center; justify-content:space-between;">
                <span class="text-muted" style="font-size:12px;">
                    Menampilkan {{ $siswas->firstItem() }}–{{ $siswas->lastItem() }} dari {{ $siswas->total() }}
                    santri
                </span>
                <div class="flex gap-2">
                    @if ($siswas->onFirstPage())
                        <span class="btn btn--ghost"
                            style="padding:6px 14px; font-size:12px; opacity:0.4; cursor:not-allowed;">← Prev</span>
                    @else
                        <button wire:click="previousPage" class="btn btn--ghost"
                            style="padding:6px 14px; font-size:12px;">← Prev</button>
                    @endif
                    @if ($siswas->hasMorePages())
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
