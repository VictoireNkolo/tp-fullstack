<?php

namespace TP\Building\Infrastructure\Provider;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use TP\Building\Domain\BuildingRepository;
use TP\Building\Infrastructure\Repositories\EloquentBuildingRepository;

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
        $this->loadMigrationsFrom(base_path('/modules/Building/Infrastructure/database/migrations'));
        $this->app->singleton(BuildingRepository::class, EloquentBuildingRepository::class);
    }

    protected function registerRoutes(): void
    {
        Route::group($this->routeConfig(), function () {
            $this->loadRoutesFrom(base_path('/modules/Building/Infrastructure/routes/web.php'));
        });
    }

    protected function routeConfig(): array
    {
        return [
            'prefix' => 'tp',
            'middleware' => ['web'],
        ];
    }
}
