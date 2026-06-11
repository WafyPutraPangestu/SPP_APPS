<nav x-data="{
    mobileOpen: false,
    scrolled: false,
    role: '{{ Auth::check() ? Auth::user()->role : 'guest' }}'
}" x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 10)" :class="scrolled ? 'shadow-lg' : ''"
    style="position: sticky; top: 0; z-index: 100; background: var(--em-950);
        border-bottom: 1px solid rgba(16,185,129,0.12); transition: box-shadow 0.3s;">

    {{-- ── Ambient top line ── --}}
    <div
        style="height: 2px; background: linear-gradient(90deg, var(--em-700), var(--gd-400), var(--em-700));
            opacity: 0.7;">
    </div>

    <div style="max-width: 1280px; margin: 0 auto; padding: 0 24px;">
        <div style="display: flex; align-items: center; justify-content: space-between; height: 64px;">

            {{-- ══ BRAND ══ --}}
            <a href="/" wire:navigate
                style="display: flex; align-items: center; gap: 10px; text-decoration: none; flex-shrink: 0;">
                <div
                    style="width: 36px; height: 36px; border-radius: 10px;
                        background: linear-gradient(135deg, var(--gd-400), var(--gd-500));
                        display: flex; align-items: center; justify-content: center; font-size: 18px;
                        box-shadow: 0 0 0 1px rgba(245,158,11,0.3), 0 4px 12px rgba(245,158,11,0.2);">
                    🕌
                </div>
                <div>
                    <div
                        style="font-family: var(--font-display); font-weight: 900; font-size: 15px;
                            color: white; letter-spacing: -0.3px; line-height: 1.1;">
                        La-Taksal
                    </div>
                    <div
                        style="font-size: 9px; color: var(--em-300); letter-spacing: 1.8px;
                            text-transform: uppercase; font-weight: 500; margin-top: 1px;">
                        Sistem SPP
                    </div>
                </div>
            </a>

            {{-- ══ DESKTOP NAV ══ --}}
            <ul style="display: flex; align-items: center; gap: 2px; list-style: none;
                   margin: 0; padding: 0;"
                class="hidden-mobile">

                @guest
                    <li>
                        <a href="/" wire:navigate class="nav-link {{ request()->is('/') ? 'nav-link--active' : '' }}">
                            Beranda
                        </a>
                    </li>
                @endguest

                @auth
                    @if (Auth::user()->role === 'admin')
                        <li>
                            <a href="{{ route('admin.dashboard.index') }}"
                                class="nav-link {{ request()->routeIs('admin.dashboard.*') ? 'nav-link--active' : '' }}">
                                Dashboard
                            </a>
                        </li>
                        <li x-data="{ open: false }" style="position: relative;">
                            <button @click="open = !open" @click.outside="open = false" class="nav-link nav-link--dropdown"
                                :class="open ? 'nav-link--active' : ''">
                                Manajemen
                                <svg x-bind:style="open ? 'transform:rotate(180deg)' : ''"
                                    style="width: 12px; height: 12px; color: #FFFF; transition: transform 0.2s; margin-left: 4px;"
                                    viewBox="0 0 12 12" fill="none">
                                    <path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" style="color: #FFFF;" />
                                </svg>
                            </button>
                            <div x-show="open" x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                                style="position: absolute; top: calc(100% + 8px); left: 50%;
                                    transform: translateX(-50%); width: 200px;
                                    background: var(--em-900); border: 1px solid rgba(16,185,129,0.2);
                                    border-radius: var(--r-md); padding: 6px;
                                    box-shadow: 0 16px 48px rgba(0,0,0,0.4);">
                                @foreach ([['route' => 'admin.users.index', 'icon' => '👥', 'label' => 'Manajemen Users'], ['route' => 'admin.siswa.index', 'icon' => '🎓', 'label' => 'Manajemen Siswa'], ['route' => 'admin.kategori.index', 'icon' => '🏷️', 'label' => 'Kategori SPP'], ['route' => 'admin.tagihan.index', 'icon' => '📋', 'label' => 'Tagihan']] as $item)
                                    <a href="{{ route($item['route']) }}"
                                        class="dropdown-item {{ request()->routeIs($item['route']) ? 'dropdown-item--active' : '' }}">
                                        <span style="font-size: 14px;">{{ $item['icon'] }}</span>
                                        {{ $item['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        </li>
                    @endif

                    @if (Auth::user()->role === 'wali_murid')
                        <li>
                            <a href="{{ route('wali-murid.dashboard.index') }}"
                                class="nav-link {{ request()->routeIs('wali-murid.dashboard.*') ? 'nav-link--active' : '' }}">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('wali-murid.tagihan.index') }}"
                                class="nav-link {{ request()->routeIs('wali-murid.tagihan.*') ? 'nav-link--active' : '' }}">
                                Tagihan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('wali-murid.riwayat.index') }}"
                                class="nav-link {{ request()->routeIs('wali-murid.riwayat.*') ? 'nav-link--active' : '' }}">
                                Riwayat
                            </a>
                        </li>
                    @endif

                    @if (Auth::user()->role === 'kepala_sekolah')
                        {{-- placeholder --}}
                        <li><a href="{{ route('kepala-sekolah.dashboard.index') }}" class="mobile-nav-item">📊
                                Dashboard</a>
                        </li>
                        <li><a href="{{ route('kepala-sekolah.reports.index') }}" class="mobile-nav-item">Report</a></li>
                    @endif
                @endauth
            </ul>

            {{-- ══ RIGHT ACTIONS ══ --}}
            <div style="display: flex; align-items: center; gap: 10px;" class="hidden-mobile">
                @guest
                    <a href="{{ route('login') }}" wire:navigate class="btn btn--primary"
                        style="padding: 8px 20px; font-size: 13px;">
                        Masuk
                    </a>
                @endguest

                @auth
                    {{-- User chip --}}
                    <div x-data="{ open: false }" style="position: relative;">
                        <button @click="open = !open" @click.outside="open = false"
                            style="display: flex; align-items: center; gap: 9px; padding: 5px 12px 5px 20px;
                                   
                                   border-radius: var(--r-pill); cursor: pointer; transition: background 0.15s;"
                            onmouseover="this.style.background='rgba(255,255,255,0.1)'"
                            onmouseout="this.style.background='rgba(255,255,255,0.06)'">
                            <div>

                            </div>
                            <div style="text-align: left; ">
                                <div style="font-size: 12.5px; font-weight: 600; color: white; line-height: 1.2; ">
                                    {{ explode(' ', Auth::user()->name)[0] }}
                                </div>
                                <div
                                    style="font-size: 10px; color: var(--em-300); text-transform: capitalize;
                                        letter-spacing: 0.3px; display: flex; align-items: center; gap: 4px; display: flex; flex-direction: column; ">
                                    {{ str_replace('_', ' ', Auth::user()->role) }}
                                </div>
                            </div>
                            <svg :style="open ? 'transform:rotate(180deg)' : ''"
                                style="width: 12px; height: 12px; color: #FFFF; transition: transform 0.2s; margin-left: 2px;"
                                viewBox="0 0 12 12" fill="none">
                                <path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" style="color: #ffff;" />
                            </svg>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            style="position: absolute; top: calc(100% + 10px); right: 0; width: 200px;
                                background: var(--em-900); border: 1px solid rgba(16,185,129,0.2);
                                border-radius: var(--r-md); padding: 6px;
                                box-shadow: 0 16px 48px rgba(0,0,0,0.4);">

                            {{-- Info user --}}
                            <div
                                style="padding: 10px 12px; border-bottom: 1px solid rgba(255,255,255,0.07);
                                    margin-bottom: 6px;">
                                <div style="font-size: 12.5px; font-weight: 600; color: white;">
                                    {{ Auth::user()->name }}
                                </div>
                                <div
                                    style="font-size: 11px; color: var(--em-300); margin-top: 2px;
                                        word-break: break-all;">
                                    {{ Auth::user()->email }}
                                </div>
                            </div>

                            <form wire:submit.prevent="logout">
                                <button type="submit"
                                    style="width: 100%; display: flex; align-items: center; gap: 8px;
                                           padding: 9px 12px; border-radius: var(--r-sm); background: none;
                                           border: none; cursor: pointer; color: #fca5a5; font-size: 13px;
                                           font-family: var(--font-body); font-weight: 500; text-align: left;
                                           transition: background 0.15s;"
                                    onmouseover="this.style.background='rgba(220,38,38,0.12)'"
                                    onmouseout="this.style.background='none'">
                                    <span style="font-size: 15px;">🚪</span> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>

            {{-- ══ HAMBURGER (mobile) ══ --}}
            <button @click="mobileOpen = !mobileOpen" class="show-mobile">
                <span :class="mobileOpen ? 'line top active' : 'line top'"
                    style="display: block; width: 18px; height: 1.5px; background: var(--em-300);
               border-radius: 2px; transition: transform 0.25s, opacity 0.25s;"></span>
                <span :class="mobileOpen ? 'line middle active' : 'line middle'"
                    style="display: block; width: 18px; height: 1.5px; background: var(--em-300);
               border-radius: 2px; transition: opacity 0.25s;"></span>
                <span :class="mobileOpen ? 'line bottom active' : 'line bottom'"
                    style="display: block; width: 18px; height: 1.5px; background: var(--em-300);
               border-radius: 2px; transition: transform 0.25s;"></span>
            </button>

        </div>
    </div>

    {{-- ══ MOBILE DRAWER ══ --}}
    <div x-show="mobileOpen" x-cloak x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="background: var(--em-950); border-top: 1px solid rgba(16,185,129,0.12);
            padding: 12px 20px 20px;">

        {{-- User info strip (mobile) --}}
        @auth
            <div
                style="display: flex; align-items: center; gap: 10px; padding: 12px 14px;
                    background: rgba(255,255,255,0.05); border-radius: var(--r-md);
                    margin-bottom: 12px; border: 1px solid rgba(255,255,255,0.08);">
                <div>

                </div>
                <div>
                    <div style="font-size: 13px; font-weight: 600; color: white;">{{ Auth::user()->name }}</div>
                    <div style="font-size: 10.5px; color: var(--em-300); text-transform: capitalize;">
                        {{ str_replace('_', ' ', Auth::user()->role) }}
                    </div>
                </div>
            </div>
        @endauth

        <ul style="list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 2px;">
            @guest
                <li>
                    <a href="/" wire:navigate class="mobile-nav-item">🏠 Beranda</a>
                </li>
            @endguest

            @auth
                @if (Auth::user()->role === 'admin')
                    <li><a href="{{ route('admin.dashboard.index') }}" class="mobile-nav-item">📊 Dashboard</a></li>
                    <li><a href="{{ route('admin.users.index') }}" class="mobile-nav-item">👥 Manajemen Users</a></li>
                    <li><a href="{{ route('admin.siswa.index') }}" class="mobile-nav-item">🎓 Manajemen Siswa</a></li>
                    <li><a href="{{ route('admin.kategori.index') }}" class="mobile-nav-item">🏷️ Kategori SPP</a></li>
                    <li><a href="{{ route('admin.tagihan.index') }}" class="mobile-nav-item">📋 Tagihan</a></li>
                @endif

                @if (Auth::user()->role === 'wali_murid')
                    <li><a href="{{ route('wali-murid.dashboard.index') }}" class="mobile-nav-item">🏠 Dashboard</a>
                    </li>
                    <li><a href="{{ route('wali-murid.tagihan.index') }}" class="mobile-nav-item">📋 Tagihan</a></li>
                    <li><a href="{{ route('wali-murid.riwayat.index') }}" class="mobile-nav-item">🧾 Riwayat</a></li>
                @endif
            @endauth


        </ul>

        {{-- Divider --}}
        <div style="height: 1px; background: rgba(255,255,255,0.07); margin: 12px 0;"></div>

        @guest
            <a href="{{ route('login') }}" wire:navigate class="btn btn--primary btn--full"
                style="font-size: 13.5px; padding: 12px;">
                Masuk
            </a>
        @endguest

        @auth
            <form wire:submit.prevent="logout">
                <button type="submit"
                    style="width: 100%; display: flex; align-items: center; justify-content: center;
                           gap: 8px; padding: 11px; border-radius: var(--r-md); background: rgba(220,38,38,0.1);
                           border: 1px solid rgba(220,38,38,0.2); cursor: pointer; color: #fca5a5;
                           font-size: 13.5px; font-family: var(--font-body); font-weight: 600;
                           transition: background 0.15s;">
                    🚪 Keluar
                </button>
            </form>
        @endauth
    </div>

