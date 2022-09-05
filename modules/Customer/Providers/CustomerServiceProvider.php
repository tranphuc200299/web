<?php

namespace Modules\Customer\Providers;

use Core\Facades\MenuFacade;
use Illuminate\Support\ServiceProvider;
use Modules\Customer\Entities\Models\CustomerModel;
use Modules\Customer\Providers\Customer\PolicyServiceProvider;
use Modules\Customer\Providers\Customer\RouteServiceProvider;

class CustomerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'customer');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'customer');
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
            'group' => 6,
            'group_name' => '',
            'pos_child' => 0,
            'name' => 'log::text.log management',
            'class' => CustomerModel::class,
            'route' => 'cp.customers.index',
            'icon' => 'user-circle',
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
