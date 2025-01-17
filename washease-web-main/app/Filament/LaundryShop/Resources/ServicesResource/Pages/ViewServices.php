<?php

namespace App\Filament\LaundryShop\Resources\ServicesResource\Pages;

use App\Filament\LaundryShop\Resources\ServicesResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewServices extends ViewRecord
{
    protected static string $resource = ServicesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
