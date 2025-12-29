<?php

namespace App\Providers;

use App\Models\Pembayaran;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {

        View::composer('components.layouts.admin', function ($view) {
            $pendingVerifikasi = 0;
            try {
                $pendingVerifikasi = Pembayaran::where('status', 'menunggu_admin')->count();
            } catch (\Exception $e) {

            }
            $view->with('pendingVerifikasi', $pendingVerifikasi);
        });
    }
}
