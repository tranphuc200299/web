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
        if($path){
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