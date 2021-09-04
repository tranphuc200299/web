<?php

namespace Develops\_R\Providers;

use Illuminate\Support\ServiceProvider;

class _RServiceProvider extends ServiceProvider
{
    public function boot()
    {
        require_once(__DIR__ . '/../helpers/helpers.php');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'r');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerCommands();
        $this->app->register(RouteServiceProvider::class);
    }

    function registerCommands()
    {
        $this->commands([
        ]);
    }
}
