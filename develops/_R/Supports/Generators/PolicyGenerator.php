<?php

namespace Develops\_R\Supports\Generators;

use Develops\_R\Entities\Generator\GeneratorParams;
use Develops\_R\Supports\Utils\FileUtil;

class PolicyGenerator extends BaseGenerator
{
    /**
     * @var GeneratorParams
     */
    private $params;

    /** @var string */
    private $path;

    public function __construct(GeneratorParams $params)
    {
        $this->params = $params;
        $this->path = $params->getPath('/Policies/');
    }

    public function generate()
    {
        if (!$this->params->hasDatabase()) {
            return false;
        }

        $templateData = get_template('policy/Policy');

        $templateData = $templateData = fillTemplate($this->params, [], $templateData);

        $fileName = $this->params->modelName.'Policy.php';

        FileUtil::createFile($this->path, $fileName, $templateData);
    }
}
