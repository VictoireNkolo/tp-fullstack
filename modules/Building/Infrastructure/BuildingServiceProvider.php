<?php

namespace Module\Infrastructure\Building;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Module\Domain\Building\BuildingRepository;
use Module\Infrastructure\Building\Repositories\EloquentBuildingRepository;

class BuildingServiceProvider extends ServiceProvider
{

    /**
     *
     */
    public function register()
    {
    }

    public function boot(): void
    {
        $this->registerRoutes();
        $this->loadMigrationsFrom(base_path('/modules/Infrastructure/Building/database/migrations'));
        $this->app->singleton(BuildingRepository::class, EloquentBuildingRepository::class);
    }

    protected function registerRoutes(): void
    {
        Route::group($this->routeConfig(), function () {
            $this->loadRoutesFrom(base_path('/modules/Infrastructure/Building/routes/web.php'));
        });
    }

    protected function routeConfig(): array
    {
        return [
            'prefix' => 'app',
            'middleware' => ['web', 'auth'],
        ];
    }
}