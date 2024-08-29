<?php

namespace App\Filament\LaundryShop\Resources\StocksResource\Pages;

use App\Filament\LaundryShop\Resources\StocksResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewStocks extends ViewRecord
{
    protected static string $resource = StocksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
