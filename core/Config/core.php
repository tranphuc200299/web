<?php

return [
    'enable_dev_module' => env('DEV_MODULE'),
    'enable_view_log' => env('VIEW_LOG'),
    'auth' => [
        'google' => env('GOOGLE_AUTH'),
        'facebook' => env('FACEBOOK_AUTH'),
        'github' => env('GITHUB_AUTH'),
    ]
];