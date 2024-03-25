<?php

namespace BabDev\Filament\Resources;

use BabDev\Filament\Resources\PackageUpdateResource\Pages\CreatePackageUpdate;
use BabDev\Filament\Resources\PackageUpdateResource\Pages\EditPackageUpdate;
use BabDev\Filament\Resources\PackageUpdateResource\Pages\ListPackageUpdates;
use BabDev\Models\PackageUpdate;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
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
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $operation, ?string $old, ?string $state, ?PackageUpdate $model): void {
                        if ($operation === 'edit' && $model?->is_published) {
                            return;
                        }

                        if (($get('slug') ?? '') !== Str::slug($old ?? '')) {
                            return;
                        }

                        $set('slug', Str::slug($state ?? ''));
                    }),
                TextInput::make('slug')
                    ->required()
                    ->unique(PackageUpdate::class, 'slug', fn ($record) => $record),
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
