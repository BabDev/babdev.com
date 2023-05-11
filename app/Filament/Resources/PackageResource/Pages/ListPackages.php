<?php

namespace BabDev\Filament\Resources\PackageResource\Pages;

use BabDev\Filament\Resources\PackageResource;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPackages extends ListRecords
{
    protected static string $resource = PackageResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
