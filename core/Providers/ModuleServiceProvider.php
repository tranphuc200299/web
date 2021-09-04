<?php

namespace Core\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->autoloadModule();
        if(config('core.enable_dev_module')){
            $this->loadDevModules();
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    private function autoloadModule()
    {
        $allDir = scandir($this->app->basePath('/modules'));
        $listModule = array_diff($allDir, array('..', '.'));

        foreach ($listModule as $moduleName) {
            if (file_exists(base_path("modules/{$moduleName}/Providers/{$moduleName}ServiceProvider.php"))) {
                $this->app->register("Modules\\{$moduleName}\\Providers\\{$moduleName}ServiceProvider");
            }
        }
    }

    private function loadDevModules()
    {
        $allDir = scandir($this->app->basePath('/develops'));
        $listModule = array_diff($allDir, array('..', '.'));

        foreach ($listModule as $moduleName) {
            if (file_exists(base_path("develops/{$moduleName}/Providers/{$moduleName}ServiceProvider.php"))) {
                $this->app->register("Develops\\{$moduleName}\\Providers\\{$moduleName}ServiceProvider");
            }
        }
    }
}
