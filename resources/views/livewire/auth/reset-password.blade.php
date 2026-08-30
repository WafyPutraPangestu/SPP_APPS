<div class="login-page" x-data="resetPage()" x-init="init()">

    {{-- ══════════════════════════════════════════
         CANVAS — Particle / Geometric Background
    ══════════════════════════════════════════ --}}
    <canvas id="bgCanvas" class="login-canvas"></canvas>

    {{-- ══════════════════════════════════════════
         MESH GRADIENT BLOBS
    ══════════════════════════════════════════ --}}
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>

    {{-- ══════════════════════════════════════════
         GEOMETRIC GRID OVERLAY
    ══════════════════════════════════════════ --}}
    <div class="geo-grid"></div>

    {{-- ══════════════════════════════════════════
         FLOATING ORNAMENTS
    ══════════════════════════════════════════ --}}
    <div class="ornament ornament-1">﷽</div>
    <div class="ornament ornament-2">◈</div>
    <div class="ornament ornament-3">✦</div>
    <div class="ornament ornament-4">◈</div>

    {{-- ══════════════════════════════════════════
         MAIN CARD
    ══════════════════════════════════════════ --}}
    <div class="login-wrapper" x-data="{ showPassword: false, showConfirm: false }">

        {{-- Glowing border ring --}}
        <div class="card-ring"></div>

        <div class="login-card" :class="cardVisible ? 'card-in' : ''">

            {{-- ── LOGO ── --}}
            <div class="logo-area">
                <div class="logo-ring-outer">
                    <div class="logo-ring-inner">
                        <div class="logo-icon">
                            <span class="logo-text">LT</span>
                        </div>
                    </div>
                </div>
                <div class="logo-glow"></div>
            </div>

            {{-- ── HEADING ── --}}
            <div class="heading-area">
                <h1 class="heading-main">
                    <span class="char-reveal" style="--d:0ms">R</span><span class="char-reveal"
                        style="--d:40ms">e</span><span class="char-reveal" style="--d:80ms">s</span><span
                        class="char-reveal" style="--d:120ms">e</span><span class="char-reveal"
                        style="--d:160ms">t</span><span class="char-reveal"
                        style="--d:200ms">&nbsp;</span><span class="char-reveal"
                        style="--d:240ms">P</span><span class="char-reveal"
                        style="--d:280ms">a</span><span class="char-reveal"
                        style="--d:320ms">s</span><span class="char-reveal"
                        style="--d:360ms">s</span><span class="char-reveal"
                        style="--d:400ms">w</span><span class="char-reveal"
                        style="--d:440ms">o</span><span class="char-reveal"
                        style="--d:480ms">r</span><span class="char-reveal"
                        style="--d:520ms">d</span>
                </h1>
                <p class="heading-sub">Masukkan password baru untuk akun Anda</p>
                <div class="heading-line"></div>
            </div>

            {{-- ── ERROR ── --}}
            @if (session()->has('error'))
                <div class="error-box" x-data="{ show: true }" x-show="show" x-transition>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 8v4m0 4h.01" />
                    </svg>
                    {{ session('error') }}
                    <button @click="show=false"
                        style="margin-left:auto;background:none;border:none;cursor:pointer;color:inherit;font-size:16px;line-height:1;">×</button>
                </div>
            @endif

            {{-- ── FORM ── --}}
            <form wire:submit.prevent="resetPassword" class="login-form">

                {{-- Email --}}
                <div class="field-group">
                    <label class="field-label">
                        <span class="field-label-icon">✉</span>
                        Alamat Email
                    </label>
                    <div class="field-wrap">
                        <input type="email" wire:model="email" class="field-input" placeholder="nama@email.com"
                            autocomplete="email">
                        <div class="field-border"></div>
                    </div>
                    @error('email')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password Baru --}}
                <div class="field-group">
                    <label class="field-label">
                        <span class="field-label-icon">🔒</span>
                        Password Baru
                    </label>
                    <div class="field-wrap">
                        <input :type="showPassword ? 'text' : 'password'" wire:model="password" class="field-input"
                            placeholder="Minimal 8 karakter" autocomplete="new-password">
                        <div class="field-border"></div>
                        <button type="button" @click="showPassword = !showPassword" class="eye-btn">
                            <svg x-show="!showPassword" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            <svg x-show="showPassword" x-cloak width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path
                                    d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24" />
                                <line x1="1" y1="1" x2="23" y2="23" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="field-group">
                    <label class="field-label">
                        <span class="field-label-icon">🔒</span>
                        Konfirmasi Password
                    </label>
                    <div class="field-wrap">
                        <input :type="showConfirm ? 'text' : 'password'" wire:model="password_confirmation"
                            class="field-input" placeholder="Ketik ulang password baru"
                            autocomplete="new-password">
                        <div class="field-border"></div>
                        <button type="button" @click="showConfirm = !showConfirm" class="eye-btn">
                            <svg x-show="!showConfirm" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            <svg x-show="showConfirm" x-cloak width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path
                                    d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24" />
                                <line x1="1" y1="1" x2="23" y2="23" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" wire:loading.attr="disabled" class="submit-btn"
                    @mouseenter="$el.style.setProperty('--mx', event.offsetX+'px'); $el.style.setProperty('--my', event.offsetY+'px')"
                    @mousemove="$el.style.setProperty('--mx', event.offsetX+'px'); $el.style.setProperty('--my', event.offsetY+'px')">
                    <span class="submit-ripple"></span>
                    <span wire:loading.remove wire:target="resetPassword" class="submit-text">
                        <span>Simpan Password Baru</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                    </span>
                    <span wire:loading wire:target="resetPassword" class="submit-text *:animate-pulse">
                        <div class="flex items-center gap-2">
                            <svg class="spin-icon" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5">
                                <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" opacity=".25" />
                                <path d="M21 12a9 9 0 00-9-9" />
                            </svg>
                            Menyimpan...
                        </div>
                    </span>
                </button>

            </form>

            {{-- ── FOOTER ── --}}
            <div class="card-footer">
                <a href="/login" wire:navigate class="back-link">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M19 12H5M12 5l-7 7 7 7" />
                    </svg>
                    Kembali ke Login
                </a>
            </div>

        </div>
    </div>

