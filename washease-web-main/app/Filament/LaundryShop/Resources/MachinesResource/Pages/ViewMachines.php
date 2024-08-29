<?php

namespace App\Filament\LaundryShop\Resources\MachinesResource\Pages;

use App\Filament\LaundryShop\Resources\MachinesResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMachines extends ViewRecord
{
    protected static string $resource = MachinesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
