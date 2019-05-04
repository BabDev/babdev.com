<?php

namespace BabDev\Nova;

use BabDev\Models\User as UserModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;

class User extends Resource
{
    public static $model = UserModel::class;

    public static $title = 'name';

    public static $search = [
        'id',
        'name',
        'email',
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Gravatar::make(),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:6')
                ->updateRules('nullable', 'string', 'min:6'),
        ];
    }
}
