<?php

namespace Develops\_R\Services;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Develops\_R\Entities\Models\Entities;
use Modules\Auth\Entities\Models\Permission;

class PackageControlService
{
    /*Migrate*/
    public function migrate($moduleName)
    {
        try {
            Artisan::call('migrate --path=modules/' . $moduleName . '/Database/Migrations');
        } catch (\Exception $e) {
            Log::error($e);
            return false;
        }

        return true;
    }

    /*Rollback*/
    public function rollback($moduleName)
    {
        try {
            $migrationDir = scandir(app()->basePath('modules/'.$moduleName.'/Database/Migrations'));
            $fileList = array_diff($migrationDir, array('..', '.'));

            $files = [];
            foreach ($fileList as $file) {
                $files[] = str_replace('.php', '', $file);
            }

            if (!empty($files)) {
                DB::table('migrations')->whereIn('migration', $files)->update(['batch' => 100000]);
            }

            Artisan::call('migrate:rollback --path=modules/' . $moduleName . '/Database/Migrations');
        } catch (\Exception $e) {
            Log::error($e);
            return false;
        }

        return true;
    }

    /*Destroy*/
    public function destroy($moduleName, $modelName)
    {
        $models = Entities::where('module_name', $moduleName)->get();
        $entity = Entities::where('module_name', $moduleName)->where('name', $modelName)->first();

        try {
            $this->rollback($moduleName, $modelName);
            Permission::where('name', 'like', "%" . strtolower($modelName) . "%")->delete();

            $migratesFile = json_decode($entity->migration_files_json);

            File::delete(app()->basePath('modules/' . $moduleName . '/Database/Factories/' . $modelName . 'Factory.php'));
            foreach ($migratesFile as $file) {
                File::delete(app()->basePath('modules/' . $moduleName . '/Database/Migrations/' . $file));
            }
            File::delete(app()->basePath('modules/' . $moduleName . '/Entities/Models/' . $modelName . 'Model.php'));
            File::delete(app()->basePath('modules/' . $moduleName . '/Http/Controllers/Web/' . $modelName . 'Controller.php'));
            File::delete(app()->basePath('modules/' . $moduleName . '/Policies/' . $modelName . 'Policy.php'));
            File::deleteDirectory(app()->basePath('modules/' . $moduleName . '/Providers/' . $modelName . '/'));
            File::delete(app()->basePath('modules/' . $moduleName . '/Repositories/' . $modelName . 'Repository.php'));
            File::deleteDirectory(app()->basePath('modules/' . $moduleName . '/resources/views/' . strtolower($modelName) . '/'));
            File::deleteDirectory(app()->basePath('modules/' . $moduleName . '/routes/' . $modelName . '/'));
            File::delete(app()->basePath('modules/' . $moduleName . '/Services/' . $modelName . 'Service.php'));

            if (sizeof($models) == 1) {
                File::deleteDirectory(app()->basePath('modules/' . $moduleName));
            }
        } catch (\Exception $e) {
            Log::error($e);
            return false;
        }

        return true;
    }

}
