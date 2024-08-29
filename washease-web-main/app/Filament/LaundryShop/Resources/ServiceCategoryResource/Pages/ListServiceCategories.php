<?php

namespace App\Filament\LaundryShop\Resources\ServiceCategoryResource\Pages;

use App\Filament\LaundryShop\Resources\ServiceCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;

class ListServiceCategories extends ListRecords
{
    protected static string $resource = ServiceCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make()
//            ->label('Add Category')
//            ->modalHeading('Add new Category')
//            ->icon('heroicon-o-plus-circle')
//            ->modalWidth(MaxWidth::Small)
//            ->createAnother(false)
//            ->successNotificationTitle('Category Created Successfully'),
        ];
    }
}
