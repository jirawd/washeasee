<?php

namespace App\Filament\LaundryShop\Resources\MachinesResource\Pages;

use App\Filament\LaundryShop\Resources\MachinesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMachines extends EditRecord
{
    protected static string $resource = MachinesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
