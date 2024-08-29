<?php

namespace App\Filament\LaundryShop\Resources\ServicesResource\Pages;

use App\Filament\LaundryShop\Resources\ServicesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;

class ListServices extends ListRecords
{
    protected static string $resource = ServicesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Add Service')
                ->icon('heroicon-o-plus-circle')
                ->modalHeading('Add new Service')
                ->createAnother(false)
                ->modalWidth(MaxWidth::Medium),
        ];
    }
}
