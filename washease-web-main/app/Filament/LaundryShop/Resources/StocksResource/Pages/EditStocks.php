<?php

namespace App\Filament\LaundryShop\Resources\StocksResource\Pages;

use App\Filament\LaundryShop\Resources\StocksResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStocks extends EditRecord
{
    protected static string $resource = StocksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
