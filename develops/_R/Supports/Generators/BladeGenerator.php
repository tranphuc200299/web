<?php

namespace Develops\_R\Supports\Generators;

use Illuminate\Support\Str;
use Develops\_R\Entities\Generator\FieldParams;
use Develops\_R\Entities\Generator\GeneratorParams;
use Develops\_R\Entities\Generator\RelationParams;
use Develops\_R\Supports\Utils\FileUtil;
use Develops\_R\Supports\Utils\JqueryBuilder;

class BladeGenerator extends BaseGenerator
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

        $this->pathRoute = $params->getPath('/routes/');
        $this->pathResources = $params->getPath('/resources/');
    }

    public function generate()
    {
        if ($this->params->hasDatabase()) {
            $this->generateLayoutBlade();
            $this->generateIndexBlade();
            $this->generateCreateBlade();
            $this->generateEditBlade();
            $this->generateDetailBlade();
        } else {
            FileUtil::createFile($this->pathResources . 'views' . DIRECTORY_SEPARATOR . Str::lower($this->params->modelName) . DIRECTORY_SEPARATOR,
                'index.blade.php', 'Code here');
        }
    }

    private function generateLayoutBlade()
    {
        $templateData = get_blade_template('layout.blade');
        $templateData = fillTemplate($this->params, [
        ], $templateData);
        $fileName = 'layout.blade.php';
        FileUtil::createFile($this->pathResources . 'views' . DIRECTORY_SEPARATOR, $fileName, $templateData);
    }

    private function generateIndexBlade()
    {
        /*List*/
        $templateData = get_blade_template('index.blade');
        $templateData = fillTemplate($this->params, [
            '$LABELS$'      => $this->getLabels(),
            '$FIELDS$'      => $this->getFields(),
            '$FILTER_JSON$' => json_encode(JqueryBuilder::getFilterJson($this->params->fields), JSON_PRETTY_PRINT),
        ], $templateData);
        $fileName = 'index.blade.php';
        FileUtil::createFile($this->pathResources . 'views' . DIRECTORY_SEPARATOR . Str::lower($this->params->modelName) . DIRECTORY_SEPARATOR,
            $fileName, $templateData);
    }

    private function generateCreateBlade()
    {
        $templateData = get_blade_template('create.blade');
        $templateData = fillTemplate($this->params, [
            '$LABELS$' => $this->getLabels(),
            '$FIELDS$' => $this->getListFields('create'),
        ], $templateData);
        $fileName = 'create.blade.php';
        FileUtil::createFile($this->pathResources . 'views' . DIRECTORY_SEPARATOR . Str::lower($this->params->modelName) . DIRECTORY_SEPARATOR,
            $fileName, $templateData);
    }

    private function generateEditBlade()
    {
        /*Edit*/
        $templateData = get_blade_template('edit.blade');
        $templateData = fillTemplate($this->params, [
            '$LABELS$'        => $this->getLabels(),
            '$FIELDS$'        => $this->getListFields('edit'),
            '$RELATION_TABS$' => $this->getRelation(),
        ], $templateData);
        $fileName = 'edit.blade.php';
        FileUtil::createFile($this->pathResources . 'views' . DIRECTORY_SEPARATOR . Str::lower($this->params->modelName) . DIRECTORY_SEPARATOR,
            $fileName, $templateData);
    }

    private function generateDetailBlade()
    {
        $templateData = get_blade_template('show.blade');
        $templateData = fillTemplate($this->params, [
            '$LABELS$' => $this->getLabels(),
            '$FIELDS$' => $this->getListFields('view'),
            '$RELATION_TABS$' => $this->getRelation(),
        ], $templateData);
        $fileName = 'show.blade.php';
        FileUtil::createFile($this->pathResources . 'views' . DIRECTORY_SEPARATOR . Str::lower($this->params->modelName) . DIRECTORY_SEPARATOR,
            $fileName, $templateData);
    }

    private function getListFields($type = null)
    {
        $fieldsList = [];
        foreach ($this->params->fields as $field) {
            if ($field->primary ||
                $field->name == 'created_at' ||
                $field->name == 'updated_at' ||
                $field->name == 'deleted_at'
            ) {

            } else {
                $fieldsList[] = $this->genHtmlItem($field, $type);
            }
        }

        return implode("", $fieldsList);
    }

    public function getRelation()
    {
        $templateData = '';
        $relationList = [];
        foreach ($this->params->relations as $relation) {
            if ($relation->relationType == 'mt1_has_many') {
                $relationList[] = $relation;
            }
        }

        if (!empty($relationList)) {
            $templateData = fillTemplate($this->params, [
                '$RELATION_TABS$'     => $this->getRelationTabs($relationList),
                '$RELATION_CONTENTS$' => $this->getRelationContents($relationList),
            ], get_blade_template('relationship/RelationTab.blade'));

        }

        return $templateData;
    }

    /**
     * @param RelationParams[] $relationList
     *
     * @return string
     */
    public function getRelationTabs(array $relationList)
    {
        $first = true;
        $templateData = '';
        foreach ($relationList as $relation) {
            $options = [
                '$RELATION_TAB$' => $relation->foreignModel,
                '$ACTIVE$'       => '',
            ];
            if ($first == true) {
                $options['$ACTIVE$'] = 'active';
                $first = false;
            }

            $templateData .= fillTemplate($this->params, $options,
                get_blade_template('relationship/_partials/tab.blade'));
        }


        return $templateData;
    }

    /**
     * @param RelationParams[] $relationList
     *
     * @return string
     */
    public function getRelationContents(array $relationList)
    {
        $first = true;
        $templateData = '';
        foreach ($relationList as $relation) {
            $options = [
                '$RELATION_TAB$' => $relation->foreignModel,
                '$RELATION_MODEL$' => $relation->foreignModel,
                '$RELATION_ROUTE$' => Str::plural(strtolower($relation->foreignModel)),
                '$ACTIVE$'       => '',
                '$RELATION_MODEL_NAME$' => $relation->getRelationName(),
                '$DISPLAY_NAME$' => $relation->displayName,
                '$DISPLAY_FIELD$' => $relation->displayField,
            ];
            if ($first == true) {
                $options['$ACTIVE$'] = 'active';
                $first = false;
            }

            $templateData .= fillTemplate($this->params, $options,
                get_blade_template('relationship/_partials/tab-content.blade'));
        }


        return $templateData;
    }

    private function genHtmlItem(FieldParams $field, $type = 'create')
    {
        $template = '';
        $options = [
            '$ATTR_REQUIRED$' => '',
            '$ATTR_EDITABLE$' => '',
            '$ATTR_CHECKED$' => '',
            '$REQUIRED$'      => '',
            '$FIELD_NAME$'    => $field->name,
            '$FIELD_LABEL$'   => $field->getLabel(),
            '$VALUE$'         => '',
        ];

        if (!$field->nullable) {
            $options['$ATTR_REQUIRED$'] = 'required="required" ';
            $options['$REQUIRED$'] = get_blade_template('element/_partials/required.blade');
        }

        if ($type == 'edit') {
            $options['$VALUE$'] = '{{ $model->' . $field->name . ' }}';
        }

        if ($type == 'view') {
            $options['$VALUE$'] = '{{ $model->' . $field->name . ' }}';
            $options['$ATTR_EDITABLE$'] = 'disabled ';
        }

        switch ($field->htmlType) {
            case 'text':
                $template = get_blade_template('element/input_text.blade');
                break;
            case 'email':
                $template = get_blade_template('element/input_email.blade');
                break;
            case 'number':
                $template = get_blade_template('element/input_number.blade');
                break;
            case 'password':
                $template = get_blade_template('element/input_pass.blade');
                break;
            case 'textArea':
                $template = get_blade_template('element/input_textarea.blade');
                break;
            case 'editor':
                $template = get_blade_template('element/input_textarea.blade');
                break;
            case 'date':
                $template = get_blade_template('element/picker_date.blade');
                break;
            case 'datetime':
                $template = get_blade_template('element/picker_datetime.blade');
                break;
            case 'time':
                $template = get_blade_template('element/picker_time.blade');
                break;
            case 'file':
                $template = get_blade_template('element/file-upload.blade');
                break;
            case 'image':
                $template = get_blade_template('element/image-upload.blade');
                break;
            case 'select':
                $options['$OPTIONS$'] = $this->getSelect($field, $options, $type);
                $template = get_blade_template('element/select.blade');
                break;
            case 'radio':
                $options['$RADIO_LIST$'] = $this->getRadio($field, $options, $type);
                $template = get_blade_template('element/radio.blade');
                break;
            case 'checkbox':
                $options['$CHECK_BOX_LIST$'] = $this->getCheckbox($field, $options, $type);
                $template = get_blade_template('element/checkbox.blade');
                break;
            case 'toggle-switch':
                if ($type == 'view' || $type == 'edit') {
                    $options['$ATTR_CHECKED$'] = '@if(!empty($model->$FIELD_NAME$)) checked @endif';
                }

                $template = fillTemplate($this->params, $options, get_blade_template('element/switch.blade'));
                break;
            case 'select2-jax':
                foreach ($this->params->relations as $relation) {
                    if (($relation->relationType == '1t1_belongs_to' || $relation->relationType == 'mt1_belongs_to') && $relation->foreignKey == $field->name) {

                        $options['$RELATION_NAME$'] = $relation->getRelationName();
                        $options['$FIELD_DISPLAY$'] = $relation->displayField;
                        $options['$RELATION_ROUTES$'] = $relation->getRelationRoute();
                        $template = get_blade_template('element/select2-ajax.blade');
                        break;
                    }
                }

                break;
        }

        $html = fillTemplate($this->params, $options, $template);

        return $html;
    }

    private function getRadio(FieldParams $field, $options, $type)
    {
        $str = '';

        foreach ($field->getValueList() as $item) {
            $options['$KEY$'] = $item['key'];
            $options['$LABEL$'] = $item['label'];
            $html = fillTemplate($this->params, $options, get_blade_template('element/_partials/radio.blade'));

            if($type == 'edit' || $type == 'view') {
                $html = fillTemplate($this->params, $options, get_blade_template('element/_partials/radio-edit.blade'));
            }

            $str .= $html;
        }

        return $str;
    }

    private function getSelect(FieldParams $field, $options, $type)
    {
        $str = '';

        foreach ($field->getValueList() as $item) {
            $options['$KEY$'] = $item['key'];
            $options['$LABEL$'] = $item['label'];
            $html = fillTemplate($this->params, $options, get_blade_template('element/_partials/option.blade'));

            if($type == 'edit' || $type == 'view') {
                $html = fillTemplate($this->params, $options, get_blade_template('element/_partials/option-edit.blade'));
            }
            $str .= $html;
        }

        return $str;
    }

    private function getCheckbox(FieldParams $field, $options, $type)
    {
        $str = '';

        foreach ($field->getValueList() as $item) {
            $options['$KEY$'] = $item['key'];
            $options['$LABEL$'] = $item['label'];
            $html = fillTemplate($this->params, $options, get_blade_template('element/_partials/checkbox.blade'));
            if($type == 'edit' || $type == 'view') {
                $html = fillTemplate($this->params, $options, get_blade_template('element/_partials/checkbox-edit.blade'));
            }
            $str .= $html;
        }

        return $str;
    }

    private function getLabels()
    {
        $fieldsList = [];
        foreach ($this->params->fields as $field) {
            if (!empty($field->inIndex)) {
                if (!empty($field->txtLabel)) {
                    $fieldsList[] = fillTemplate($this->params, [
                        '$TH$' => Str::ucfirst($field->txtLabel)
                    ], get_blade_template('table/th.blade'));
                } else {
                    $fieldsList[] = fillTemplate($this->params, [
                        '$TH$' => Str::ucfirst($field->name)
                    ], get_blade_template('table/th.blade'));
                }
            }
        }

        return implode("\n" . infy_tabs(10), $fieldsList);
    }

    private function getFields()
    {
        $fieldsList = [];
        foreach ($this->params->fields as $field) {
            if (!empty($field->inIndex)) {

                if ($field->name == 'created_by') {
                    $fieldsList[] = fillTemplate($this->params, [
                        '$TD$' => '{{ $item->owner->name?? \'\'}}'
                    ], get_blade_template('table/td.blade'));
                    continue;
                }

                $break = false;
                foreach ($this->params->relations as $relation) {
                    if ($relation->isSingleRelation() && $field->name == $relation->foreignKey) {
                        $value = '{{ $item->' . $relation->getRelationName() . '->' . $relation->displayField . '?? \'\'}}';

                        $fieldsList[] = fillTemplate($this->params, [
                            '$TD$' => $value
                        ], get_blade_template('table/td.blade'));

                        $break = true;
                    }
                }

                if ($break) {
                    continue;
                }

                if (in_array($field->htmlType, ['select', 'radio'])) {
                    $str = "@php \$arr_{$field->name} = [";
                    foreach ($field->getValueList() as $item){
                        $str .= "'{$item['key']}' => '{$item['label']}',";
                    }

                    $str .= "]@endphp\n".infy_tabs(11);
                    $value = $str."{{\$arr_{$field->name}[\$item->{$field->name}] ?? null}}\n".infy_tabs(11);
                    $fieldsList[] = fillTemplate($this->params, [
                        '$TD$' => $value
                    ], get_blade_template('table/td.blade'));
                    continue;
                }

                if (in_array($field->htmlType, ['checkbox'])) {
                    $str = "@php \$arr_{$field->name} = [";
                    foreach ($field->getValueList() as $item){
                        $str .= "'{$item['key']}' => '{$item['label']}',";
                    }

                    $str .= "]@endphp\n".infy_tabs(11);
                    $value = $str.
                        "@if(is_array(\$item->{$field->name}))"."\n".infy_tabs(12).
                        "@foreach(\$item->{$field->name} as \$key)"."\n".infy_tabs(13).
                        "{{\$arr_{$field->name}[\$key] ?? null}}"."\n".infy_tabs(12).
                        '@endforeach'."\n".infy_tabs(11).
                        '@endif'."\n".infy_tabs(11).
                        "\n".infy_tabs(11);

                    $fieldsList[] = fillTemplate($this->params, [
                        '$TD$' => $value
                    ], get_blade_template('table/td.blade'));
                    continue;
                }

                if (in_array($field->htmlType, ['toggle-switch'])) {
                    $value = '@if($item->' . $field->name . ') <i class="fa fa-check"></i> @endif';
                    $fieldsList[] = fillTemplate($this->params, [
                        '$TD$' => $value
                    ], get_blade_template('table/td.blade'));
                    continue;
                }

                if (in_array($field->htmlType, ['image'])) {
                    $value = '@if($item->' . $field->name . ') <img src="{{ Storage::url($item->'.$field->name.') }}" height="30px"/>@endif';
                    $fieldsList[] = fillTemplate($this->params, [
                        '$TD$' => $value
                    ], get_blade_template('table/td.blade'));
                    continue;
                }

                if (in_array($field->htmlType, ['file'])) {
                    $value = '@if($item->' . $field->name . ') <a href="{{ Storage::url($item->'.$field->name.') }}" target="_blank">Download</a> @endif';
                    $fieldsList[] = fillTemplate($this->params, [
                        '$TD$' => $value
                    ], get_blade_template('table/td.blade'));
                    continue;
                }

                if (in_array($field->dbType, ['text', 'mediumText', 'longText'])) {
                    $value = '{{ Str::limit(strip_tags($item->' . $field->name . '), 50, \'...\') }}';
                    $fieldsList[] = fillTemplate($this->params, [
                        '$TD$' => $value
                    ], get_blade_template('table/td.blade'));
                } else {
                    $value = '{{$item->' . $field->name . '}}';
                    $fieldsList[] = fillTemplate($this->params, [
                        '$TD$' => $value
                    ], get_blade_template('table/td.blade'));
                }
            }
        }

        return implode("\n" . infy_tabs(11), $fieldsList);
    }
}
