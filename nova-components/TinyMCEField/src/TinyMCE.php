<?php

namespace BabDev\TinyMCEField;

use Laravel\Nova\Fields\Field;

class TinyMCE extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'tinymce-field';

    public function __construct(string $name, $attribute = null)
    {
        parent::__construct($name, $attribute);

        $this->withMeta([
            'options' => config('tinymce-field.options', []),
        ]);
    }

    public function options(array $options): static
    {
        $inlineOptions = $this->meta['options'] ?? [];

        return $this->withMeta([
            'options' => array_merge($inlineOptions, $options),
        ]);
    }

    /**
     * Set the field's id HTML attribute
     */
    public function id(string $id): static
    {
        return $this->withMeta([
            'id' => $id,
        ]);
    }

    /**
     * Set the field name.
     */
    public function name(string $name): static
    {
        return $this->withMeta([
            'name' => $name,
        ]);
    }
}
