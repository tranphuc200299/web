<?php

namespace Develops\_R\Supports\Generators;

use Develops\_R\Entities\Generator\GeneratorParams;
use Develops\_R\Entities\Generator\RelationParams;
use Develops\_R\Supports\Common\CommandData;
use Develops\_R\Supports\Utils\FileUtil;

class ModelGenerator extends BaseGenerator
{
    /**
     * Fields not included in the generator by default.
     *
     * @var array
     */
    protected $excluded_fields = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $fileName;
    private $table;

    /**
     * @var GeneratorParams
     */
    private $params;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $pathRepository;

    /**
     * @var string
     */
    private $pathService;

    public function __construct(GeneratorParams $params)
    {
        $this->params = $params;
        $this->table = $this->params->options['prefix'] . '_' . $this->params->tableName;
        $this->path = $params->getPath('Entities/Models/');
        $this->pathRepository = $params->getPath('Repositories/');
        $this->pathService = $params->getPath('Services/');
    }

    public function generate()
    {
        if (!$this->params->hasDatabase()) {
            return false;
        }

        $this->generateModel();
        $this->generateRepository();
        $this->generateService();
    }

    public function generateModel()
    {
        $templateData = get_template('model/model');

        $templateData = fillTemplate($this->params, [
            '$FILLABLE$' => $this->getFillable(),
            '$CAST$' => $this->getCast(),
            '$RELATIONS$' => $this->generateRelations()
        ], $templateData);

        $fileName = $this->params->modelName . 'Model.php';

        FileUtil::createFile($this->path, $fileName, $templateData);
    }

    public function getFillable()
    {
        $inform = [];

        foreach ($this->params->fields as $field) {
            if ($field->inForm) {
                $inform[] = "'".$field->name."'";
            }
        }

        return implode(", ", $inform);
    }

    public function getCast()
    {
        $cast = [];

        foreach ($this->params->fields as $field) {
            if ($field->htmlType == 'checkbox') {
                $cast[] = "'" . $field->name . "' => 'array'";
            }

            if ($field->htmlType == 'toggle-switch') {
                $cast[] = "'" . $field->name . "' => 'boolean'";
            }
        }

        return implode(",\n        ", $cast);
    }

    public function generateRepository()
    {
        $templateData = get_template('model/repository');

        $templateData = fillTemplate($this->params, [], $templateData);

        $fileName = $this->params->modelName . 'Repository.php';

        FileUtil::createFile($this->pathRepository, $fileName, $templateData);
    }

    public function generateService()
    {
        $templateData = get_template('model/service');

        $templateData = fillTemplate($this->params, [], $templateData);

        $fileName = $this->params->modelName . 'Service.php';

        FileUtil::createFile($this->pathService, $fileName, $templateData);
    }

    private function generateRelations()
    {
        $relations = '';

        foreach ($this->params->fields as $field) {
            if ($field->name == 'created_by') {
                $relations .= $this->hasOwner();
            }
        }

        foreach ($this->params->relations as $relation) {
            if (!$relation->foreignModel) {
                continue;
            }

            switch ($relation->relationType) {
                case '1t1_has_one':
                    $relations .= $this->hasOne($relation);
                    break;
                case '1t1_belongs_to':
                    $relations .= $this->belongsTo_11($relation);
                    break;
                case 'mt1_has_many':
                    $relations .= $this->hasMany($relation);
                    break;
                case 'mt1_belongs_to':
                    $relations .= $this->belongsTo_m1($relation);
                    break;
                case 'mtm_belongs_to_many':
                    $relations .= $this->belongsToMany($relation);
                    break;
            }
        }

        return $relations;
    }

    public function hasOneUser()
    {
        $templateData = get_template('model/relationship/hasOneUser');

        $templateData = fillTemplate($this->params, [
            '$RELATION_ID$' => 'user_id',
        ], $templateData);

        return $templateData;
    }

    public function hasOwner()
    {
        $templateData = get_template('model/relationship/owner');

        $templateData = fillTemplate($this->params, [
            '$RELATION_ID$' => 'created_by',
        ], $templateData);

        return $templateData;
    }

    public function hasManyUser()
    {
        $templateData = get_template('model/relationship/hasManyUser');

        $templateData = fillTemplate($this->params, [
            '$RELATION_ID$' => 'user_id',
        ], $templateData);

        return $templateData;
    }

    private function hasOne(RelationParams $relation)
    {
        $templateData = get_template('model/relationship/relationship');

        $templateData = fillTemplate($this->params, [
            '$RELATION_NAME$' => $relation->getRelationName(),
            '$RELATION_TYPE$' => 'hasOne(\'' . $relation->getNameSpace() . '\', \'' . $relation->foreignKey . '\', \'' . $relation->localKey . '\')'
        ], $templateData);

        return $templateData;
    }

    private function belongsTo_11(RelationParams $relation)
    {
        $templateData = get_template('model/relationship/relationship');

        $templateData = fillTemplate($this->params, [
            '$RELATION_NAME$' => $relation->getRelationName(),
            '$RELATION_TYPE$' => 'belongsTo(\'' . $relation->getNameSpace() . '\', \'' . $relation->foreignKey . '\', \'' . $relation->localKey . '\')'
        ], $templateData);

        return $templateData;
    }

    private function hasMany(RelationParams $relation)
    {
        $templateData = get_template('model/relationship/relationship');

        $templateData = fillTemplate($this->params, [
            '$RELATION_NAME$' => $relation->getRelationName(),
            '$RELATION_TYPE$' => 'hasMany(\'' . $relation->getNameSpace() . '\', \'' . $relation->foreignKey . '\', \'' . $relation->localKey . '\')'
        ], $templateData);

        return $templateData;
    }

    private function belongsTo_m1(RelationParams $relation)
    {
        $templateData = get_template('model/relationship/relationship');

        $templateData = fillTemplate($this->params, [
            '$RELATION_NAME$' => $relation->getRelationName(),
            '$RELATION_TYPE$' => 'belongsTo(\'' . $relation->getNameSpace() . '\', \'' . $relation->foreignKey . '\', \'' . $relation->localKey . '\')'
        ], $templateData);

        return $templateData;
    }

    private function belongsToMany(RelationParams $relation)
    {
        $templateData = get_template('model/relationship/relationship');

        $templateData = fillTemplate($this->params, [
            '$RELATION_NAME$' => $relation->getRelationName(),
            '$RELATION_TYPE$' => 'belongsToMany(\'' . $relation->getNameSpace() . '\')'
        ], $templateData);

        return $templateData;
    }
}
