<?php

namespace Develops\_R\Supports\Generators;

use Develops\_R\Entities\Generator\GeneratorParams;
use Develops\_R\Supports\Common\CommandData;
use Develops\_R\Supports\Utils\FileUtil;
use Develops\_R\Supports\Utils\GeneratorFieldsInputUtil;

/**
 * Class FactoryGenerator.
 */
class FactoryGenerator extends BaseGenerator
{

    /** @var string */
    private $path;

    /**
     * @var GeneratorParams
     */
    private $params;

    public function __construct(GeneratorParams $params)
    {
        $this->params = $params;
        $this->path = $params->getPath('Database/Factories/');
    }

    public function generate()
    {
        if (!$this->params->hasDatabase()) {
            return false;
        }

        $templateData = get_template('factories/model_factory');

        $templateData = fillTemplate($this->params, [
            '$USER_IDS$' => $this->getUserRandom(),
            '$FIELDS$'   => implode(',' . infy_nl_tab(1, 2), $this->generateFields()),
        ], $templateData);

        $fileName = $this->params->modelName.'Factory.php';

        FileUtil::createFile($this->path, $fileName, $templateData);
    }

    private function getUserRandom(){
        $str = '';
        if($this->params->userRelation == 'has_one' || $this->params->ownerRelation) {
            $str = '$userIds = \Modules\Auth\Entities\Models\User::take(10)->get()->pluck(\'id\')->toArray();';
        }

        return $str;
    }

    /**
     * @return array
     */
    private function generateFields()
    {
        $fields = [];

        foreach ($this->params->fields as $field) {
            if ($field->primary || $field->dbType == 'increments') {
                continue;
            }

            if ($field->htmlType == 'image' || $field->htmlType == 'file') {
                continue;
            }

            $fieldData = "'".$field->name."' => ".'$faker->';

            if (!empty($field->txtFactoryFaker)) {
                if (!empty($field->unique)) {
                    $fieldData .= 'unique()->';
                }
                $fakerData = $field->txtFactoryFaker;
            } else {
                switch ($field->dbType) {
                    case 'uuid':
                        $fakerData = 'uuid';
                        break;
                    case 'integer':
                    case 'bigInteger':
                    case 'smallInteger':
                    case 'double':
                    case 'decimal':
                    case 'float':
                        $fakerData = 'randomDigitNotNull';
                        break;
                    case 'string':
                    case 'char':
                        $fakerData = 'word';
                        break;
                    case 'mediumText':
                    case 'LongText':
                    case 'text':
                        $fakerData = 'text';
                        break;
                    case 'datetime':
                    case 'datetimetz':
                    case 'date':
                    case 'timestamp':
                    case 'timestampTz':
                        $fakerData = "date('Y-m-d H:i:s')";
                        break;
                    case 'time':
                    case 'timeTz':
                        $fakerData = "date('H:i:s')";
                        break;
                    default:
                        $fakerData = 'word';
                }
            }
            $fieldData .= $fakerData;
            $fields[] = $fieldData;
        }

        if ($this->params->userRelation == 'has_one') {
            $fields[] = "'user_id' => " . '$userIds[rand(0, count($userIds) -1)]';
        }

        if ($this->params->ownerRelation) {
            $fields[] = "'created_by' => " . '$userIds[rand(0, count($userIds) -1)]';
        }

        return $fields;
    }
}
