<?php

namespace BabDev\TinyMCEField;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class FieldServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Nova::serving(function (ServingNova $event): void {
            Nova::script('tinymce-field', __DIR__ . '/../dist/js/field.js');
        });

        $this->publishes(
            [
                __DIR__ . '/../config/tinymce-field.php' => config_path('tinymce-field.php'),
            ],
            'config',
        );
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/tinymce-field.php', 'tinymce-field');
    }
}
