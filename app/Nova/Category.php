<?php

namespace BabDev\Nova;

use BabDev\Models\Category as CategoryModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;

class Category extends Resource
{
    public static $group = 'Blog';

    /**
     * @var class-string<Model>
     */
    public static $model = CategoryModel::class;

    public static $title = 'title';

    /**
     * @var string[]
     */
    public static $search = [
        'id',
        'title',
    ];

    /**
     * @return Field[]
     */
    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Title')
                ->sortable()
                ->rules('required', 'max:255'),

            Slug::make('Slug')
                ->from('Title')
                ->hideFromIndex()
                ->hideFromDetail(),
        ];
    }
}
