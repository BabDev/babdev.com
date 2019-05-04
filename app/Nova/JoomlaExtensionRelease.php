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
use Waynestate\Nova\CKEditor;

class JoomlaExtensionRelease extends Resource
{
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
                        JoomlaExtensionReleaseModel::STABILITY_ALPHA => 'Alpha',
                        JoomlaExtensionReleaseModel::STABILITY_BETA => 'Beta',
                        JoomlaExtensionReleaseModel::STABILITY_RC => 'Release Candidate',
                        JoomlaExtensionReleaseModel::STABILITY_STABLE => 'Stable',
                    ]
                )->displayUsingLabels(),

            CKEditor::make('Summary')
                ->hideFromIndex(),

            CKEditor::make('Changelog')
                ->hideFromIndex(),

            Boolean::make('Published'),

            DateTime::make('Published At'),
        ];
    }

    public static function label(): string
    {
        return 'Joomla Extension Releases';
    }
}
