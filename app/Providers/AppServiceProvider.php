<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Admin\AdminRepositoryInterface;
use App\Repositories\Admin\AdminRepository;
use App\Repositories\Client\ClientRepositoryInterface;
use App\Repositories\Client\ClientRepository;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    { 
        
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
    
    
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
