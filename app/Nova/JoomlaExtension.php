<?php

namespace BabDev\Nova;

use BabDev\Models\JoomlaExtension as JoomlaExtensionModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;
use Waynestate\Nova\CKEditor;

class JoomlaExtension extends Resource
{
    public static $model = JoomlaExtensionModel::class;
    public static $title = 'name';

    public static $search = [
        'id',
        'name',
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Image::make('Logo')
                ->rules('image')
                ->disk('logos'),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            CKEditor::make('Description')
                ->hideFromIndex(),

            Boolean::make('Supported'),

            HasMany::make('Releases', 'releases', JoomlaExtensionRelease::class),
        ];
    }

    public static function label(): string
    {
        return 'Joomla Extensions';
    }
}
