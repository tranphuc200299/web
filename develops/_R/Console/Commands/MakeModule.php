<?php

namespace Develops\_R\Console\Commands;

use Develops\_R\Entities\Generator\GeneratorParams;
use Develops\_R\Supports\Generators\ArchitectureGenerator;
use Develops\_R\Supports\Generators\BladeGenerator;
use Develops\_R\Supports\Generators\FactoryGenerator;
use Develops\_R\Supports\Generators\HttpGenerator;
use Develops\_R\Supports\Generators\MigrationGenerator;
use Develops\_R\Supports\Generators\ModelGenerator;
use Develops\_R\Supports\Generators\PolicyGenerator;
use Develops\_R\Supports\Generators\ProviderGenerator;
use Illuminate\Console\Command;

class MakeModule extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {module} {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make module';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $module = $this->argument('module');
        $model = $this->argument('model');
        if ($module) {
            $params = new GeneratorParams(
                [
                    "moduleName"    => $module,
                    "modelName"     => $model,
                    "tableName"     => '',
                    "listView"      => "Table",
                    "childView"     => "None",
                    "icon"          => "google",
                    "group"         => "Menu Group 1",
                    "fakerLanguage" => "ja_JP",
                    "options"       => [
                        "softDelete" => true,
                        "prefix"     => "ms",
                        "paginate"   => "10",
                    ],
                    "addOns"        => [
                        "auth" => true
                    ],
                    "fields"        => [

                    ],
                    "relations"     => [],
                ]
            );

            $architectureGenerator = new ArchitectureGenerator($params);
            $migrationGenerator = new MigrationGenerator($params);
            $providerGenerator = new ProviderGenerator($params);
            $modelGenerator = new ModelGenerator($params);
            $factoryGenerator = new FactoryGenerator($params);
            $policyGenerator = new PolicyGenerator($params);
            $httpGenerator = new HttpGenerator($params);
            $bladeGenerator = new BladeGenerator($params);

            $architectureGenerator->generate();
            $factoryGenerator->generate();
            $providerGenerator->generate();
            $modelGenerator->generate();
            $policyGenerator->generate();
            $httpGenerator->generate();
            $bladeGenerator->generate();
        } else {
            $this->error('Module argument is required');
        }
    }
}
