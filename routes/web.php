<?php

use App\Http\Controllers\MidtransCallbackController;
use App\Livewire\Admin\Dashboard\Index as AdminDashboardIndex;
use App\Livewire\Admin\Users\Create;
use App\Livewire\Admin\Users\Edit;
use App\Livewire\Admin\Users\Index;
use App\Livewire\Admin\Users\Show;
use App\Livewire\Auth\Login;
use App\Livewire\Home;
use App\Livewire\Admin\Tagihan\Index as TagihanIndex;

use App\Livewire\Admin\Kategori\Index as KategoriIndex;
use App\Livewire\Admin\Kategori\Create as KategoriCreate;
use App\Livewire\Admin\Kategori\Edit as KategoriEdit;
use App\Livewire\Admin\Kategori\Show as KategoriShow;
use App\Livewire\Admin\Siswa\Index as SiswaIndex;
use App\Livewire\Admin\Siswa\Create as SiswaCreate;
use App\Livewire\Admin\Siswa\Edit as SiswaEdit;
use App\Livewire\Admin\Siswa\Show as SiswaShow;
use App\Livewire\WaliMurid\Dashboard\Index as WaliMuridDashboardIndex;
use App\Livewire\KepalaSekolah\Dashboard\Index as KepalaSekolahDashboardIndex;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class,)->name('home');

Route::post('/midtrans/callback', [MidtransCallbackController::class, 'handle'])
    ->name('midtrans.callback');
Route::middleware(['guest'])->group(function () {
    Route::get('/login', Login::class)->name('login');
});

Route::middleware(['auth', 'admin'])->group(function () {

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', Index::class)->name('users.index');
        Route::get('/users/create', Create::class)->name('users.create');
        Route::get('/users/{user}/edit', Edit::class)->name('users.edit');
        Route::get('/users/{user}', Show::class)->name('users.show');

        Route::get('/siswa', SiswaIndex::class)->name('siswa.index');
        Route::get('/siswa/create', SiswaCreate::class)->name('siswa.create');
        Route::get('/siswa/{siswa}/edit', SiswaEdit::class)->name('siswa.edit');
        Route::get('/siswa/{siswa}', SiswaShow::class)->name('siswa.show');

        Route::get('/kategori', KategoriIndex::class)->name('kategori.index');
        Route::get('/kategori/create', KategoriCreate::class)->name('kategori.create');
        Route::get('/kategori/{kategori}/edit', KategoriEdit::class)->name('kategori.edit');
        Route::get('/kategori/{kategori}', KategoriShow::class)->name('kategori.show');
        Route::get('/tagihan', TagihanIndex::class)->name('tagihan.index');

        Route::get('/dashboard', AdminDashboardIndex::class)->name('dashboard.index');
    });
});

Route::middleware(['auth', 'wali_murid'])->group(function () {
    Route::get('wali-murid/dashboard/index', WaliMuridDashboardIndex::class)->name('wali-murid.dashboard.index');
    Route::get('wali-murid/tagihan', \App\Livewire\WaliMurid\Tagihan\Index::class)->name('wali-murid.tagihan.index');
    Route::get('wali-murid/tagihan/{tagihanId}', \App\Livewire\WaliMurid\Tagihan\Show::class)->name('wali-murid.tagihan.show');
    Route::get('wali-murid/riwayat/index', \App\Livewire\WaliMurid\Riwayat\Index::class)->name('wali-murid.riwayat.index');
});

Route::middleware(['auth', 'kepala_sekolah'])->group(function () {
    Route::get('kepala-sekolah/dashboard/index', KepalaSekolahDashboardIndex::class)->name('kepala-sekolah.dashboard.index');
    Route::get('kepala-sekolah/reports/index', \App\Livewire\KepalaSekolah\Reports\Index::class)->name('kepala-sekolah.reports.index');
});
