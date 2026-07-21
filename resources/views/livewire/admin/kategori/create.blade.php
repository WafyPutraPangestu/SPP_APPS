<div class="content">

    <div class="flex items-center gap-4">
        <a href="/admin/kategori" wire:navigate class="btn btn--ghost" style="padding:8px 14px; font-size:13px;">
            ← Kembali
        </a>
        <div>
            <h1 class="page-title">Tambah Kategori SPP</h1>
            <p class="text-muted mt-1" style="font-size:13px;">Buat kategori tahun ajaran dan nominal baru</p>
        </div>
    </div>

    <div style="max-width:560px;">
        <div class="pay-card">
            <div style="position:relative; z-index:2;">

                <div style="margin-bottom:28px;">
                    <div class="brand-icon" style="width:40px; height:40px; font-size:18px; margin-bottom:12px;">📅
                    </div>
                    <div style="font-family:var(--font-display); font-weight:700; font-size:20px; color:white;">
                        Kategori SPP Baru
                    </div>
                    <div style="font-size:12px; color:var(--em-300); margin-top:4px;">
                        Nominal akan digunakan sebagai acuan tagihan bulanan
                    </div>
                </div>

                {{-- TAHUN AJARAN --}}
                <div style="margin-bottom:18px;">
                    <label class="form-label">Tagihan & Tahun Ajaran</label>
                    <input type="text" wire:model="tahun_ajaran" class="form-input"
                        placeholder="Contoh: SPP (2024/2025)">
                    @error('tahun_ajaran')
                        <span
                            style="font-size:11px; color:#fca5a5; margin-top:4px; display:block;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- NOMINAL --}}
                <div x-data="{ displayVal: '' }" style="margin-bottom:28px;">
                    <label class="form-label">Nominal SPP / Bulan</label>
                    <div style="position:relative;">
                        <span
                            style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:rgba(255,255,255,0.4); font-size:13px; font-family:var(--font-mono);">Rp</span>
                        <input id="nominal_spp" type="text" wire:model="nominal_spp" class="form-input"
                            placeholder="0" style="padding-left:40px;" min="0">
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

                <button wire:click="save" wire:loading.attr="disabled" class="btn btn--primary btn--full"
                    style="font-size:14px; padding:12px;">
                    <span wire:loading.remove wire:target="save">Simpan Kategori</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>

            </div>
        </div>
    </div>

</div>
<script>
    const inputSpp = document.getElementById('nominal_spp');

    inputSpp.addEventListener('input', function(e) {
        // 1. Hapus semua karakter yang bukan angka (termasuk titik yang sudah ada)
        let rawValue = this.value.replace(/[^0-9]/g, '');

        // 2. Format kembali menjadi format ribuan standar Indonesia (id-ID)
        if (rawValue !== '') {
            this.value = parseInt(rawValue, 10).toLocaleString('id-ID');
        } else {
            this.value = '';
        }
    });
</script>
