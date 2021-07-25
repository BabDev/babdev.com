<?php

namespace BabDev\Nova;

use BabDev\Models\PackageUpdate as PackageUpdateModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Kraftbit\NovaTinymce5Editor\NovaTinymce5Editor;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
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

            BelongsTo::make('Package'),

            DateTime::make('Published At'),

            NovaTinymce5Editor::make('Intro')
                ->hideFromIndex(),

            NovaTinymce5Editor::make('Content')
                ->hideFromIndex(),
        ];
    }

    public static function label(): string
    {
        return 'Updates';
    }
}
