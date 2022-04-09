<?php

namespace BabDev\Nova;

use BabDev\Models\PackageUpdate as PackageUpdateModel;
use BabDev\TinyMCEField\TinyMCE;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;

class PackageUpdate extends Resource
{
    public static $group = 'Packages';

    /**
     * @var class-string<Model>
     */
    public static $model = PackageUpdateModel::class;

    public static $title = 'title';

    /**
     * @var string[]
     */
    public static $search = [
        'id',
        'title',
        'intro',
        'content',
    ];

    /**
     * @return Field[]
     */
    public function fields(NovaRequest $request): array
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

            BelongsTo::make('Package'),

            DateTime::make('Published At'),

            TinyMCE::make('Intro')
                ->hideFromIndex(),

            TinyMCE::make('Content')
                ->hideFromIndex(),
        ];
    }

    public static function label(): string
    {
        return 'Updates';
    }

    public static function singularLabel(): string
    {
        return 'Package Update';
    }
}
