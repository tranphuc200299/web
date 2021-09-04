<?php

namespace Develops\_R\Entities\Generator;

use Illuminate\Support\Str;
use Develops\_R\Constants\EntityConst;

class GeneratorParams
{
    /**
     * @var string
     */
    public $moduleName;

    /**
     * @var string
     */
    public $modelName;

    /**
     * @var string
     */
    public $tableName;

    /**
     * @var string
     */
    public $listView;

    /**
     * @var string
     */
    public $childView;

    /**
     * @var string
     */
    public $icon;

    /**
     * @var string
     */
    public $group;

    /**
     * @var string
     */
    public $userRelation;

    /**
     * @var string
     */
    public $ownerRelation;

    /**
     * @var string
     */
    public $fakerLanguage;

    /**
     * @var boolean
     */
    public $migrate;

    /**
     * @var array
     */
    public $options;

    /**
     * @var array
     */
    public $addOns;

    /**
     * @var FieldParams[]
     */
    public $fields = [];

    /**
     * @var RelationParams[]
     */
    public $relations = [];

    /**
     * @var
     */
    private $data;

    /**
     * GeneratorParams constructor.
     * @param  array  $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;

        foreach ($data as $property => $value) {

            if ($property == 'fields' && is_array($value)) {
                foreach ($value as $field) {
                    $this->fields[] = new FieldParams($field);
                }

                continue;
            }

            if ($property == 'relations' && is_array($value)) {
                foreach ($value as $field) {
                    $this->relations[] = new RelationParams($field);
                }

                continue;
            }

            if (property_exists(self::class, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    public function valid()
    {
        if (!$this->modelName) {
            throw new \Exception('Property [modelName] not found!');
        }
    }

    public function hasDatabase()
    {
        if (empty($this->tableName) || empty($this->fields)) {
            return false;
        }

        return true;
    }

    public function getStatus()
    {
        if ($this->hasDatabase()) {
            return EntityConst::NOT_MIGRATE;
        }

        return EntityConst::NO_DATABASE;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getTable()
    {
        return $this->options['prefix'].'_'.$this->tableName;
    }

    public function getNameSpace()
    {
        return 'Modules\\'.$this->moduleName;
    }

    public function getPath($path = '')
    {
        return module_path($this->moduleName.DIRECTORY_SEPARATOR.$path);
    }

    public function getLowerName()
    {
        return strtolower($this->modelName);
    }
}
