<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use TP\Building\Infrastructure\Provider\BuildingServiceProvider;
use TP\Shared\Infrastructure\Database\EloquentPdoConnection;
use TP\Shared\Lib\Database\PdoConnection;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->loadServiceProviders();
        $this->loadRepositories();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    protected function loadServiceProviders(): void
    {
        $this->app->register(BuildingServiceProvider::class);
    }

    protected function loadRepositories(): void
    {
        $this->app->bind(PdoConnection::class, EloquentPdoConnection::class);
    }
}
