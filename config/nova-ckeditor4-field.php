<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Editor Version
    |--------------------------------------------------------------------------
    |
    | Here you may specify which version of the CKEditor to use with this field.
    | Any version available on cdn.ckeditor.com can be used here. The default
    | version is the newest version available as of the last release.
    |
    */

    'version' => env('NOVA_CKEDITOR4_EDITOR_VERSION', '4.14.0'),

    /*
    |--------------------------------------------------------------------------
    | Editor Distribution
    |--------------------------------------------------------------------------
    |
    | CKEditor is available in several distributions, in this spot you can
    | set the distribution used in your application.
    |
    | Available Options Are: "basic", "standard", "standard-all",
    |                        "full", "full-all"
    |
    */

    'distribution' => env('NOVA_CKEDITOR4_EDITOR_DISTRIBUTION', 'standard-all'),

    /*
    |--------------------------------------------------------------------------------
    | Editor Configuration
    |--------------------------------------------------------------------------------
    |
    | Here you may define a default configuration for all editors in your application.
    |
    | Please review https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html
    | for information on the available configuration.
    |
    */

    'config' => [],
];
