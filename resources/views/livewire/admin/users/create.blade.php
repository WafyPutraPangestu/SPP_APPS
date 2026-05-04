<div class="content ">

    {{-- HEADER --}}
    <div class="flex items-center gap-4">
        <a href="/admin/users" wire:navigate class="btn btn--ghost" style="padding:8px 14px; font-size:13px;">
            ← Kembali
        </a>
        <div>
            <h1 class="page-title">Tambah Wali Murid</h1>
            <p class="text-muted mt-1" style="font-size:13px;">Buat akun login baru untuk orang tua / wali murid</p>
        </div>
    </div>

    {{-- FORM CARD --}}
    <div style="max-width:600px;">
        <div class="pay-card">
            <div style="position:relative; z-index:2;">

                <div style="margin-bottom:28px;">
                    <div class="brand-icon" style="margin-bottom:0; width:40px; height:40px; font-size:18px;">👤</div>
                    <div
                        style="font-family:var(--font-display); font-weight:700; font-size:20px; color:white; margin-top:12px;">
                        Akun Wali Murid Baru
                    </div>
                    <div style="font-size:12px; color:var(--em-300); margin-top:4px;">
                        Role otomatis diset sebagai <span class="badge badge--lunas"
                            style="font-size:10px;">wali_murid</span>
                    </div>
                </div>

                {{-- NAME --}}
                <div style="margin-bottom:18px;">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" wire:model="name" class="form-input" placeholder="Contoh: Bapak Ahmad Fauzi">
                    @error('name')
                        <span
                            style="font-size:11px; color:#fca5a5; margin-top:4px; display:block;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- EMAIL --}}
                <div style="margin-bottom:18px;">
                    <label class="form-label">Alamat Email</label>
                    <input type="email" wire:model="email" class="form-input" placeholder="contoh@email.com">
                    @error('email')
                        <span
                            style="font-size:11px; color:#fca5a5; margin-top:4px; display:block;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- PASSWORD --}}
                <div x-data="{ showPass: false }" style="margin-bottom:28px;">
                    <label class="form-label">Password</label>
                    <div style="position:relative;">
                        <input :type="showPass ? 'text' : 'password'" wire:model="password" class="form-input"
                            placeholder="Minimal 8 karakter" style="padding-right:44px;">
                        <button type="button" @click="showPass = !showPass"
                            style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:rgba(255,255,255,0.5); font-size:16px;">
                            <span x-show="!showPass">👁</span>
                            <span x-show="showPass">🙈</span>
                        </button>
                    </div>
                    @error('password')
                        <span
                            style="font-size:11px; color:#fca5a5; margin-top:4px; display:block;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- SUBMIT --}}
                <button wire:click="save" wire:loading.attr="disabled" class="btn btn--primary btn--full"
                    style="font-size:14px; padding:12px;">
                    <span wire:loading.remove wire:target="save">Simpan Akun</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>

            </div>
        </div>
    </div>

</div>
