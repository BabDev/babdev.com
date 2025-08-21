<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageUpdateResource\Pages\CreatePackageUpdate;
use App\Filament\Resources\PackageUpdateResource\Pages\EditPackageUpdate;
use App\Filament\Resources\PackageUpdateResource\Pages\ListPackageUpdates;
use App\Models\PackageUpdate;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PackageUpdateResource extends Resource
{
    protected static ?string $model = PackageUpdate::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $recordTitleAttribute = 'title';

    protected static string|\UnitEnum|null $navigationGroup = 'Packages';

    #[\Override]
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
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
                    ->unique(PackageUpdate::class, 'slug', fn($record) => $record),
                Select::make('package_id')
                    ->relationship('package', 'display_name')
                    ->required(),
                DateTimePicker::make('published_at'),
                RichEditor::make('intro'),
                RichEditor::make('content'),
            ]);
    }

    #[\Override]
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('package.display_name'),
                TextColumn::make('published_at')->label('Published At')->dateTime(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('published_at', 'desc');
    }

    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => ListPackageUpdates::route('/'),
            'create' => CreatePackageUpdate::route('/create'),
            'edit' => EditPackageUpdate::route('/{record}/edit'),
        ];
    }
}
