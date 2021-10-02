<?php

namespace Core\Providers;

use Core\Helpers\Menus;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        require_once(__DIR__ . '/../Helpers/functions.php');

        $this->loadViewsFrom(__DIR__ . '/../resources/views/' . config('view.template'), 'core');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'core');
        $this->mergeConfigFrom(__DIR__ . '/../Config/core.php', 'core');
        $this->app->register(MacroServiceProvider::class);
        $this->app->singleton('menu', function () {
            return new Menus();
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('HTTPS') == 'on') {
            URL::forceScheme('https');
        }
    }
}
