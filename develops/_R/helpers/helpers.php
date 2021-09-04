<?php

use Illuminate\Support\Str;
use Develops\_R\Supports\Common\GeneratorField;

if (!function_exists('package_path')) {
    function package_path($path = '')
    {
        return app()->basePath('') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (!function_exists('module_path')) {
    function module_path($path = '')
    {
        return package_path('modules') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}


if (!function_exists('dev_path')) {
    function dev_path($path = '')
    {
        return package_path('develops') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (!function_exists('infy_tab')) {
    /**
     * Generates tab with spaces.
     *
     * @param int $spaces
     *
     * @return string
     */
    function infy_tab($spaces = 4)
    {
        return str_repeat(' ', $spaces);
    }
}

if (!function_exists('infy_tabs')) {
    /**
     * Generates tab with spaces.
     *
     * @param int $tabs
     * @param int $spaces
     *
     * @return string
     */
    function infy_tabs($tabs, $spaces = 4)
    {
        return str_repeat(infy_tab($spaces), $tabs);
    }
}

if (!function_exists('infy_nl')) {
    /**
     * Generates new line char.
     *
     * @param int $count
     *
     * @return string
     */
    function infy_nl($count = 1)
    {
        return str_repeat(PHP_EOL, $count);
    }
}

if (!function_exists('infy_nls')) {
    /**
     * Generates new line char.
     *
     * @param int $count
     * @param int $nls
     *
     * @return string
     */
    function infy_nls($count, $nls = 1)
    {
        return str_repeat(infy_nl($nls), $count);
    }
}

if (!function_exists('infy_nl_tab')) {
    /**
     * Generates new line char.
     *
     * @param int $lns
     * @param int $tabs
     *
     * @return string
     */
    function infy_nl_tab($lns = 1, $tabs = 1)
    {
        return infy_nls($lns) . infy_tabs($tabs);
    }
}

if (!function_exists('get_template_file_path')) {
    /**
     * get path for template file.
     *
     * @param string $templateName
     * @param string $templateType
     *
     * @return string
     */
    function get_template_file_path($path)
    {
        return dev_path('_R/resources/templates' . DIRECTORY_SEPARATOR) . $path . '.stub';
    }
}

if (!function_exists('get_templates_package_path')) {
    /**
     * Finds templates package's full path.
     *
     * @param string $templateType
     *
     * @return string
     */
    function get_templates_package_path($templateType)
    {
        if (strpos($templateType, '/') === false) {
            $templateType = base_path('vendor/infyomlabs/') . $templateType;
        }

        return $templateType;
    }
}

if (!function_exists('get_template')) {
    function get_template($path)
    {
        $fullPath = get_template_file_path($path);

        return file_get_contents($fullPath);
    }
}

if (!function_exists('get_blade_template')) {

    function get_blade_template($path)
    {
        $templateName = 'views/' . config('view.template');
        $fullPath = get_template_file_path($templateName . '/' . $path);

        return file_get_contents($fullPath);
    }
}

if (!function_exists('fillTemplate')) {
    /**
     * @param \Develops\_R\Entities\Generator\GeneratorParams $params
     * @param $variables
     * @param $template
     *
     * @return mixed
     */
    function fillTemplate(\Develops\_R\Entities\Generator\GeneratorParams $params, $variables, $template)
    {
        $baseVariables = [
            '$MODULE$'              => $params->moduleName,
            '$MODULE_LOWER$'        => strtolower($params->moduleName),
            '$MODULE_LOWER_PLURAL$' => Str::plural(strtolower($params->moduleName)),
            '$MODEL$'               => $params->modelName,
            '$MODEL_LOWER$'         => strtolower($params->modelName),
            '$MODEL_LOWER_PLURAL$'  => Str::plural(strtolower($params->modelName)),
            '$TABLE$'               => $params->getTable(),
            '$LANG$'                => $params->fakerLanguage ? "'" . $params->fakerLanguage . "'" : '',
            '$TABLE_NAME$'          => $params->getTable(),
            '$TABLE_NAME_TITLE$'    => Str::studly($params->getTable()),
            '$GROUP$'               => $params->group ?? '',
            '$ICON$'                => $params->icon ?? 'table',
            '$VIEW_NAME_SPACE$'     => strtolower($params->moduleName),
            '$ROUTE_NAME$'          => 'cp.' . Str::plural(strtolower($params->modelName)) . '.index',
            '$MODEL_ID$'            => Str::lower($params->modelName) . "_id",
            '$NAME_SPACE$'          => strtolower($params->modelName),
            '$NAME_SPACES$'         => Str::plural(strtolower($params->modelName)),
            '$SERVICE_VAR$'         => Str::camel($params->modelName),
            '$PAGE$'                => $params->options['paginate'] ? ", " . $params->options['paginate'] : '',
            '$ROUTES$'              => Str::plural(strtolower($params->modelName)),
            '$VIEW_NAMESPACE$'      => strtolower($params->modelName),
            '$MODEL_NAME_PLURAL$'   => Str::plural(strtolower($params->modelName)),
            '$AUTH$'                => empty($params->addOns['auth']) ? "" : "'auth'",
        ];

        $variables = array_merge($variables, $baseVariables);

        foreach ($variables as $variable => $value) {
            $template = str_replace($variable, $value, $template);
        }

        return $template;
    }
}


if (!function_exists('model_name_from_table_name')) {
    /**
     * generates model name from table name.
     *
     * @param string $tableName
     *
     * @return string
     */
    function model_name_from_table_name($tableName)
    {
        return Str::ucfirst(Str::camel(Str::singular($tableName)));
    }
}
