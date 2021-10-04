<?php

namespace Modules\Tenant\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Core\Facades\MenuFacade;

class TenantServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views/' . config('view.template'), 'tenant');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'tenant');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadFactoriesFrom(__DIR__.'/../Database/Factories');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerCommands();

        $allDir = scandir(__DIR__);
        $listMode = array_diff($allDir, array('..', '.'));

        foreach ($listMode as $modelName) {
            if (file_exists(base_path("modules/Tenant/Providers/{$modelName}/RouteServiceProvider.php"))) {
                $this->app->register("Modules\\Tenant\\Providers\\{$modelName}\\RouteServiceProvider");

                MenuFacade::pushMenu([
                    'group' => '',
                    'name' => $modelName,
                    'class' => "Modules\\Tenant\\Entities\\Models\\{$modelName}Model",
                    'route' => 'cp.' . Str::plural(strtolower($modelName)) . '.index',
                    'icon' => 'building',
                ]);
            }

            if (file_exists(base_path("modules/Tenant/Providers/{$modelName}/PolicyServiceProvider.php"))) {
                $this->app->register("Modules\\Tenant\\Providers\\{$modelName}\\PolicyServiceProvider");
            }
        }

    }

    function registerCommands()
    {
        $this->commands([
        ]);
    }
}
