<?php

namespace Modules\Auth\Providers;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/' . config('view.template'), 'auth');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang/', 'auth');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadFactoriesFrom(__DIR__ . '/../Database/Factories');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerCommands();
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(PolicyServiceProvider::class);
    }

    function registerCommands()
    {
        $this->commands([
        ]);
    }
}
