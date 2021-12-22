<?php

function is_json($string)
{
    json_decode($string);

    return (json_last_error() == JSON_ERROR_NONE);
}

if (!function_exists('activity')) {
    /**
     * @return \Core\Services\Activity\ActivityService
     */
    function activity()
    {
        return app(\Core\Services\Activity\ActivityService::class);
    }
}

if (!function_exists('storage_url')) {
    function storage_url($path)
    {
        if ($path) {
            /** @phpstan-ignore-next-line */
            return \Illuminate\Support\Facades\Storage::url($path);
        }

        return '';
    }
}

if (!function_exists('public_url')) {
    function public_url($path)
    {
        if ($path) {
            return asset($path);
        }

        return '';
    }
}

if (!function_exists('back_link')) {
    function back_link()
    {
        return url()->previous();
    }
}

if (!function_exists('route_wildcard')) {

    function route_wildcard($routeName, $level = 2)
    {
        $routeLevel = explode('.', $routeName);
        $wildcard = '';

        for ($i = 0; $i < $level; $i++) {
            if (isset($routeLevel[$i])) {
                $wildcard .= $routeLevel[$i];
                if ($i !== ($level - 1)) {
                    $wildcard .= '.';
                }
            }
        }

        return $wildcard . '*';
    }
}

if (!function_exists('route_active')) {

    function route_active_group($routes)
    {
        foreach ($routes as $route) {
            if (route_active(route_wildcard($route))) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('begin_transaction')) {
    function begin_transaction()
    {
        \Illuminate\Support\Facades\DB::beginTransaction();
    }
}

if (!function_exists('commit_transaction')) {
    function commit_transaction()
    {
        \Illuminate\Support\Facades\DB::commit();
    }
}

if (!function_exists('rollback_transaction')) {
    function rollback_transaction()
    {
        \Illuminate\Support\Facades\DB::rollBack();
    }
}

if (!function_exists('route_active')) {

    function route_active($route)
    {
        return request()->routeIs($route);
    }
}

if (!function_exists('get_tenant_id')) {
    function get_tenant_id()
    {
        return null;
    }
}