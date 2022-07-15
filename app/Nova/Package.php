<?php

namespace BabDev\Nova;

use BabDev\Models\Package as PackageModel;
use BabDev\PackageType;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;

/**
 * @template TModel of PackageModel
 * @extends Resource<TModel>
 *
 * @mixin PackageModel
 */
class Package extends Resource
{
    public static $group = 'Packages';

    /**
     * @var class-string<TModel>
     */
    public static $model = PackageModel::class;

    public static $title = 'name';

    /**
     * @var string[]
     */
    public static $search = [
        'id',
        'name',
    ];

    /**
     * @return Field[]
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()
                ->asBigInt(),

            Image::make('Logo')
                ->rules('image')
                ->disk('logos'),

            Text::make('Name')
                ->readonly(),

            Text::make('Display Name')
                ->hideFromIndex(),

            Text::make('Packagist Name')
                ->hideFromIndex(),

            Slug::make('Slug')
                ->from('Name')
                ->hideFromIndex()
                ->hideFromDetail(),

            Boolean::make('Has Documentation'),

            Select::make('Package Type')
                ->options(
                    [
                        PackageType::JOOMLA_EXTENSION->value => trans('package_type.' . PackageType::JOOMLA_EXTENSION->value),
                        PackageType::LARAVEL_PACKAGE->value => trans('package_type.' . PackageType::LARAVEL_PACKAGE->value),
                        PackageType::PHP_PACKAGE->value => trans('package_type.' . PackageType::PHP_PACKAGE->value),
                        PackageType::PHPSPEC_EXTENSION->value => trans('package_type.' . PackageType::PHPSPEC_EXTENSION->value),
                        PackageType::SYLIUS_PLUGIN->value => trans('package_type.' . PackageType::SYLIUS_PLUGIN->value),
                        PackageType::SYMFONY_BUNDLE->value => trans('package_type.' . PackageType::SYMFONY_BUNDLE->value),
                    ],
                )
                ->resolveUsing(static fn (?PackageType $packageType, PackageModel $model, ?string $attribute): ?string => $packageType?->value)
                ->displayUsing(static fn (string $packageType, PackageModel $model, ?string $attribute): string => trans('package_type.' . PackageType::from($packageType)->value)),

            Boolean::make('Supported'),

            Boolean::make('Visible'),

            Boolean::make('Is Packagist'),

            HasMany::make('Versions', null, PackageVersion::class),
        ];
    }
}