</div>

{{-- ══════════════════════════════════════════
     STYLES
══════════════════════════════════════════ --}}
<style>
    /* ── Page Shell ───────────────────────────────────── */
    .login-page {
        position: fixed;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--em-950);
        overflow: hidden;
        font-family: var(--font-body);
    }

    /* ── Canvas ───────────────────────────────────────── */
    .login-canvas {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        opacity: 0.35;
        pointer-events: none;
    }

    /* ── Animated mesh blobs ──────────────────────────── */
    .blob {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        pointer-events: none;
        will-change: transform;
    }

    .blob-1 {
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.25) 0%, transparent 70%);
        top: -200px;
        left: -200px;
        animation: blobFloat1 14s ease-in-out infinite;
    }

    .blob-2 {
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(245, 158, 11, 0.18) 0%, transparent 70%);
        bottom: -150px;
        right: -100px;
        animation: blobFloat2 18s ease-in-out infinite;
    }

    .blob-3 {
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(6, 95, 70, 0.3) 0%, transparent 70%);
        top: 40%;
        left: 55%;
        animation: blobFloat3 10s ease-in-out infinite;
    }

    @keyframes blobFloat1 {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(60px, 80px) scale(1.08); }
        66% { transform: translate(-40px, 40px) scale(0.95); }
    }

    @keyframes blobFloat2 {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(-80px, -60px) scale(1.1); }
    }

    @keyframes blobFloat3 {
        0%, 100% { transform: translate(0, 0) scale(1); }
        40% { transform: translate(40px, -50px) scale(1.15); }
        80% { transform: translate(-30px, 20px) scale(0.9); }
    }

    /* ── Geometric grid ───────────────────────────────── */
    .geo-grid {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(16, 185, 129, 0.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(16, 185, 129, 0.04) 1px, transparent 1px);
        background-size: 48px 48px;
        mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 20%, transparent 100%);
        pointer-events: none;
    }

    /* ── Floating ornaments ───────────────────────────── */
    .ornament {
        position: absolute;
        color: rgba(16, 185, 129, 0.12);
        pointer-events: none;
        user-select: none;
        font-family: var(--font-display);
    }

    .ornament-1 { font-size: 11px; letter-spacing: 1px; top: 8%; left: 6%; color: rgba(245, 158, 11, 0.15); animation: ornFloat 20s ease-in-out infinite; }
    .ornament-2 { font-size: 48px; top: 15%; right: 8%; animation: ornFloat 15s ease-in-out infinite reverse; }
    .ornament-3 { font-size: 28px; bottom: 20%; left: 10%; color: rgba(245, 158, 11, 0.12); animation: ornFloat 12s ease-in-out infinite 2s; }
    .ornament-4 { font-size: 36px; bottom: 12%; right: 14%; animation: ornFloat 17s ease-in-out infinite 1s; }

    @keyframes ornFloat {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(15deg); }
    }

    /* ── Wrapper & card ring ──────────────────────────── */
    .login-wrapper {
        position: relative;
        z-index: 10;
        width: 100%;
        max-width: 460px;
        padding: 0 16px;
    }

    .card-ring {
        position: absolute;
        inset: -2px;
        border-radius: 28px;
        background: conic-gradient(from 0deg,
                transparent 0deg,
                rgba(16, 185, 129, 0.6) 60deg,
                rgba(245, 158, 11, 0.6) 120deg,
                transparent 180deg,
                transparent 360deg);
        animation: ringRotate 6s linear infinite;
        filter: blur(2px);
        z-index: -1;
    }

    @keyframes ringRotate { to { transform: rotate(360deg); } }

    /* ── Card ─────────────────────────────────────────── */
    .login-card {
        background: rgba(2, 44, 34, 0.75);
        backdrop-filter: blur(28px) saturate(1.4);
        -webkit-backdrop-filter: blur(28px) saturate(1.4);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 26px;
        padding: 40px 36px;
        position: relative;
        overflow: hidden;
        opacity: 0;
        transform: translateY(32px) scale(0.97);
        transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1),
            transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .login-card.card-in {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    .login-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.04) 0%, transparent 50%, rgba(16, 185, 129, 0.03) 100%);
        pointer-events: none;
        border-radius: inherit;
    }

    /* ── Logo ─────────────────────────────────────────── */
    .logo-area { display: flex; align-items: center; justify-content: center; margin-bottom: 24px; position: relative; }
    .logo-glow { position: absolute; width: 80px; height: 80px; background: radial-gradient(circle, rgba(245, 158, 11, 0.35) 0%, transparent 70%); border-radius: 50%; animation: logoGlowPulse 3s ease-in-out infinite; }
    @keyframes logoGlowPulse { 0%, 100% { transform: scale(1); opacity: 1; } 50% { transform: scale(1.3); opacity: 0.6; } }
    .logo-ring-outer { width: 72px; height: 72px; border-radius: 20px; background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(16, 185, 129, 0.3)); padding: 2px; animation: logoRingSpin 8s linear infinite; position: relative; z-index: 1; }
    @keyframes logoRingSpin { 0% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4); } 50% { box-shadow: 0 0 24px 6px rgba(245, 158, 11, 0.2); } 100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4); } }
    .logo-ring-inner { width: 100%; height: 100%; border-radius: 18px; background: var(--em-950); display: flex; align-items: center; justify-content: center; }
    .logo-icon { width: 52px; height: 52px; border-radius: 14px; background: linear-gradient(135deg, var(--gd-400), var(--gd-500)); display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 24px rgba(245, 158, 11, 0.35); }
    .logo-text { font-family: var(--font-display); font-weight: 900; font-size: 20px; color: var(--em-950); letter-spacing: -1px; }

    /* ── Heading ──────────────────────────────────────── */
    .heading-area { text-align: center; margin-bottom: 28px; }
    .heading-main { font-family: var(--font-display); font-weight: 900; font-size: 28px; color: white; letter-spacing: -0.5px; margin-bottom: 6px; display: flex; justify-content: center; gap: 0; }
    .char-reveal { display: inline-block; opacity: 0; transform: translateY(20px); animation: charIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; animation-delay: calc(var(--d) + 400ms); }
    @keyframes charIn { to { opacity: 1; transform: translateY(0); } }
    .heading-sub { font-size: 12.5px; color: var(--em-300); letter-spacing: 0.3px; opacity: 0; animation: fadeUp 0.6s ease forwards 1.2s; }
    .heading-line { width: 40px; height: 2px; background: linear-gradient(90deg, var(--gd-400), var(--em-500)); border-radius: 2px; margin: 12px auto 0; opacity: 0; animation: lineExpand 0.5s ease forwards 1.4s; transform-origin: center; transform: scaleX(0); }
    @keyframes lineExpand { to { opacity: 1; transform: scaleX(1); } }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }

    /* ── Error box ────────────────────────────────────── */
    .error-box {
        display: flex;
        align-items: center;
        gap: 10px;
        background: rgba(220, 38, 38, 0.1);
        border: 1px solid rgba(220, 38, 38, 0.3);
        border-radius: var(--r-md);
        padding: 12px 14px;
        font-size: 13px;
        color: #fca5a5;
        margin-bottom: 20px;
    }

    /* ── Form ─────────────────────────────────────────── */
    .login-form { display: flex; flex-direction: column; gap: 20px; }
    .field-group { display: flex; flex-direction: column; gap: 6px; }
    .field-label { font-size: 11px; font-weight: 600; letter-spacing: 1.2px; text-transform: uppercase; color: var(--em-300); display: flex; align-items: center; gap: 6px; }
    .field-label-icon { font-size: 13px; }
    .field-wrap { position: relative; }
    .field-input { width: 100%; background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--r-sm); padding: 12px 16px; color: white; font-family: var(--font-body); font-size: 14px; outline: none; transition: background 0.2s, border-color 0.2s, box-shadow 0.2s; position: relative; z-index: 1; }
    .field-input::placeholder { color: rgba(255, 255, 255, 0.22); }
    .field-input:focus { background: rgba(16, 185, 129, 0.08); border-color: rgba(16, 185, 129, 0.45); box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1), 0 0 16px rgba(16, 185, 129, 0.08); }
    .field-border { position: absolute; bottom: 0; left: 16px; right: 16px; height: 1px; background: linear-gradient(90deg, var(--em-500), var(--gd-400)); transform: scaleX(0); transform-origin: left; transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1); border-radius: 1px; z-index: 2; }
    .field-input:focus~.field-border { transform: scaleX(1); }
    .field-error { font-size: 11.5px; color: #fca5a5; display: block; margin-top: 2px; }

    .eye-btn { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: rgba(255, 255, 255, 0.35); cursor: pointer; padding: 4px; border-radius: 6px; transition: color 0.15s, background 0.15s; z-index: 2; display: flex; align-items: center; justify-content: center; }
    .eye-btn:hover { color: var(--em-300); background: rgba(255, 255, 255, 0.06); }

    /* ── Submit button ────────────────────────────────── */
    .submit-btn { position: relative; width: 100%; padding: 14px 24px; border: none; border-radius: var(--r-md); background: linear-gradient(135deg, var(--gd-400), var(--gd-500)); color: var(--em-950); font-family: var(--font-body); font-size: 14px; font-weight: 700; cursor: pointer; overflow: hidden; transition: transform 0.15s, box-shadow 0.2s, opacity 0.15s; box-shadow: 0 4px 20px rgba(245, 158, 11, 0.35); margin-top: 4px; }
    .submit-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 32px rgba(245, 158, 11, 0.45); }
    .submit-btn:active { transform: translateY(0) scale(0.98); }
    .submit-btn:disabled { opacity: 0.65; cursor: not-allowed; transform: none; }
    .submit-ripple { position: absolute; width: 200px; height: 200px; border-radius: 50%; background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 60%); top: calc(var(--my, 50%) - 100px); left: calc(var(--mx, 50%) - 100px); pointer-events: none; opacity: 0; transition: opacity 0.3s; }
    .submit-btn:hover .submit-ripple { opacity: 1; }
    .submit-text { display: flex; align-items: center; justify-content: center; gap: 8px; position: relative; z-index: 1; }
    .spin-icon { animation: spinAnim 0.8s linear infinite; }
    @keyframes spinAnim { to { transform: rotate(360deg); } }

    /* ── Footer ───────────────────────────────────────── */
    .card-footer { margin-top: 24px; text-align: center; }
    .back-link { display: inline-flex; align-items: center; gap: 6px; font-size: 12.5px; color: rgba(255, 255, 255, 0.3); text-decoration: none; transition: color 0.2s; font-weight: 500; }
    .back-link:hover { color: var(--em-300); }

    /* ── Responsive ───────────────────────────────────── */
    @media (max-width: 480px) {
        .login-card { padding: 28px 20px; }
        .heading-main { font-size: 22px; }
        .ornament-1, .ornament-4 { display: none; }
    }
