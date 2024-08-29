<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use function Laravel\Prompts\password;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Create new Account')
            ->icon('heroicon-o-plus-circle')
            ,
        ];
    }

    public function getTabs(): array
    {
        return [
            'ALL' => Tab::make(),
            'LAUNDRY SHOPS' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', 'LaundryShop')),
            'CUSTOMERS' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', 'Customer')),
        ];
    }
}
