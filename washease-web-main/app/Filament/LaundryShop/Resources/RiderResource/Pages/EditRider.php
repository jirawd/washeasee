<?php

namespace App\Filament\LaundryShop\Resources\RiderResource\Pages;

use App\Filament\LaundryShop\Resources\RiderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRider extends EditRecord
{
    protected static string $resource = RiderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
