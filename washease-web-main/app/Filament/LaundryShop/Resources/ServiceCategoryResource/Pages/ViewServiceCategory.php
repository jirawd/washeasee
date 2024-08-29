<?php

namespace App\Filament\LaundryShop\Resources\ServiceCategoryResource\Pages;

use App\Filament\LaundryShop\Resources\ServiceCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewServiceCategory extends ViewRecord
{
    protected static string $resource = ServiceCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
