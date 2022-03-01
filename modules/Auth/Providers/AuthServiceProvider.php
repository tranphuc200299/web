<?php

namespace Modules\Auth\Providers;

use Core\Facades\MenuFacade;
use Illuminate\Support\ServiceProvider;
use Modules\Auth\Database\Factories\PermissionFactory;
use Modules\Auth\Database\Factories\RoleFactory;
use Modules\Auth\Database\Factories\UserFactory;
use Modules\Auth\Entities\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'auth');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang/', 'auth');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
//        $this->loadFactoriesFrom(__DIR__ . '/../Database/Factories');
        UserFactory::new();
        RoleFactory::new();
        PermissionFactory::new();
        require_once(__DIR__ . '/../Helpers/functions.php');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerCommands();
        MenuFacade::pushMenu([
            'group' => 10,
            'group_name' => '',
            'pos_child' => 0,
            'name' => 'auth::text.account management',
            'class' => User::class,
            'route' => 'cp.users.index',
            'icon' => 'user',
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
