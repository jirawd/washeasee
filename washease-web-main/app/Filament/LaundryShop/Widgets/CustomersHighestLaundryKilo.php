<?php

namespace App\Filament\LaundryShop\Widgets;

use App\Filament\Exports\TransactionsExporter;
use App\Filament\Exports\TransactionsWithHighesKiloLaundryExporter;
use App\Models\Transactions;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class CustomersHighestLaundryKilo extends BaseWidget
{

    protected static ?int $sort = 4;

    protected static ?string $heading = 'Top 10 Customers with highest Kilo Laundry';

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                \pxlrbt\FilamentExcel\Actions\Tables\ExportAction::make()->exports([
                    ExcelExport::make('table')->fromTable(),
                ])
            ])
            ->query(
                Transactions::query()
                    ->selectRaw('MAX(id) as id, customer_id, MAX(kilo) as kilo, MAX(laundry_shop_id) as laundry_shop_id')
                    ->where('kilo', '>=', 10)
                    ->where('laundry_shop_id', Auth::user()->id)
                    ->groupBy('customer_id')
                    ->orderBy('kilo', 'DESC')
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('customer.name')
                    ->formatStateUsing(function (Transactions $transactions) {
                        // Ensure the 'customer' relationship is loaded to access 'name'
                        return $transactions->customer ? $transactions->customer->name : 'No customer assigned';
                    })
                    ->placeholder('No customer assigned'),
                TextColumn::make('kilo')
                    ->label('Kilo')
            ]);

    }
}
