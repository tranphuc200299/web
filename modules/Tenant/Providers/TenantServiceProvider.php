<?php

namespace Modules\Tenant\Providers;

use Core\Facades\MenuFacade;
use Illuminate\Support\ServiceProvider;
use Modules\Tenant\Entities\Models\TenantModel;
use Modules\Tenant\Providers\Tenant\PolicyServiceProvider;
use Modules\Tenant\Providers\Tenant\RouteServiceProvider;

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
        MenuFacade::pushMenu([
            'group' => 20,
            'group_name' => '',
            'pos_child' => 0,
            'name' => 'tenant::text.tenant management',
            'class' => TenantModel::class,
            'route' => 'cp.tenants.index',
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
