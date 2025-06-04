<?php

namespace App\Providers;

use Illuminate\Support\Facades\View; // Pastikan ini di-import
use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers\UserNotificationComposer; // Import composer Anda

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
        View::composer(['layout.navbar'], UserNotificationComposer::class);
    }
}
