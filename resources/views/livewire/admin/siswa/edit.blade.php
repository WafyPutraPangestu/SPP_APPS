<div class="content">

    <div class="flex items-center gap-4">
        <a href="/admin/siswa" wire:navigate class="btn btn--ghost" style="padding:8px 14px; font-size:13px;">
            ← Kembali
        </a>
        <div>
            <h1 class="page-title">Edit Santri</h1>
            <p class="text-muted mt-1" style="font-size:13px;">Perbarui data {{ $siswa->nama_siswa }}</p>
        </div>
    </div>

    <div style="max-width:600px;">
        <div class="pay-card">
            <div style="position:relative; z-index:2;">

                {{-- Avatar preview --}}
                <div style="display:flex; align-items:center; gap:14px; margin-bottom:28px;">
                    <div class="avatar" style="width:52px; height:52px; font-size:18px; font-weight:700;">
                        {{ strtoupper(substr($siswa->nama_siswa, 0, 2)) }}
                    </div>
                    <div>
                        <div style="font-family:var(--font-display); font-weight:700; font-size:18px; color:white;">
                            {{ $siswa->nama_siswa }}
                        </div>
                        <div style="font-size:11px; color:var(--em-300); font-family:var(--font-mono);">
                            NIS: {{ $siswa->nis }}
                        </div>
                    </div>
                </div>

                {{-- WALI MURID --}}
                <div style="margin-bottom:18px;">
                    <label class="form-label">Wali Murid</label>
                    <select wire:model="id_user" class="form-select">
                        <option value="">-- Pilih Wali Murid --</option>
                        @foreach ($wali_murid as $wali)
                            <option value="{{ $wali->id }}">{{ $wali->name }} — {{ $wali->email }}</option>
                        @endforeach
                    </select>
                    @error('id_user')
                        <span
                            style="font-size:11px; color:#fca5a5; margin-top:4px; display:block;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- NIS --}}
                <div style="margin-bottom:18px;">
                    <label class="form-label">NIS</label>
                    <input type="text" wire:model="nis" class="form-input" placeholder="Nomor Induk Siswa">
                    @error('nis')
                        <span
                            style="font-size:11px; color:#fca5a5; margin-top:4px; display:block;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- NAMA --}}
                <div style="margin-bottom:18px;">
                    <label class="form-label">Nama Lengkap Santri</label>
                    <input type="text" wire:model="nama_siswa" class="form-input" placeholder="Nama lengkap santri">
                    @error('nama_siswa')
                        <span
                            style="font-size:11px; color:#fca5a5; margin-top:4px; display:block;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- KELAS --}}
                <div style="margin-bottom:28px;">
                    <label class="form-label">Kelas</label>
                    <input type="text" wire:model="kelas" class="form-input" placeholder="Contoh: VII-A, VIII-B">
                    @error('kelas')
                        <span
                            style="font-size:11px; color:#fca5a5; margin-top:4px; display:block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <a href="/admin/siswa" wire:navigate class="btn btn--ghost" style="flex:1; text-align:center;">
                        Batal
                    </a>
                    <button wire:click="update" wire:loading.attr="disabled" class="btn btn--primary"
                        style="flex:2; font-size:14px; padding:12px;">
                        <span wire:loading.remove wire:target="update">Simpan Perubahan</span>
                        <span wire:loading wire:target="update">Menyimpan...</span>
                    </button>
                </div>

            </div>
        </div>
    </div>

</div>
