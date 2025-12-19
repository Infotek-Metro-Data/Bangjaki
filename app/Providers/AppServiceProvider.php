<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $mockUser = (object)[
            'nama' => 'Admin Utama',
            'email' => 'admin@bangjaki.com',
            'peran' => 'admin',
            'foto_profil' => null
        ];

        View::share('user', $mockUser);
    }
}
