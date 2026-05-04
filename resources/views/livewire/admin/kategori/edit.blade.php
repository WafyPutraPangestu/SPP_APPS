<div class="content">

    <div class="flex items-center gap-4">
        <a href="/admin/kategori" wire:navigate class="btn btn--ghost" style="padding:8px 14px; font-size:13px;">
            ← Kembali
        </a>
        <div>
            <h1 class="page-title">Edit Kategori SPP</h1>
            <p class="text-muted mt-1" style="font-size:13px;">Perbarui data {{ $kategori->tahun_ajaran }}</p>
        </div>
    </div>

    <div style="max-width:560px;">
        <div class="pay-card">
            <div style="position:relative; z-index:2;">

                <div style="display:flex; align-items:center; gap:14px; margin-bottom:28px;">
                    <div class="brand-icon" style="width:48px; height:48px; font-size:20px; margin-bottom:0;">📅</div>
                    <div>
                        <div style="font-family:var(--font-display); font-weight:700; font-size:18px; color:white;">
                            {{ $kategori->tahun_ajaran }}
                        </div>
                        <div style="font-size:11px; color:var(--em-300); font-family:var(--font-mono);">
                            Rp {{ number_format($kategori->nominal_spp, 0, ',', '.') }} / bulan
                        </div>
                    </div>
                </div>

                {{-- TAHUN AJARAN --}}
                <div style="margin-bottom:18px;">
                    <label class="form-label">Tahun Ajaran</label>
                    <input type="text" wire:model="tahun_ajaran" class="form-input" placeholder="Contoh: 2024/2025">
                    @error('tahun_ajaran')
                        <span
                            style="font-size:11px; color:#fca5a5; margin-top:4px; display:block;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- NOMINAL --}}
                <div style="margin-bottom:28px;">
                    <label class="form-label">Nominal SPP / Bulan</label>
                    <div style="position:relative;">
                        <span
                            style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:rgba(255,255,255,0.4); font-size:13px; font-family:var(--font-mono);">Rp</span>
                        <input type="number" wire:model="nominal_spp" class="form-input" placeholder="0"
                            style="padding-left:40px;" min="0">
                    </div>
                    @if (!empty($nominal_spp) && is_numeric($nominal_spp))
                        <div style="font-size:11px; color:var(--gd-300); margin-top:5px; font-family:var(--font-mono);">
                            = Rp {{ number_format((int) $nominal_spp, 0, ',', '.') }}
                        </div>
                    @endif
                    @error('nominal_spp')
                        <span
                            style="font-size:11px; color:#fca5a5; margin-top:4px; display:block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <a href="/admin/kategori" wire:navigate class="btn btn--ghost" style="flex:1; text-align:center;">
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
