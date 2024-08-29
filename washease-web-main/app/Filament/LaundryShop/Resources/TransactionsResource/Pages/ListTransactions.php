<?php

namespace App\Filament\LaundryShop\Resources\TransactionsResource\Pages;

use App\Filament\LaundryShop\Resources\TransactionsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Add Walk-in Transaction')
            ->createAnother(false)
            ->modalWidth('6xl')
                ->modalSubmitActionLabel('Checkout')
            ->slideOver(),
        ];
    }
}
