<?php

namespace App\Filament\LaundryShop\Resources\TransactionsResource\Pages;

use App\Filament\LaundryShop\Resources\TransactionsResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTransactions extends ViewRecord
{
    protected static string $resource = TransactionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
