<?php

namespace App\Providers;

use App\Repositories\AddonRepository;
use App\Repositories\AddonRepositoryInterface;
use App\Repositories\ProductAddonRepository;
use App\Repositories\ProductAddonRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Admin\AdminRepositoryInterface;
use App\Repositories\Admin\AdminRepository;
use App\Repositories\Client\ClientRepositoryInterface;
use App\Repositories\Client\ClientRepository;
use App\Repositories\ProductMediaRepositoryInterface;
use App\Repositories\ProductMediaRepository;
use App\Repositories\ProjectRepositoryInterface;
use App\Repositories\ProjectRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductMediaRepositoryInterface::class, ProductMediaRepository::class);
        $this->app->bind(AddonRepositoryInterface::class, AddonRepository::class);
        $this->app->bind(ProductAddonRepositoryInterface::class, ProductAddonRepository::class);
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
