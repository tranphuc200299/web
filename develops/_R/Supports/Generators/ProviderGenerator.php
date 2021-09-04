<?php

namespace Develops\_R\Supports\Generators;

use Illuminate\Support\Str;
use Develops\_R\Entities\Generator\GeneratorParams;
use Develops\_R\Supports\Utils\FileUtil;

class ProviderGenerator extends BaseGenerator
{
    /**
     * @var GeneratorParams
     */
    private $params;

    /** @var string */
    private $path;

    /** @var string */
    private $pathModel;

    public function __construct(GeneratorParams $params)
    {
        $this->params = $params;
        $this->path = $params->getPath('/Providers/');
        $this->pathModel = $params->getPath('/Providers/' . $params->modelName . "/");
    }

    public function generate()
    {
        $this->generateModuleProvider();
        $this->generateRouteProvider();

        if ($this->params->hasDatabase()) {
            $this->generatePolicyProvider();
        }
    }

    private function generateModuleProvider()
    {
        $templateData = get_template('providers/ModuleServiceProvider');
        if (!$this->params->hasDatabase()) {
            $templateData = get_template('providers/ModuleServiceProvider_No_Policy');
        }

        $templateData = fillTemplate($this->params, [], $templateData);

        $fileName = $this->params->moduleName . 'ServiceProvider.php';

        FileUtil::createFile($this->path, $fileName, $templateData);
    }

    private function generatePolicyProvider()
    {
        $templateData = get_template('providers/PolicyServiceProvider');

        $templateData = fillTemplate($this->params, [], $templateData);

        $fileName = 'PolicyServiceProvider.php';

        FileUtil::createFile($this->pathModel, $fileName, $templateData);
    }

    private function generateRouteProvider()
    {
        $templateData = get_template('providers/RouteServiceProvider');

        $templateData = fillTemplate($this->params, [], $templateData);

        $fileName = 'RouteServiceProvider.php';

        FileUtil::createFile($this->pathModel, $fileName, $templateData);
    }
}
