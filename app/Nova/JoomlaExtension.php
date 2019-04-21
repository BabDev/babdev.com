<?php

namespace BabDev\Nova;

use BabDev\Models\JoomlaExtension as JoomlaExtensionModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Waynestate\Nova\CKEditor;

class JoomlaExtension extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = JoomlaExtensionModel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param Request $request
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            CKEditor::make('Description'),

            Boolean::make('Supported'),
        ];
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Joomla Extensions';
    }
}
