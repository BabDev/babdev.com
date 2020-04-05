<?php

namespace BabDev\NovaCKEditor4Field;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class FieldServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Nova::serving(
            static function (ServingNova $event): void {
                Nova::script('nova-ckeditor4-field', __DIR__ . '/../dist/js/field.js');
            }
        );

        $this->publishes(
            [
                __DIR__ . '/../config/nova-ckeditor4-field.php' => config_path('nova-ckeditor4-field.php'),
            ],
            'config'
        );
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/nova-ckeditor4-field.php', 'nova-ckeditor4-field');
    }
}
