<?php

namespace App\Filament\LaundryShop\Resources\MachinesResource\Pages;

use App\Filament\LaundryShop\Resources\MachinesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;

class ListMachines extends ListRecords
{
    protected static string $resource = MachinesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Add Machine')
                ->icon('heroicon-o-plus-circle')
                ->modalHeading('Add new Machine')
                ->createAnother(false)
                ->modalWidth(MaxWidth::Small),
        ];
    }
}
