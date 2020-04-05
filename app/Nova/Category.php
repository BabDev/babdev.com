<?php

namespace BabDev\Nova;

use BabDev\Models\Category as CategoryModel;
use Drobee\NovaSluggable\Slug;
use Drobee\NovaSluggable\SluggableText;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Resource;

class Category extends Resource
{
    public static $group = 'Blog';
    public static $model = CategoryModel::class;
    public static $title = 'title';

    public static $search = [
        'id',
        'title',
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            SluggableText::make('Title')
                ->sortable()
                ->rules('required', 'max:255'),

            Slug::make('Slug')
                ->slugUnique()
                ->slugModel(static::$model)
                ->hideFromIndex()
                ->hideFromDetail(),
        ];
    }
}
