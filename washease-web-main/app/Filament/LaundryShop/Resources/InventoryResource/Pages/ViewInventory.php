<?php

namespace App\Filament\LaundryShop\Resources\InventoryResource\Pages;

use App\Filament\LaundryShop\Resources\InventoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewInventory extends ViewRecord
{
    protected static string $resource = InventoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
            ->label('Update Item'),
        ];
    }
}
