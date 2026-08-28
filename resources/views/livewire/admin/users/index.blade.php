<div class="content">

    {{-- FLASH MESSAGE --}}
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3500)"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="notif-card">
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
            <h1 class="page-title">Manajemen Wali Murid</h1>
            <p class="text-muted mt-1" style="font-size:13px;">Kelola akun orang tua / wali murid di sistem</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="/admin/users/create" wire:navigate
                class="btn btn--primary shadow-md hover:shadow-xl transition-all duration-200">
                + Tambah Akun
            </a>
        </div>
    </div>

    {{-- STAT SUMMARY --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="stat-card stat-card--dark hover:-translate-y-1 hover:shadow-2xl transition-all duration-300">
            <div class="stat-label">Total Wali Murid</div>
            <div class="stat-value">{{ $users->total() }}</div>
            <div class="stat-change" style="color:var(--em-300);">Akun terdaftar</div>
        </div>
        <div class="stat-card stat-card--gold hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
            <div class="stat-label">Halaman</div>
            <div class="stat-value">{{ $users->currentPage() }} / {{ $users->lastPage() }}</div>
            <div class="stat-change text-muted">Paginasi aktif</div>
        </div>
        <div class="stat-card stat-card--white hover:shadow-xl transition-all duration-300">
            <div class="stat-label">Data per Halaman</div>
            <div class="stat-value">{{ $users->count() }}</div>
            <div class="stat-change text-muted">Ditampilkan sekarang</div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr x-data="{ confirmDelete: false }">
                        <td>
                            <div class="santri-info">
                                <div class="santri-avatar santri-avatar--em">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="santri-name">{{ $user->name }}</div>
                                    <div class="santri-id">wali_murid</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="amount text-muted">{{ $user->email }}</span>
                        </td>
                        <td>
                            <span class="text-muted" style="font-size:12px;">
                                {{ $user->created_at->format('d M Y') }}
                            </span>
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="/admin/users/{{ $user->id }}" wire:navigate
                                    class="btn btn--ghost" style="padding:6px 14px; font-size:12px;">
                                    Detail
                                </a>
                                <a href="/admin/users/{{ $user->id }}/edit" wire:navigate
                                    class="btn btn--secondary" style="padding:6px 14px; font-size:12px;">
                                    Edit
                                </a>
                                <button @click="confirmDelete = true"
                                    class="btn" style="padding:6px 14px; font-size:12px; background:rgba(220,38,38,0.08); color:#991b1b;">
                                    Hapus
                                </button>
                            </div>

                            {{-- Confirm Delete Modal --}}
                            <div x-show="confirmDelete" x-cloak
                                class="fixed inset-0 z-50 flex items-center justify-center"
                                style="background:rgba(2,44,34,0.7); backdrop-filter:blur(4px);">
                                <div class="table-card" style="max-width:380px; width:100%; padding:28px; border-radius:var(--r-xl);">
                                    <div style="font-family:var(--font-display); font-weight:700; font-size:18px; margin-bottom:8px;">
                                        Hapus Akun?
                                    </div>
                                    <p class="text-muted" style="font-size:13px; margin-bottom:20px;">
                                        Akun <strong>{{ $user->name }}</strong> akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.
                                    </p>
                                    <div class="flex gap-3">
                                        <button @click="confirmDelete = false" class="btn btn--ghost" style="flex:1;">Batal</button>
                                        <button wire:click="delete({{ $user->id }})" @click="confirmDelete = false"
                                            class="btn" style="flex:1; background:#dc2626; color:white;">
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
                            <div style="font-size:32px; margin-bottom:12px;">👤</div>
                            <div style="font-family:var(--font-display); font-weight:700; font-size:16px; color:var(--ink-muted);">
                                Belum ada wali murid
                            </div>
                            <p class="text-muted" style="font-size:12px; margin-top:4px;">Tambahkan akun wali murid pertama Anda</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- PAGINATION --}}
        @if ($users->hasPages())
            <div style="padding:16px 20px; border-top:1px solid rgba(0,0,0,0.05); display:flex; align-items:center; justify-content:space-between;">
                <span class="text-muted" style="font-size:12px;">
                    Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} akun
                </span>
                <div class="flex gap-2">
                    @if ($users->onFirstPage())
                        <span class="btn btn--ghost" style="padding:6px 14px; font-size:12px; opacity:0.4; cursor:not-allowed;">← Prev</span>
                    @else
                        <button wire:click="previousPage" class="btn btn--ghost" style="padding:6px 14px; font-size:12px;">← Prev</button>
                    @endif

                    @if ($users->hasMorePages())
                        <button wire:click="nextPage" class="btn btn--secondary" style="padding:6px 14px; font-size:12px;">Next →</button>
                    @else
                        <span class="btn btn--secondary" style="padding:6px 14px; font-size:12px; opacity:0.4; cursor:not-allowed;">Next →</span>
                    @endif
                </div>
            </div>
        @endif
    </div>

</div>