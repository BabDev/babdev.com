<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageResource\Pages\CreatePackage;
use App\Filament\Resources\PackageResource\Pages\EditPackage;
use App\Filament\Resources\PackageResource\Pages\ListPackages;
use App\Filament\Resources\PackageResource\RelationManagers\VersionsRelationManager;
use App\Models\Package;
use App\PackageType;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $recordTitleAttribute = 'display_name';

    protected static string|\UnitEnum|null $navigationGroup = 'Packages';

    #[\Override]
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('name')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $operation, ?string $old, ?string $state): void {
                        if ($operation === 'edit') {
                            return;
                        }

                        if (($get('slug') ?? '') !== Str::slug($old ?? '')) {
                            return;
                        }

                        $set('slug', Str::slug($state ?? ''));
                    }),
                TextInput::make('slug')
                    ->required()
                    ->unique(Package::class, 'slug', fn($record) => $record),
                TextInput::make('display_name')->label('Display Name'),
                TextInput::make('packagist_name')->label('Packagist Name'),
                Checkbox::make('has_documentation')->label('Has Documentation?'),
                Select::make('package_type')
                    ->label('Package Type')
                    ->required()
                    ->options(static fn() => collect(PackageType::cases())->mapWithKeys(static fn(PackageType $type) => [$type->value => $type->label()])),
                Checkbox::make('supported')->label('Supported?'),
                Checkbox::make('visible')->label('Visible?'),
                Checkbox::make('is_packagist')->label('Is Packagist?'),
            ]);
    }

    #[\Override]
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('display_name'),
                IconColumn::make('has_documentation')->label('Has Documentation?')->boolean(),
                TextColumn::make('package_type')->formatStateUsing(fn(PackageType $state): string => $state->label()),
                IconColumn::make('supported')->label('Supported?')->boolean(),
                IconColumn::make('visible')->boolean(),
                IconColumn::make('is_packagist')->label('Is Packagist?')->boolean(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('display_name', 'asc');
    }

    #[\Override]
    public static function getRelations(): array
    {
        return [
            VersionsRelationManager::class,
        ];
    }

    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => ListPackages::route('/'),
            'create' => CreatePackage::route('/create'),
            'edit' => EditPackage::route('/{record}/edit'),
        ];
    }

    /**
     * @phpstan-param Package $record
     */
    #[\Override]
    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->display_name;
    }

    #[\Override]
    public static function getGloballySearchableAttributes(): array
    {
        return ['display_name', 'name'];
    }
}
