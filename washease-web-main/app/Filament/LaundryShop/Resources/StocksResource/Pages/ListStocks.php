<?php

namespace App\Filament\LaundryShop\Resources\StocksResource\Pages;

use App\Filament\LaundryShop\Resources\StocksResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStocks extends ListRecords
{
    protected static string $resource = StocksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
