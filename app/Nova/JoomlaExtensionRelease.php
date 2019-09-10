<?php

namespace BabDev\Nova;

use BabDev\Models\JoomlaExtensionRelease as JoomlaExtensionReleaseModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;
use MichielKempen\NovaOrderField\Orderable;
use MichielKempen\NovaOrderField\OrderField;
use Waynestate\Nova\CKEditor;

class JoomlaExtensionRelease extends Resource
{
    use Orderable;

    public static $defaultOrderField = 'ordering';

    public static $model = JoomlaExtensionReleaseModel::class;

    public static $title = 'version';

    public static $search = [
        'id',
        'version',
        'extension',
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Extension', 'extension', JoomlaExtension::class),

            Text::make('Version')
                ->rules('required', 'max:255'),

            Text::make('Slug')
                ->rules('required')
                ->hideFromIndex()
                ->hideFromDetail(),

            Select::make('Maturity')
                ->options(
                    [
                        JoomlaExtensionReleaseModel::STABILITY_ALPHA => trans('stability.alpha'),
                        JoomlaExtensionReleaseModel::STABILITY_BETA => trans('stability.beta'),
                        JoomlaExtensionReleaseModel::STABILITY_RC => trans('stability.rc'),
                        JoomlaExtensionReleaseModel::STABILITY_STABLE => trans('stability.stable'),
                    ]
                )->displayUsingLabels(),

            CKEditor::make('Summary')
                ->hideFromIndex(),

            CKEditor::make('Changelog')
                ->hideFromIndex(),

            Boolean::make('Published'),

            DateTime::make('Published At'),

            OrderField::make('Ordering', 'id'),
        ];
    }

    public static function label(): string
    {
        return 'Joomla Extension Releases';
    }
}
