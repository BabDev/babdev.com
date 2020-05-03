<?php

namespace BabDev\NovaCKEditor4Field;

use Laravel\Nova\Fields\Expandable;
use Laravel\Nova\Fields\Field;

class CKEditor4 extends Field
{
    use Expandable;

    public $component = 'nova-ckeditor4-field';

    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->withMeta(
            [
                'editorConfig' => config('nova-ckeditor4-field.config', []),
                'editorDistribution' => config('nova-ckeditor4-field.distribution', 'standard-all'),
                'editorVersion' => config('nova-ckeditor4-field.version', '4.14.0'),
            ]
        );
    }

    public function config(array $config)
    {
        return $this->withMeta(
            [
                'editorConfig' => \array_merge($this->meta['editorConfig'] ?? [], $config),
            ]
        );
    }

    public function jsonSerialize()
    {
        return \array_merge(
            parent::jsonSerialize(),
            [
                'shouldShow' => $this->shouldBeExpanded(),
            ]
        );
    }
}
