<div>

    {{-- Style tambahan khusus halaman ini (tidak mengubah app.css global) --}}
    <style>
        .tagihan-wrap {
            max-width: 1180px;
            margin: 0 auto;
            width: 100%;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 28px;
        }

        @media (max-width: 560px) {
            .detail-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }
        }

        .pay-card-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 28px;
            flex-wrap: wrap;
        }

        .top-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
            align-items: start;
        }

        @media (max-width: 1024px) {
            .top-grid {
                grid-template-columns: 1fr;
            }
        }

        .table-scroll {
            overflow-x: auto;
        }

        .table-scroll table {
            min-width: 640px;
        }

        .action-col {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .metode-chip {
            padding: 4px 10px;
            border-radius: var(--r-pill);
            background: var(--surface);
            border: 1px solid rgba(0, 0, 0, 0.1);
            font-size: 11.5px;
            font-weight: 500;
            color: var(--ink-muted);
        }
    </style>

    <div style="display: flex; flex-direction: column; min-height: 100vh; background: var(--surface);">

        {{-- TOPBAR --}}
        <header class="topbar">
            <div style="display: flex; align-items: center; gap: 14px;">
                <a href="{{ route('wali-murid.tagihan.index') }}"
                    style="width: 36px; height: 36px; border-radius: var(--r-sm); background: var(--surface);
                          border: 1px solid rgba(0,0,0,0.1); display: flex; align-items: center;
                          justify-content: center; text-decoration: none; color: var(--ink); font-size: 18px;
                          transition: background 0.15s; flex-shrink: 0;"
                    onmouseover="this.style.background='var(--em-100)'"
                    onmouseout="this.style.background='var(--surface)'">
                    ←
                </a>
                <div>
                    <div class="label-caps">Detail Tagihan</div>
                    <h1 class="page-title" style="margin-top: 2px;">
                        {{ $tagihan->bulan }} {{ $tagihan->tahun }}
                    </h1>
                </div>
            </div>
            <div class="topbar-right">
                <div style="text-align: right;">
                    <div style="font-size: 13px; font-weight: 600; color: var(--ink);">{{ Auth::user()->name }}</div>
                    <div class="label-caps" style="color: var(--em-700);">Wali Murid</div>
                </div>
                <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
            </div>
        </header>

        <main class="content">
            <div class="tagihan-wrap" style="display: flex; flex-direction: column; gap: 24px;">

                @php
                    $isLunas = $tagihan->status_tagihan === 'Lunas';
                    $lastPembayaran = $tagihan->pembayaran->sortByDesc('created_at')->first();
                @endphp

                {{-- ── TOP GRID: Detail + Aksi ─────────────── --}}
                <div class="top-grid">

                    {{-- KARTU DETAIL TAGIHAN (dark) --}}
                    <div class="pay-card">
                        <div style="position: relative; z-index: 2;">

                            {{-- SISWA + STATUS BADGE dalam satu baris flex, tidak overlap lagi --}}
                            <div class="pay-card-head">
                                <div class="santri-info">
                                    <div
                                        style="width: 52px; height: 52px; border-radius: 14px;
                                                background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.25);
                                                display: flex; align-items: center; justify-content: center;
                                                font-size: 18px; font-weight: 700; color: var(--em-300); flex-shrink: 0;">
                                        {{ strtoupper(substr($tagihan->siswa->nama_siswa, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div
                                            style="font-family: var(--font-display); font-weight: 700; font-size: 20px;
                                                    color: white; letter-spacing: -0.3px;">
                                            {{ $tagihan->siswa->nama_siswa }}
                                        </div>
                                        <div
                                            style="font-family: var(--font-mono); font-size: 12px; color: var(--em-300); margin-top: 2px;">
                                            NIS: {{ $tagihan->siswa->nis }} &nbsp;·&nbsp; Kelas
                                            {{ $tagihan->siswa->kelas }}
                                        </div>
                                    </div>
                                </div>

                                <span class="badge {{ $isLunas ? 'badge--lunas' : 'badge--pending' }}"
                                    style="flex-shrink: 0; {{ $isLunas
                                        ? 'background: rgba(16,185,129,0.2); color: var(--em-300); border: 1px solid rgba(16,185,129,0.3);'
                                        : 'background: rgba(245,158,11,0.2); color: var(--gd-300); border: 1px solid rgba(245,158,11,0.3);' }}">
                                    {{ $tagihan->status_tagihan }}
                                </span>
                            </div>

                            {{-- DETAIL GRID (responsive) --}}
                            <div class="detail-grid">

                                <div>
                                    <div class="label-caps" style="color: var(--em-300); margin-bottom: 4px;">Bulan
                                    </div>
                                    <div
                                        style="font-family: var(--font-display); font-size: 22px; font-weight: 700;
                                                color: white; letter-spacing: -0.5px;">
                                        {{ $tagihan->bulan }}
                                    </div>
                                </div>

                                <div>
                                    <div class="label-caps" style="color: var(--em-300); margin-bottom: 4px;">Tahun
                                    </div>
                                    <div
                                        style="font-family: var(--font-display); font-size: 22px; font-weight: 700;
                                                color: white; letter-spacing: -0.5px;">
                                        {{ $tagihan->tahun }}
                                    </div>
                                </div>

                                <div>
                                    <div class="label-caps" style="color: var(--em-300); margin-bottom: 4px;">Tahun
                                        Ajaran
                                    </div>
                                    <div style="font-size: 14px; color: rgba(255,255,255,0.75);">
                                        {{ $tagihan->kategori_spp->tahun_ajaran }}
                                    </div>
                                </div>

                                <div>
                                    <div class="label-caps" style="color: var(--em-300); margin-bottom: 4px;">Nominal
                                        SPP
                                    </div>
                                    <div class="amount"
                                        style="font-size: 18px; color: var(--gd-300); font-weight: 600;">
                                        Rp {{ number_format($tagihan->kategori_spp->nominal_spp, 0, ',', '.') }}
                                    </div>
                                </div>

                            </div>

                            {{-- DIVIDER --}}
                            <div style="height: 1px; background: rgba(255,255,255,0.08); margin-bottom: 20px;"></div>

                            {{-- ID TAGIHAN --}}
                            <div
                                style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                                <div>
                                    <div class="label-caps" style="color: var(--em-300); margin-bottom: 3px;">ID Tagihan
                                    </div>
                                    <div class="amount" style="font-size: 12px; color: rgba(255,255,255,0.4);">
                                        #{{ str_pad($tagihan->id_tagihan, 6, '0', STR_PAD_LEFT) }}
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <div class="label-caps" style="color: var(--em-300); margin-bottom: 3px;">Dibuat
                                    </div>
                                    <div style="font-size: 12px; color: rgba(255,255,255,0.4);">
                                        {{ $tagihan->created_at->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- PANEL AKSI PEMBAYARAN --}}
                    <div class="action-col">

                        {{-- CARD BAYAR --}}
                        <div class="mini-card">
                            <div class="mini-card__accent"></div>

                            <div style="padding-left: 8px;">
                                <div class="section-title" style="margin-bottom: 6px;">Pembayaran</div>
                                <div
                                    style="font-size: 12.5px; color: var(--ink-muted); margin-bottom: 20px; line-height: 1.6;">
                                    Lakukan pembayaran SPP secara online melalui berbagai metode yang tersedia.
                                </div>

                                {{-- Nominal besar --}}
                                <div
                                    style="background: var(--surface); border-radius: var(--r-md);
                                            padding: 16px; text-align: center; margin-bottom: 20px;
                                            border: 1px solid rgba(0,0,0,0.06);">
                                    <div class="label-caps" style="margin-bottom: 6px;">Total Tagihan</div>
                                    <div class="amount"
                                        style="font-size: 26px; font-weight: 600;
                                         color: {{ $isLunas ? 'var(--em-700)' : 'var(--gd-700)' }};">
                                        Rp {{ number_format($tagihan->kategori_spp->nominal_spp, 0, ',', '.') }}
                                    </div>
                                </div>

                                {{-- Error message --}}
                                @if ($errorMsg)
                                    <div
                                        style="background: rgba(220,38,38,0.08); border: 1px solid rgba(220,38,38,0.2);
                                                border-radius: var(--r-sm); padding: 10px 14px; margin-bottom: 14px;
                                                font-size: 12.5px; color: #991b1b;">
                                        ⚠️ {{ $errorMsg }}
                                    </div>
                                @endif

                                @if ($isLunas)
                                    <div
                                        style="background: rgba(6,95,70,0.06); border: 1px solid rgba(6,95,70,0.2);
                                                border-radius: var(--r-md); padding: 16px; text-align: center;">
                                        <div style="font-size: 28px; margin-bottom: 8px;">✅</div>
                                        <div style="font-weight: 600; color: var(--em-800); font-size: 14px;">
                                            Tagihan Sudah Lunas
                                        </div>
                                        <div style="font-size: 12px; color: var(--em-700); margin-top: 4px;">
                                            Terima kasih atas pembayaran Anda
                                        </div>
                                    </div>
                                @else
                                    <button wire:click="bayar" wire:loading.attr="disabled"
                                        wire:loading.class="opacity-60 cursor-not-allowed"
                                        class="btn btn--primary btn--full"
                                        style="font-size: 14px; padding: 14px; box-shadow: 0 4px 20px rgba(245,158,11,0.3);">
                                        <span wire:loading.remove wire:target="bayar">💳 Bayar Sekarang</span>
                                        <span wire:loading wire:target="bayar">⏳ Memproses...</span>
                                    </button>

                                    <p
                                        style="font-size: 11px; color: var(--ink-faint); text-align: center; margin-top: 10px;">
                                        🔒 Pembayaran aman via Midtrans
                                    </p>
                                @endif
                            </div>
                        </div>

                        {{-- METODE PEMBAYARAN TERSEDIA --}}
                        @if (!$isLunas)
                            <div class="mini-card">
                                <div class="mini-card__accent"
                                    style="background: linear-gradient(180deg, #3b82f6, #1e40af);"></div>
                                <div style="padding-left: 8px;">
                                    <div class="label-caps" style="margin-bottom: 10px;">Metode Tersedia</div>
                                    <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                                        @foreach (['QRIS', 'Transfer', 'E-Wallet', 'Kartu Kredit'] as $m)
                                            <span class="metode-chip">{{ $m }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

                {{-- ── RIWAYAT PEMBAYARAN ───────────────────── --}}
                @if ($tagihan->pembayaran->isNotEmpty())
                    <div>
                        <div class="section-title" style="margin-bottom: 14px;">Riwayat Transaksi</div>

                        <div class="table-card">
                            <div class="table-scroll">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Jumlah</th>
                                            <th>Metode</th>
                                            <th>Status</th>
                                            <th>Waktu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tagihan->pembayaran->sortByDesc('created_at') as $p)
                                            @php
                                                $statusMap = [
                                                    'settlement' => ['badge--lunas', 'Berhasil'],
                                                    'pending' => ['badge--pending', 'Pending'],
                                                    'expire' => ['badge--telat', 'Kadaluarsa'],
                                                    'cancel' => ['badge--telat', 'Dibatalkan'],
                                                    'deny' => ['badge--telat', 'Ditolak'],
                                                ];
                                                [$badgeClass, $label] = $statusMap[$p->status_pembayaran] ?? [
                                                    'badge--info',
                                                    ucfirst($p->status_pembayaran),
                                                ];
                                            @endphp
                                            <tr>
                                                <td>
                                                    <span class="amount"
                                                        style="font-size: 12px; color: var(--ink-muted);">
                                                        {{ $p->order_id }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="amount" style="font-weight: 600;">
                                                        Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span style="font-size: 13px; color: var(--ink-muted);">
                                                        {{ $p->metode_bayar ?? '—' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge {{ $badgeClass }}">{{ $label }}</span>
                                                </td>
                                                <td style="white-space: nowrap;">
                                                    <div style="font-size: 12px; color: var(--ink-muted);">
                                                        {{ $p->waktu_pembayaran ? $p->waktu_pembayaran->format('d M Y, H:i') : $p->created_at->format('d M Y, H:i') }}
                                                    </div>
                                                    @if ($p->status_pembayaran === 'settlement')
                                                        <a href="{{ route('wali-murid.pembayaran.invoice', $p->id_pembayaran) }}"
                                                            target="_blank"
                                                            style="font-size: 11px; font-weight: 600; color: var(--em-700); text-decoration: underline; display: inline-flex; align-items: center; gap: 4px; margin-top: 2px;">
                                                            🖨️ Cetak Resi
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </main>
    </div>

</div>

{{-- ═══════════════════════════════════════════
     MIDTRANS SNAP INTEGRATION
════════════════════════════════════════════ --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
</script>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('open-snap', ({
            token
        }) => {
            window.snap.pay(token, {
                onSuccess: function(result) {
                    // Refresh status tagihan setelah berhasil
                    @this.call('refreshStatus');
                    showNotif('✅ Pembayaran berhasil! Terima kasih.', 'success');
                },
                onPending: function(result) {
                    @this.call('refreshStatus');
                    showNotif('⏳ Menunggu konfirmasi pembayaran.', 'pending');
                },
                onError: function(result) {
                    showNotif('❌ Pembayaran gagal. Silakan coba lagi.', 'error');
                },
                onClose: function() {
                    // User menutup popup tanpa selesai
                }
            });
        });
    });

    function showNotif(msg, type) {
        const el = document.createElement('div');
        const colors = {
            success: {
                bg: 'rgba(6,95,70,0.95)',
                border: 'var(--em-700)'
            },
            pending: {
                bg: 'rgba(120,85,15,0.95)',
                border: 'var(--gd-500)'
            },
            error: {
                bg: 'rgba(153,27,27,0.95)',
                border: '#dc2626'
            },
        };
        const c = colors[type] || colors.pending;
        el.style.cssText = `
            position: fixed; top: 24px; right: 24px; z-index: 9999;
            background: ${c.bg}; border: 1px solid ${c.border};
            border-radius: 12px; padding: 14px 20px;
            color: white; font-family: var(--font-body); font-size: 14px;
            font-weight: 500; box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            animation: slideIn 0.3s ease; max-width: 320px;
        `;
        el.textContent = msg;
        document.body.appendChild(el);
        setTimeout(() => {
            el.style.opacity = '0';
            el.style.transition = 'opacity 0.4s';
            setTimeout(() => el.remove(), 400);
        }, 4000);
    }
</script>

<style>
    @keyframes slideIn {
        from {
            transform: translateX(20px);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>
