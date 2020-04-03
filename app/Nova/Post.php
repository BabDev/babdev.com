<?php

namespace BabDev\Nova;

use BabDev\Models\Post as PostModel;
use Drobee\NovaSluggable\SluggableText;
use Drobee\NovaSluggable\Slug;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Resource;

class Post extends Resource
{
    public static $group = 'Blog';
    public static $model = PostModel::class;
    public static $title = 'title';

    public static $search = [
        'id',
        'title',
        'intro',
        'content',
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

            BelongsTo::make('Category'),

            DateTime::make('Published At'),

            Trix::make('Intro')
                ->withFiles('uploads')
                ->hideFromIndex(),

            Trix::make('Content')
                ->withFiles('uploads')
                ->hideFromIndex(),
        ];
    }
}
