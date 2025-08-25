<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Ziggy Configuration
    |--------------------------------------------------------------------------
    |
    | This configuration controls how Ziggy generates its JavaScript file.
    | The output.path specifies where the generated Ziggy route file will
    | be saved. This file contains your Laravel routes for frontend use.
    |
    */

    'output' => [
        'path' => resource_path('ziggy.js'),
    ],

];
