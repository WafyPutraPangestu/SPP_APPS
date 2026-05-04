<div class="content">

    <div class="flex items-center gap-4">
        <a href="/admin/siswa" wire:navigate class="btn btn--ghost" style="padding:8px 14px; font-size:13px;">
            ← Kembali
        </a>
        <div>
            <h1 class="page-title">Tambah Santri</h1>
            <p class="text-muted mt-1" style="font-size:13px;">Daftarkan data siswa baru ke dalam sistem</p>
        </div>
    </div>

    <div style="max-width:600px;">
        <div class="pay-card">
            <div style="position:relative; z-index:2;">

                <div style="margin-bottom:28px;">
                    <div class="brand-icon" style="width:40px; height:40px; font-size:18px; margin-bottom:12px;">🎒
                    </div>
                    <div style="font-family:var(--font-display); font-weight:700; font-size:20px; color:white;">
                        Data Santri Baru
                    </div>
                    <div style="font-size:12px; color:var(--em-300); margin-top:4px;">
                        Pastikan NIS belum terdaftar sebelumnya
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

                <button wire:click="save" wire:loading.attr="disabled" class="btn btn--primary btn--full"
                    style="font-size:14px; padding:12px;">
                    <span wire:loading.remove wire:target="save">Simpan Data</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>

            </div>
        </div>
    </div>

</div>
