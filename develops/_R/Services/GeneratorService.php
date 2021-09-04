<?php

namespace Develops\_R\Services;

use Develops\_R\Entities\Generator\GeneratorParams;
use Develops\_R\Entities\Models\Entities;
use Develops\_R\Supports\Generators\ArchitectureGenerator;
use Develops\_R\Supports\Generators\BladeGenerator;
use Develops\_R\Supports\Generators\FactoryGenerator;
use Develops\_R\Supports\Generators\HttpGenerator;
use Develops\_R\Supports\Generators\MigrationGenerator;
use Develops\_R\Supports\Generators\ModelGenerator;
use Develops\_R\Supports\Generators\PolicyGenerator;
use Develops\_R\Supports\Generators\ProviderGenerator;
use Modules\Auth\Constants\AuthConst;
use Modules\Auth\Entities\Models\Permission;

class GeneratorService
{
    /**
     * @var ArchitectureGenerator
     */
    protected $architectureGenerator;

    /**
     * @var MigrationGenerator
     */
    protected $migrationGenerator;

    /**
     * @var ProviderGenerator
     */
    protected $providerGenerator;

    /**
     * @var ModelGenerator
     */
    protected $modelGenerator;

    /**
     * @var PolicyGenerator
     */
    protected $policyGenerator;

    /**
     * @var HttpGenerator
     */
    protected $httpGenerator;

    /**
     * @var BladeGenerator
     */
    protected $bladeGenerator;

    /**
     * @var FactoryGenerator
     */
    protected $factoryGenerator;

    /**
     * @var Entities
     */
    protected $entity;

    public function build()
    {
        $data = request()->all();
        $params = new GeneratorParams($data);

        $this->architectureGenerator = new ArchitectureGenerator($params);
        $this->migrationGenerator = new MigrationGenerator($params);
        $this->providerGenerator = new ProviderGenerator($params);
        $this->modelGenerator = new ModelGenerator($params);
        $this->factoryGenerator = new FactoryGenerator($params);
        $this->policyGenerator = new PolicyGenerator($params);
        $this->httpGenerator = new HttpGenerator($params);
        $this->bladeGenerator = new BladeGenerator($params);

        /* Create entity */
        $this->createEntity($params);

        /* Build architecture */
        $this->architectureGenerator->generate();
        $this->migrationGenerator->generate($this->entity)->save($this->entity);
        $this->factoryGenerator->generate();
        $this->providerGenerator->generate();
        $this->modelGenerator->generate();
        $this->policyGenerator->generate();
        $this->httpGenerator->generate();
        $this->bladeGenerator->generate();

        /* Seed data*/
        $this->createOrUpdateData($params);

        return $this->entity;
    }

    private function createEntity(GeneratorParams $params)
    {
        $this->entity = Entities::updateOrCreate(
            ['name' => $params->modelName],
            [
                'module_name' => $params->moduleName,
                'name' => $params->modelName,
                'namespace' => $params->getNameSpace(),
                'config_json' => $params->getData(),
                'status' => $params->getStatus()
            ]
        );
    }

    private function createOrUpdateData(GeneratorParams $params)
    {
        Permission::where('name', 'like', "%".$params->getLowerName()."%")->delete();

        if ($params->hasDatabase()) {
            factory(Permission::class)->create([
                'name' => $params->getLowerName().AuthConst::PERMISSION_CREATE,
                'description' => 'Create entities, show button create'
            ]);
            factory(Permission::class)->create([
                'name' => $params->getLowerName().AuthConst::PERMISSION_READ,
                'description' => 'View list entities,show link in menu'
            ]);
            factory(Permission::class)->create([
                'name' => $params->getLowerName().AuthConst::PERMISSION_UPDATE,
                'description' => 'Update entities, show button edit'
            ]);
            factory(Permission::class)->create([
                'name' => $params->getLowerName().AuthConst::PERMISSION_DELETE,
                'description' => 'Delete entities, show button delete'
            ]);
        }
    }
}
