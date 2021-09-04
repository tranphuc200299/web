<?php

namespace Develops\_R\Supports\Utils;

use Develops\_R\Entities\Generator\FieldParams;

class JqueryBuilder
{
    /**
     * @param FieldParams[] $fieldParams
     * @return array
     */
    public static function getFilterJson(array $fieldParams)
    {
        $filter = [];
        foreach ($fieldParams as $key => $field) {
            if ($field->searchable) {
                $obj = new \stdClass();
                $obj->id = $field->name;
                $obj->label = $field->txtLabel;
                $obj->type = 'string';

                if (in_array($field->dbType, ['integer', 'smallInteger', 'bigInteger', 'increments'])) {
                    $obj->type = 'integer';
                }

                if (in_array($field->dbType, ['double', 'float', 'decimal'])) {
                    $obj->type = 'double';
                }

                if (in_array($field->dbType, ['date', 'dateTime', 'timestamp'])) {
                    $obj->type = 'date';
                    $validObj = new \stdClass();
                    $validObj->format = 'YYYY/MM/DD';
                    $obj->validation = $validObj;
                    $obj->plugin = 'datepicker';
                    $pluginConfig = new \stdClass();
                    $pluginConfig->format = 'yyyy/mm/dd';
                    $pluginConfig->todayBtn = 'linked';
                    $pluginConfig->todayHighlight = true;
                    $pluginConfig->autoclose = true;
                    $obj->plugin_config = $pluginConfig;
                }

                if (in_array($field->dbType, ['boolean'])) {
                    $obj->type = 'boolean';
                }

                $filter[] = $obj;
            }
        }

        return $filter;
    }
}