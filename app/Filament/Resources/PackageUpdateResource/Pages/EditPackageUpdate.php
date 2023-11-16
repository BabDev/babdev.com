<?php

namespace BabDev\Filament\Resources\PackageUpdateResource\Pages;

use BabDev\Filament\Resources\PackageUpdateResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPackageUpdate extends EditRecord
{
    protected static string $resource = PackageUpdateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
