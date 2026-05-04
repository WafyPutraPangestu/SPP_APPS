<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });
        Gate::define('wali_murid', function ($user) {
            return $user->role === 'wali_murid';
        });
        Gate::define('kepala_sekolah', function ($user) {
            return $user->role === 'kepala_sekolah';
        });
    }
}
