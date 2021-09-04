<?php

namespace Develops\_R\Supports\Generators;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Develops\_R\Entities\Generator\GeneratorParams;
use Develops\_R\Entities\Models\Entities;
use Develops\_R\Supports\Utils\FileUtil;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MigrationGenerator extends BaseGenerator
{
    /**
     * @var GeneratorParams
     */
    private $params;

    /** @var string */
    private $path;

    /**
     * @var array
     */
    private $migrateFile;

    public function __construct(GeneratorParams $params)
    {
        $this->params = $params;
        $this->path = $params->getPath('/Database/Migrations/');
    }

    public function generate(Entities $entity)
    {
        if ($entity->migration_files_json) {
            $migratesFile = json_decode($entity->migration_files_json);
            foreach ($migratesFile as $file) {
                File::delete(app()->basePath('modules/' . $this->params->moduleName . '/Database/Migrations/' . $file));
            }
        }

        $this->generateMainTable();
        $this->generateModelRelation();

        return $this;
    }

    public function save(Entities $entity)
    {
        $entity->migration_files_json = json_encode($this->migrateFile);
        $entity->save();
    }

    public function generateMainTable()
    {
        if (!$this->params->hasDatabase()) {
            return false;
        }

        $templateData = get_template('model/migration/module');
        $tableName = $this->params->getTable();

        $templateData = fillTemplate($this->params, [
            '$FIELDS$' => $this->generateFields()
        ], $templateData);

        $fileName = date('Y_m_d_His').'_'.'create_'.strtolower($tableName).'_table'.".php";
        $this->migrateFile[] = $fileName;

        FileUtil::createFile($this->path, $fileName, $templateData);

        return true;
    }

    public function generateUserRelation()
    {
        if (!$this->params->hasDatabase() || $this->params->userRelation !== 'has_many') {
            return false;
        }

        $templateData = get_template('model/migration/module_users');

        $tableName = 'dt_'.$this->params->tableName.'_users';

        $templateData = fillTemplate($this->params, [
            '$TABLE_NAME$'       => $tableName,
            '$MODEL_ID$' => Str::lower($this->params->modelName)."_id"
        ], $templateData);

        $fileName = date('Y_m_d_His', time() + 1).'_'.'create_'.strtolower($tableName).'_table'.".php";

        FileUtil::createFile($this->path, $fileName, $templateData);

        return true;
    }

    public function generateModelRelation()
    {
        if (!$this->params->hasDatabase()) {
            return false;
        }

        // TODO
    }

    private function generateFields()
    {
        $fields = '';
        $timestampField = [];
        foreach ($this->params->fields as $field) {
            $column = $field->name;
            $dbType = $field->dbType;
            $isNullable = $field->nullable ?? false;
            $isUnique = $field->unique ?? false;
            $default = $field->defaultValue ?? false;

            if (($column == 'created_at' || $column == 'updated_at')) {
                $timestampField[] = $column;
                continue;
            }

            if ($column == 'created_by') {
                $fields .= $this->generateField('created_by', 'integer', true, false);
                continue;
            }

            switch ($dbType) {
                case 'increments':
                    $fields .= $this->generateField($column, 'increments', false, false, $default);
                    break;
                case 'integer':
                    $fields .= $this->generateField($column, 'integer', $isNullable, $isUnique, $default);
                    break;
                case 'smallint':
                    $fields .= $this->generateField($column, 'smallInteger', $isNullable, $isUnique, $default);
                    break;
                case 'bigint':
                    $fields .= $this->generateField($column, 'bigInteger', $isNullable, $isUnique, $default);
                    break;
                case 'boolean':
                    $fields .= $this->generateField($column, 'boolean', $isNullable, $isUnique, $default);
                    break;
                case 'datetime':
                    $fields .= $this->generateField($column, 'datetime', $isNullable, $isUnique, $default);
                    break;
                case 'datetimetz':
                    $fields .= $this->generateField($column, 'dateTimeTz', $isNullable, $isUnique, $default);
                    break;
                case 'date':
                    $fields .= $this->generateField($column, 'date', $isNullable, $isUnique, $default);
                    break;
                case 'time':
                    $fields .= $this->generateField($column, 'time', $isNullable, $isUnique, $default);
                    break;
                case 'timeTz':
                    $fields .= $this->generateField($column, 'timeTz', $isNullable, $isUnique, $default);
                    break;
                case 'decimal':
                    $fields .= $this->generateField($column, 'decimal', $isNullable, $isUnique, $default);
                    break;
                case 'float':
                    $fields .= $this->generateField($column, 'float', $isNullable, $isUnique, $default);
                    break;
                case 'string':
                    $fields .= $this->generateField($column, 'string', $isNullable, $isUnique, $default);
                    break;
                case 'text':
                    $fields .= $this->generateField($column, 'text', $isNullable, $isUnique, $default);
                    break;
                case 'timestamp':
                    $fields .= $this->generateField($column, 'timestamp', $isNullable, $isUnique, $default);
                    break;
                case 'timestampTz':
                    $fields .= $this->generateField($column, 'timestampTz', $isNullable, $isUnique, $default);
                    break;
                default:
                    $fields .= $this->generateField($column, 'string', $isNullable, $isUnique, $default);
                    break;
            }
        }

        if ($this->params->options['softDelete']) {
            $fields .= $this->generateField('deleted_at', 'timestamp', true, false);
        }

        foreach ($timestampField as $column) {
            $fields .= $this->generateField($column, 'timestamp', true, false);
        }

        return $fields;
    }

    private function generateField($column, $dbType, $isNullable = false, $isUnique = false, $default = false)
    {
        $str = infy_tabs(3).'$table->'.$dbType."('$column')";

        if ($isNullable) {
            $str .= '->nullable()';
        }

        if ($isUnique) {
            $str .= '->unique()';
        }

        if ($default !== false) {
            $str .= "->default('$default')";
        }

        $str .= ";\n";
        return $str;
    }
}
