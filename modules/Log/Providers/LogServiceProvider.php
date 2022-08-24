<?php

namespace Modules\Log\Providers;

use Core\Facades\MenuFacade;
use Illuminate\Support\ServiceProvider;
use Modules\Log\Entities\Models\LogModel;
use Modules\Log\Providers\Log\PolicyServiceProvider;
use Modules\Log\Providers\Log\RouteServiceProvider;

class LogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'log');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'log');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadFactoriesFrom(__DIR__.'/../Database/Factories');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerCommands();
        MenuFacade::pushMenu([
            'group' => 30,
            'group_name' => '',
            'pos_child' => 0,
            'name' => 'log::text.log management',
            'class' => LogModel::class,
            'route' => 'cp.logs.index',
            'icon' => 'building',
        ]);

        $this->app->register(RouteServiceProvider::class);
        $this->app->register(PolicyServiceProvider::class);

    }

    function registerCommands()
    {
        $this->commands([
        ]);
    }
}
