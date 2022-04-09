<?php

namespace BabDev\Nova;

use BabDev\Models\PackageVersion as PackageVersionModel;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;

/**
 * @template TModel of PackageVersionModel
 * @extends Resource<TModel>
 *
 * @mixin PackageVersionModel
 */
class PackageVersion extends Resource
{
    /**
     * @var class-string<TModel>
     */
    public static $model = PackageVersionModel::class;

    public static $title = 'version';

    /**
     * @var string[]
     */
    public static $search = [
        'id',
        'version',
    ];

    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = false;

    /**
     * @return Field[]
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Version')
                ->sortable()
                ->creationRules('required', Rule::unique(PackageVersionModel::class)->where('package_id', $this->package_id))
                ->updateRules('required', Rule::unique(PackageVersionModel::class)->where('package_id', $this->package_id)->ignore($this->id)),

            Text::make('Docs Git Branch'),

            BelongsTo::make('Package'),

            Date::make('Released'),

            Date::make('End of Support'),
        ];
    }

    public static function label(): string
    {
        return 'Versions';
    }
}
