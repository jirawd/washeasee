<?php

namespace App\Filament\LaundryShop\Resources\RiderResource\Pages;

use App\Filament\LaundryShop\Resources\RiderResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRider extends ViewRecord
{
    protected static string $resource = RiderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}