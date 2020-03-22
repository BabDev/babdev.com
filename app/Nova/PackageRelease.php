<?php

namespace BabDev\Nova;

use BabDev\Models\PackageRelease as PackageReleaseModel;
use BabDev\NovaMediaLibrary\Fields\Files;
use BabDev\ReleaseStability;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Resource;
use MichielKempen\NovaOrderField\Orderable;
use MichielKempen\NovaOrderField\OrderField;

class PackageRelease extends Resource
{
    use Orderable;

    public static $defaultOrderField = 'ordering';
    public static $model = PackageReleaseModel::class;
    public static $title = 'version';

    public static $search = [
        'id',
        'version',
        'package',
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Package'),

            Text::make('Version')
                ->rules('required', 'max:255'),

            Text::make('Slug')
                ->rules('required')
                ->hideFromIndex()
                ->hideFromDetail(),

            Select::make('Maturity')
                ->options(
                    [
                        ReleaseStability::ALPHA => trans('stability.alpha'),
                        ReleaseStability::BETA => trans('stability.beta'),
                        ReleaseStability::RC => trans('stability.rc'),
                        ReleaseStability::STABLE => trans('stability.stable'),
                    ]
                )->displayUsingLabels(),

            Trix::make('Summary')
                ->hideFromIndex(),

            Trix::make('Changelog')
                ->hideFromIndex(),

            Boolean::make('Visible'),

            DateTime::make('Released At'),

            OrderField::make('Ordering', 'id'),

            Files::make('Downloads', 'downloads')
                ->multiple(),
        ];
    }
}
