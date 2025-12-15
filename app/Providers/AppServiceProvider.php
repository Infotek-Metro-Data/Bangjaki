<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        // Mock User for Frontend Mode
        $mockUser = (object)[
            'nama' => 'Admin Utama',
            'email' => 'admin@bangjaki.com',
            'peran' => 'admin',
            'foto_profil' => null
        ];

        View::share('user', $mockUser);
    }
}
