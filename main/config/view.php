<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most view files are stored on your disk. Specify the path locations
    | to store any compiled view files for your application. Usually it
    | is set to the default storage directory as well, but if you wish
    | to change this to another location, you may do so right here.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored. Typically, this is within the storage directory. However, as
    | usual, you may change it to any other location or rename it if you.
    |
    */

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),

];
