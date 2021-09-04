<?php

namespace Develops\_R\Supports\Generators;

use Develops\_R\Entities\Generator\GeneratorParams;
use Develops\_R\Supports\Utils\FileUtil;

class ArchitectureGenerator
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var
     */
    protected $params;

    public function __construct(GeneratorParams $params)
    {
        $this->params = $params;
        $this->path = module_path($params->moduleName);
    }

    public function generate()
    {
        $this->createHttp();
        $this->createProviders();
        $this->createResources();
        $this->createRoutes();

        if ($this->params->hasDatabase()) {
            $this->createDatabase();
            $this->createEntities();
            $this->createPolicies();
            $this->createRepositories();
            $this->createServices();
        }
    }

    public function createDatabase()
    {
        FileUtil::createDirectoryIfNotExist($this->path . DIRECTORY_SEPARATOR . 'Database');
    }

    public function createEntities()
    {
        FileUtil::createDirectoryIfNotExist($this->path . DIRECTORY_SEPARATOR . 'Entities');
    }

    public function createHttp()
    {
        FileUtil::createDirectoryIfNotExist($this->path . DIRECTORY_SEPARATOR . 'Http');
    }

    public function createPolicies()
    {
        FileUtil::createDirectoryIfNotExist($this->path . DIRECTORY_SEPARATOR . 'Policies');
    }

    public function createProviders()
    {
        FileUtil::createDirectoryIfNotExist($this->path . DIRECTORY_SEPARATOR . 'Providers');
    }

    public function createRepositories()
    {
        FileUtil::createDirectoryIfNotExist($this->path . DIRECTORY_SEPARATOR . 'Repositories');
    }

    public function createResources()
    {
        FileUtil::createDirectoryIfNotExist($this->path . DIRECTORY_SEPARATOR . 'resources');
    }

    public function createRoutes()
    {
        FileUtil::createDirectoryIfNotExist($this->path . DIRECTORY_SEPARATOR . 'routes');
    }

    public function createServices()
    {
        FileUtil::createDirectoryIfNotExist($this->path . DIRECTORY_SEPARATOR . 'Services');
    }
}
