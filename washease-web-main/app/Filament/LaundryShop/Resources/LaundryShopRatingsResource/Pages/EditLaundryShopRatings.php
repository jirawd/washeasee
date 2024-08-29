<?php

namespace App\Filament\LaundryShop\Resources\LaundryShopRatingsResource\Pages;

use App\Filament\LaundryShop\Resources\LaundryShopRatingsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLaundryShopRatings extends EditRecord
{
    protected static string $resource = LaundryShopRatingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
