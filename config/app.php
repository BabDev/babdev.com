<?php

use Illuminate\Support\Facades\Facade;

return [

    'domain' => env('APP_DOMAIN_NAME'),

    'filament_domain' => env('FILAMENT_DOMAIN'),

    'timezone' => 'UTC',

    'aliases' => Facade::defaultAliases()->merge([
        // ...
    ])->toArray(),

];
