<?php

namespace BabDev\Filament\Resources;

use BabDev\Filament\Resources\PackageResource\Pages\CreatePackage;
use BabDev\Filament\Resources\PackageResource\Pages\EditPackage;
use BabDev\Filament\Resources\PackageResource\Pages\ListPackages;
use BabDev\Filament\Resources\PackageResource\RelationManagers\VersionsRelationManager;
use BabDev\Models\Package;
use BabDev\PackageType;
use Camya\Filament\Forms\Components\TitleWithSlugInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $navigationIcon = 'heroicon-o-view-grid';

    protected static ?string $recordTitleAttribute = 'display_name';

    protected static ?string $navigationGroup = 'Packages';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                TitleWithSlugInput::make(
                    fieldTitle: 'name',
                    fieldSlug: 'slug',
                    urlPath: '/open-source/packages/',
                ),
                TextInput::make('display_name'),
                TextInput::make('packagist_name'),
                Checkbox::make('has_documentation'),
                Select::make('package_type')->required()->options([
                    PackageType::JOOMLA_EXTENSION->value => trans('package_type.' . PackageType::JOOMLA_EXTENSION->value),
                    PackageType::LARAVEL_PACKAGE->value => trans('package_type.' . PackageType::LARAVEL_PACKAGE->value),
                    PackageType::PHP_PACKAGE->value => trans('package_type.' . PackageType::PHP_PACKAGE->value),
                    PackageType::PHPSPEC_EXTENSION->value => trans('package_type.' . PackageType::PHPSPEC_EXTENSION->value),
                    PackageType::SYLIUS_PLUGIN->value => trans('package_type.' . PackageType::SYLIUS_PLUGIN->value),
                    PackageType::SYMFONY_BUNDLE->value => trans('package_type.' . PackageType::SYMFONY_BUNDLE->value),
                ]),
                Checkbox::make('supported'),
                Checkbox::make('visible'),
                Checkbox::make('is_packagist'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('display_name'),
                IconColumn::make('has_documentation')->boolean(),
                TextColumn::make('package_type')->formatStateUsing(fn (string $state): string => trans('package_type.' . $state)),
                IconColumn::make('supported')->boolean(),
                IconColumn::make('visible')->boolean(),
                IconColumn::make('is_packagist')->boolean(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('display_name', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            VersionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPackages::route('/'),
            'create' => CreatePackage::route('/create'),
            'edit' => EditPackage::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->display_name;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['display_name', 'name'];
    }
}
