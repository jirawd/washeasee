<?php

namespace App\Filament\LaundryShop\Resources\ServicesResource\Pages;

use App\Filament\LaundryShop\Resources\ServicesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditServices extends EditRecord
{
    protected static string $resource = ServicesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
