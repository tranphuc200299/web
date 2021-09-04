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