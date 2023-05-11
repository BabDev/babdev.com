<?php

namespace BabDev\Filament\Resources;

use BabDev\Filament\Resources\PackageUpdateResource\Pages\CreatePackageUpdate;
use BabDev\Filament\Resources\PackageUpdateResource\Pages\EditPackageUpdate;
use BabDev\Filament\Resources\PackageUpdateResource\Pages\ListPackageUpdates;
use BabDev\Models\PackageUpdate;
use Camya\Filament\Forms\Components\TitleWithSlugInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class PackageUpdateResource extends Resource
{
    protected static ?string $model = PackageUpdate::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationGroup = 'Packages';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                TitleWithSlugInput::make(
                    fieldTitle: 'title',
                    fieldSlug: 'slug',
                    urlPath: '/open-source/updates/',
                    titleRules: ['required', 'max:255'],
                ),
                Select::make('package_id')
                    ->relationship('package', 'display_name')
                    ->required(),
                DateTimePicker::make('published_at'),
                TinyEditor::make('intro')->profile('babdev'),
                TinyEditor::make('content')->profile('babdev'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('package.display_name'),
                TextColumn::make('published_at')->dateTime(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('published_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPackageUpdates::route('/'),
            'create' => CreatePackageUpdate::route('/create'),
            'edit' => EditPackageUpdate::route('/{record}/edit'),
        ];
    }
}
