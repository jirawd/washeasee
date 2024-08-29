<?php

namespace App\Filament\LaundryShop\Resources\ServiceCategoryResource\Pages;

use App\Filament\LaundryShop\Resources\ServiceCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditServiceCategory extends EditRecord
{
    protected static string $resource = ServiceCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
