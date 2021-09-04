<?php

namespace Develops\_R\Supports\Generators;

use Illuminate\Support\Str;
use Develops\_R\Entities\Generator\GeneratorParams;
use Develops\_R\Supports\Utils\FileUtil;
use Develops\_R\Supports\Utils\JqueryBuilder;

class HttpGenerator extends BaseGenerator
{
    /**
     * @var GeneratorParams
     */
    private $params;

    /** @var string */
    private $path;

    /** @var string */
    private $pathRoute;

    /** @var string */
    private $pathResources;

    /** @var string */
    private $moduleName;

    public function __construct(GeneratorParams $params)
    {
        $this->params = $params;
        $this->path = $params->getPath('/Http/Controllers/Web/');

        $this->pathRoute = $params->getPath('/routes/'.$params->modelName."/");
        $this->pathResources =  $params->getPath('/resources/');
    }

    public function generate()
    {
        $this->generateController();
        $this->generateRoute();
    }

    private function generateController()
    {
        $templateData = get_template('http/controller');

        if (!$this->params->hasDatabase()) {
            $templateData = get_template('http/controller_no_service');
        }

        $templateData = fillTemplate($this->params, [
            '$RELATION_SINGLE$' => $this->getLoadRelationSingleItem(),
        ], $templateData);

        $fileName = $this->params->modelName . 'Controller.php';

        FileUtil::createFile($this->path, $fileName, $templateData);
    }

    private function getLoadRelationSingleItem()
    {
        $arr = [];

        foreach ($this->params->fields as $field){
            if($field->name == 'created_by'){
                $arr[] = '\'owner\'';
            }
        }

        foreach ($this->params->relations as $relation) {
            if (!$relation->foreignModel) {
                continue;
            }

            switch ($relation->relationType) {
                case '1t1_has_one':
                    $arr[] = '\''.Str::lower($relation->foreignModel).'\'';
                    break;
                case '1t1_belongs_to':
                    $arr[] = '\''.Str::lower($relation->foreignModel).'\'';
                    break;
                case 'mt1_belongs_to':
                    $arr[] = '\''.Str::lower($relation->foreignModel).'\'';
                    break;
            }
        }

        return implode(', ', $arr);
    }

    private function generateRoute()
    {
        $templateData = get_template('routes/web');

        if (!$this->params->hasDatabase()) {
            $templateData = get_template('routes/web_no_db');
        }

        $templateData = fillTemplate($this->params, [], $templateData);

        $fileName = 'web.php';

        FileUtil::createFile($this->pathRoute, $fileName, $templateData);
    }
}