</style>

{{-- ══════════════════════════════════════════
     SCRIPTS
══════════════════════════════════════════ --}}
<script>
    function resetPage() {
        return {
            cardVisible: false,
            init() {
                requestAnimationFrame(() => {
                    setTimeout(() => {
                        this.cardVisible = true;
                    }, 80);
                });
                this.$nextTick(() => initCanvas());
            }
        };
    }

    function initCanvas() {
        const canvas = document.getElementById('bgCanvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');

        let W, H, particles, mouse = { x: -999, y: -999 };

        function resize() {
            W = canvas.width = window.innerWidth;
            H = canvas.height = window.innerHeight;
        }

        function makeParticle() {
            const angle = Math.random() * Math.PI * 2;
            return {
                x: Math.random() * W,
                y: Math.random() * H,
                r: Math.random() * 1.8 + 0.4,
                vx: Math.cos(angle) * (Math.random() * 0.3 + 0.05),
                vy: Math.sin(angle) * (Math.random() * 0.3 + 0.05),
                color: Math.random() > 0.6 ?
                    `rgba(245,158,11,${Math.random() * 0.5 + 0.2})` : `rgba(16,185,129,${Math.random() * 0.4 + 0.15})`,
                life: Math.random(),
                lifeSpeed: Math.random() * 0.003 + 0.001,
            };
        }

        function init() {
            resize();
            particles = Array.from({ length: 120 }, makeParticle);
        }

        function draw() {
            ctx.clearRect(0, 0, W, H);
            for (let i = 0; i < particles.length; i++) {
                for (let j = i + 1; j < particles.length; j++) {
                    const dx = particles[i].x - particles[j].x;
                    const dy = particles[i].y - particles[j].y;
                    const dist = Math.sqrt(dx * dx + dy * dy);
                    if (dist < 110) {
                        ctx.beginPath();
                        ctx.strokeStyle = `rgba(16,185,129,${(1 - dist / 110) * 0.12})`;
                        ctx.lineWidth = 0.5;
                        ctx.moveTo(particles[i].x, particles[i].y);
                        ctx.lineTo(particles[j].x, particles[j].y);
                        ctx.stroke();
                    }
                }
                const mdx = particles[i].x - mouse.x;
                const mdy = particles[i].y - mouse.y;
                const mdist = Math.sqrt(mdx * mdx + mdy * mdy);
                if (mdist < 150) {
                    ctx.beginPath();
                    ctx.strokeStyle = `rgba(245,158,11,${(1 - mdist / 150) * 0.3})`;
                    ctx.lineWidth = 0.8;
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(mouse.x, mouse.y);
                    ctx.stroke();
                }
            }
            particles.forEach(p => {
                p.life += p.lifeSpeed;
                if (p.life > 1) p.life = 0;
                const alpha = Math.sin(p.life * Math.PI);
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fillStyle = p.color.replace(/[\d.]+\)$/, `${alpha})`);
                ctx.fill();
                const dx = p.x - mouse.x;
                const dy = p.y - mouse.y;
                const d = Math.sqrt(dx * dx + dy * dy);
                if (d < 100) {
                    p.vx += (dx / d) * 0.08;
                    p.vy += (dy / d) * 0.08;
                }
                p.vx *= 0.99;
                p.vy *= 0.99;
                p.x += p.vx;
                p.y += p.vy;
                if (p.x < 0) p.x = W;
                if (p.x > W) p.x = 0;
                if (p.y < 0) p.y = H;
                if (p.y > H) p.y = 0;
            });
            requestAnimationFrame(draw);
        }

        window.addEventListener('resize', () => { resize(); });
        window.addEventListener('mousemove', e => { mouse.x = e.clientX; mouse.y = e.clientY; });
        window.addEventListener('mouseleave', () => { mouse.x = -999; mouse.y = -999; });

        init();
        draw();
    }
</script>
