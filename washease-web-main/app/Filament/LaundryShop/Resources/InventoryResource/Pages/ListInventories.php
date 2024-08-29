<?php

namespace App\Filament\LaundryShop\Resources\InventoryResource\Pages;

use App\Filament\LaundryShop\Resources\InventoryResource;
use App\Models\Inventory;
use App\Models\Stocks;
use Filament\Actions;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;

class ListInventories extends ListRecords
{
    protected static string $resource = InventoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Add Supply')
                ->icon('heroicon-o-plus-circle')
                ->modalHeading('Add new Item')
                ->createAnother(false)
                ->modalWidth(MaxWidth::Medium),

            Actions\Action::make('Add Stock')
                ->icon('heroicon-o-plus-circle')
                ->modalHeading('Add Stock')
                ->modalWidth(MaxWidth::Medium)
                ->form([



                    Hidden::make('laundry_shop_id')
                        ->default(Auth::id()),
                    Select::make('inventory_id')
                        ->label('Inventory Item')
                        ->native(false)
                        ->options(Inventory::where('laundry_shop_id', Auth::id())->pluck('item_name', 'id')),
                    Select::make('transaction_type')
                        ->native(false)
                        ->options([
                            'Stock In' => 'Stock In',
                            'Stock Out' => 'Stock Out'
                        ]),
                    TextInput::make('quantity')
                    ->numeric()
                    ->minValue(0),
                ])
                ->action(function (Stocks $stocks, array $data): void {
                    $stocks->laundry_shop_id = $data['laundry_shop_id'];
                    $stocks->inventory_id = $data['inventory_id'];
                    $stocks->transaction_type = $data['transaction_type'];
                    $stocks->quantity = $data['quantity'];
                    $stocks->save();

                })
                ->after(function (array $data) {
                    $inventory = Inventory::where('id', $data['inventory_id'])->first();

                    if ($data['transaction_type'] === 'Stock In') {
                        $inventory->item_quantity += $data['quantity']; // Add quantity to current inventory
                    } else {
                        $inventory->item_quantity -= $data['quantity']; // Subtract quantity from current inventory
                    }

                    if($inventory->save()) {
                        Notification::make()
                            ->success()
                            ->title('Stocks Updated')
                            ->body('The stock has been updated successfully.')
                            ->send();
                    }

                }),
        ];
    }
}
