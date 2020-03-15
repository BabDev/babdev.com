<?php

namespace BabDev\Nova;

use BabDev\DocumentationType;
use BabDev\Models\Package as PackageModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;

class Package extends Resource
{
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

            Text::make('Slug')
                ->hideFromIndex()
                ->hideFromDetail(),

            Select::make('Documentation Type')
                ->options(
                    [
                        DocumentationType::GITHUB => trans('doc_type.github'),
                        DocumentationType::LOCAL => trans('doc_type.local'),
                        DocumentationType::NONE => trans('doc_type.none'),
                    ]
                )
                ->displayUsingLabels(),

            Boolean::make('Supported'),

            Boolean::make('Visible'),
        ];
    }
}
