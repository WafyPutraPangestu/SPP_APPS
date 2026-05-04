<div class="content">

    {{-- HEADER --}}
    <div class="flex items-center gap-4">
        <a href="/admin/users" wire:navigate class="btn btn--ghost" style="padding:8px 14px; font-size:13px;">
            ← Kembali
        </a>
        <div>
            <h1 class="page-title">Detail Wali Murid</h1>
            <p class="text-muted mt-1" style="font-size:13px;">Informasi lengkap akun dan siswa terdaftar</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6" style="align-items:start;">

        {{-- PROFILE CARD --}}
        <div class="pay-card" style="grid-column: span 1;">
            <div style="position:relative; z-index:2; text-align:center;">
                <div class="avatar"
                    style="width:72px; height:72px; font-size:26px; font-weight:700; margin:0 auto 16px;">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div
                    style="font-family:var(--font-display); font-weight:700; font-size:20px; color:white; margin-bottom:4px;">
                    {{ $user->name }}
                </div>
                <div style="font-size:12px; color:var(--em-300); margin-bottom:16px;">{{ $user->email }}</div>

                <div class="badge badge--lunas" style="margin:0 auto 20px; display:inline-flex;">
                    wali_murid
                </div>

                <div style="border-top:1px solid rgba(255,255,255,0.08); padding-top:16px; text-align:left;">
                    <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                        <span
                            style="font-size:11px; color:rgba(255,255,255,0.45); letter-spacing:1px; text-transform:uppercase;">Bergabung</span>
                        <span style="font-size:12px; color:white; font-family:var(--font-mono);">
                            {{ $user->created_at->format('d M Y') }}
                        </span>
                    </div>
                    <div style="display:flex; justify-content:space-between;">
                        <span
                            style="font-size:11px; color:rgba(255,255,255,0.45); letter-spacing:1px; text-transform:uppercase;">Total
                            Siswa</span>
                        <span
                            style="font-size:12px; color:var(--gd-300); font-family:var(--font-mono); font-weight:600;">
                            {{ $user->siswa->count() }} Siswa
                        </span>
                    </div>
                </div>

                <a href="/admin/users/{{ $user->id }}/edit" wire:navigate class="btn btn--primary btn--full"
                    style="margin-top:20px;">
                    Edit Akun
                </a>
            </div>
        </div>

        {{-- SISWA LIST --}}
        <div style="grid-column: span 2;">
            <div class="table-card">
                <div style="padding:20px 20px 14px; border-bottom:1px solid rgba(0,0,0,0.05);">
                    <div class="section-title">Daftar Siswa</div>
                    <p class="text-muted" style="font-size:12px; margin-top:2px;">
                        Siswa yang terhubung dengan akun ini
                    </p>
                </div>

                @if ($user->siswa->isEmpty())
                    <div style="padding:48px 20px; text-align:center;">
                        <div style="font-size:32px; margin-bottom:12px;">🎒</div>
                        <div
                            style="font-family:var(--font-display); font-weight:700; font-size:15px; color:var(--ink-muted);">
                            Belum ada siswa
                        </div>
                        <p class="text-muted" style="font-size:12px; margin-top:4px;">
                            Wali murid ini belum memiliki data siswa terdaftar
                        </p>
                    </div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>NIS</th>
                                <th>Kelas</th>
                                <th>Tagihan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->siswa as $siswa)
                                <tr>
                                    <td>
                                        <div class="santri-info">
                                            <div class="santri-avatar santri-avatar--gold">
                                                {{ strtoupper(substr($siswa->nama_siswa, 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="santri-name">{{ $siswa->nama_siswa }}</div>
                                                <div class="santri-id">ID: {{ $siswa->id_siswa }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="amount">{{ $siswa->nis }}</span>
                                    </td>
                                    <td>
                                        <span class="chip chip--default">{{ $siswa->kelas }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $lunas = $siswa->tagihan->where('status_tagihan', 'Lunas')->count();
                                            $total = $siswa->tagihan->count();
                                        @endphp
                                        @if ($total > 0)
                                            <span
                                                class="{{ $lunas === $total ? 'badge badge--lunas' : 'badge badge--pending' }}">
                                                {{ $lunas }}/{{ $total }} Lunas
                                            </span>
                                        @else
                                            <span class="text-muted" style="font-size:12px;">—</span>
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
