<?php

namespace BabDev\Nova;

use BabDev\DocumentationType;
use BabDev\Models\Package as PackageModel;
use BabDev\PackageType;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;

class Package extends Resource
{
    public static $group = 'Packages';
    public static $model = PackageModel::class;
    public static $title = 'name';

    public static $search = [
        'id',
        'name',
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()
                ->asBigInt(),

            Image::make('Logo')
                ->rules('image')
                ->disk('logos'),

            Text::make('Name')
                ->readonly(static function () {
                    return true;
                }),

            Text::make('Display Name')
                ->hideFromIndex(),

            Text::make('Packagist Name')
                ->hideFromIndex(),

            Text::make('Slug')
                ->hideFromIndex()
                ->hideFromDetail(),

            Select::make('Documentation Type')
                ->options(
                    [
                        DocumentationType::GITHUB => trans('doc_type.' . DocumentationType::GITHUB),
                        DocumentationType::LOCAL => trans('doc_type.' . DocumentationType::LOCAL),
                        DocumentationType::NONE => trans('doc_type.' . DocumentationType::NONE),
                    ]
                )
                ->displayUsingLabels(),

            Select::make('Package Type')
                ->options(
                    [
                        PackageType::JOOMLA_EXTENSION => trans('package_type.' . PackageType::JOOMLA_EXTENSION),
                        PackageType::LARAVEL_PACKAGE => trans('package_type.' . PackageType::LARAVEL_PACKAGE),
                        PackageType::PHP_PACKAGE => trans('package_type.' . PackageType::PHP_PACKAGE),
                        PackageType::SYLIUS_PLUGIN => trans('package_type.' . PackageType::SYLIUS_PLUGIN),
                        PackageType::SYMFONY_BUNDLE => trans('package_type.' . PackageType::SYMFONY_BUNDLE),
                    ]
                )
                ->displayUsingLabels(),

            Boolean::make('Supported'),

            Boolean::make('Visible'),

            Boolean::make('Has Local Releases'),

            Boolean::make('Is Packagist'),
        ];
    }
}