</nav>

<style>
    /* Desktop nav link */
    .nav-link {
        display: inline-flex;
        align-items: center;
        padding: 7px 14px;
        border-radius: var(--r-sm);
        font-size: 13px;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.55);
        text-decoration: none;
        transition: color 0.15s, background 0.15s;
        white-space: nowrap;
        background: none;
        border: none;
        cursor: pointer;
        font-family: var(--font-body);
        gap: 4px;
    }

    .nav-link:hover {
        color: rgba(255, 255, 255, 0.85);
        background: rgba(255, 255, 255, 0.06);
    }

    .nav-link--active {
        color: var(--em-300) !important;
        background: rgba(16, 185, 129, 0.12) !important;
    }

    .nav-link--dropdown {
        /* same as nav-link, already inherited */
    }

    /* Dropdown item */
    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 9px 12px;
        border-radius: var(--r-sm);
        font-size: 13px;
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        font-weight: 400;
        transition: background 0.15s, color 0.15s;
        white-space: nowrap;
    }

    .dropdown-item:hover {
        background: rgba(255, 255, 255, 0.07);
        color: white;
    }

    .dropdown-item--active {
        background: rgba(16, 185, 129, 0.12);
        color: var(--em-300);
    }

    /* Mobile nav item */
    .mobile-nav-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 11px 14px;
        border-radius: var(--r-sm);
        font-size: 13.5px;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        transition: background 0.15s, color 0.15s;
    }

    .mobile-nav-item:hover,
    .mobile-nav-item:active {
        background: rgba(16, 185, 129, 0.1);
        color: var(--em-300);
    }

    /* Responsive helpers */
    .show-mobile {
        display: flex;
        width: 38px;
        height: 38px;
        border-radius: var(--r-sm);
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.25);
        cursor: pointer;
        padding: 0;
        gap: 5px;
    }

    @media (max-width: 768px) {
        .hidden-mobile {
            display: none !important;
        }

        .show-mobile {
            display: flex !important;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
    }

    @media (min-width: 769px) {
        .show-mobile {
            display: none !important;
        }

        .hidden-mobile {
            display: flex !important;
        }
    }

    [x-cloak] {
        display: none !important;
    }

    .line {
        display: block;
        width: 18px;
        height: 2px;
        background: var(--em-300);
        border-radius: 2px;
        transition: all 0.25s ease;
        transform-origin: center;
    }

    /* posisi awal */


    /* saat aktif (X) */
    .top.active {
        transform: translateY(6.6px) rotate(45deg);
    }

    .middle.active {
        opacity: 0;
    }

    .bottom.active {
        transform: translateY(-6.6px) rotate(-45deg);
    }
</style>
