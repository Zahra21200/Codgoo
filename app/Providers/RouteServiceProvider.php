<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
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
        // Define API routes manually for older Laravel versions
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));

        // Define web routes
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }
}