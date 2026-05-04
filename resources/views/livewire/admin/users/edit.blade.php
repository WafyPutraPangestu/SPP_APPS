<div class="content">

    {{-- HEADER --}}
    <div class="flex items-center gap-4">
        <a href="/admin/users" wire:navigate class="btn btn--ghost" style="padding:8px 14px; font-size:13px;">
            ← Kembali
        </a>
        <div>
            <h1 class="page-title">Edit Wali Murid</h1>
            <p class="text-muted mt-1" style="font-size:13px;">Perbarui data akun {{ $user->name }}</p>
        </div>
    </div>

    {{-- FORM --}}
    <div style="max-width:600px;">
        <div class="pay-card">
            <div style="position:relative; z-index:2;">

                {{-- Avatar preview --}}
                <div style="display:flex; align-items:center; gap:14px; margin-bottom:28px;">
                    <div class="avatar" style="width:52px; height:52px; font-size:18px; font-weight:700;">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <div>
                        <div style="font-family:var(--font-display); font-weight:700; font-size:18px; color:white;">
                            {{ $user->name }}
                        </div>
                        <div style="font-size:11px; color:var(--em-300);">{{ $user->email }}</div>
                    </div>
                </div>

                {{-- NAME --}}
                <div style="margin-bottom:18px;">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" wire:model="name" class="form-input" placeholder="Nama lengkap">
                    @error('name')
                        <span
                            style="font-size:11px; color:#fca5a5; margin-top:4px; display:block;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- EMAIL --}}
                <div style="margin-bottom:18px;">
                    <label class="form-label">Alamat Email</label>
                    <input type="email" wire:model="email" class="form-input" placeholder="Alamat email">
                    @error('email')
                        <span
                            style="font-size:11px; color:#fca5a5; margin-top:4px; display:block;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- PASSWORD --}}
                <div x-data="{ showPass: false }" style="margin-bottom:8px;">
                    <label class="form-label">Password Baru <span
                            style="font-weight:400; opacity:0.6;">(opsional)</span></label>
                    <div style="position:relative;">
                        <input :type="showPass ? 'text' : 'password'" wire:model="password" class="form-input"
                            placeholder="Kosongkan jika tidak ingin diubah" style="padding-right:44px;">
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

                <p style="font-size:11px; color:rgba(255,255,255,0.35); margin-bottom:28px;">
                    Biarkan kosong apabila tidak ingin mengubah password.
                </p>

                {{-- ACTIONS --}}
                <div class="flex gap-3">
                    <a href="/admin/users" wire:navigate class="btn btn--ghost" style="flex:1; text-align:center;">
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
