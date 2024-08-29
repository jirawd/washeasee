<?php

namespace App\Filament\LaundryShop\Resources\RiderResource\Pages;

use App\Filament\LaundryShop\Resources\RiderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRiders extends ListRecords
{
    protected static string $resource = RiderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->mutateFormDataUsing(function (array $data) {

                $data['name'] = $data['first_name'] . ' ' . $data['last_name'];

                return $data;
            }),
        ];
    }
}
