<?php

namespace App\Filament\Resources\PackageUpdateResource\Pages;

use App\Filament\Resources\PackageUpdateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPackageUpdates extends ListRecords
{
    protected static string $resource = PackageUpdateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
