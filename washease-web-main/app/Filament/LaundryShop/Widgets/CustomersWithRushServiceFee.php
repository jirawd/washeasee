<?php

namespace App\Filament\LaundryShop\Widgets;

use App\Filament\Exports\TransactionsExporter;
use App\Models\Transactions;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class CustomersWithRushServiceFee extends BaseWidget
{

    protected static ?int $sort = 6;

    protected static ?string $heading = 'Top 10 Customers with Highest Rush Service';

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
                    ->selectRaw('MAX(id) as id, customer_id, COUNT(delivery_fee) as delivery_fee_count, MAX(kilo) as kilo, MAX(service_type) as service_type, MAX(laundry_shop_id) as laundry_shop_id')
                    ->where('delivery_fee',200)
                    ->where('laundry_shop_id', Auth::user()->id)
                    ->groupBy('customer_id')
                    ->orderBy('delivery_fee_count', 'DESC')
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('customer.name')
                    ->formatStateUsing(function (Transactions $transactions) {
                        // Ensure the 'customer' relationship is loaded to access 'name'
                        return $transactions->customer ? $transactions->customer->name : 'No customer assigned';
                    })
                    ->placeholder('No customer assigned'),
                TextColumn::make('delivery_fee_count')
                    ->label('Rush Service'),
                TextColumn::make('kilo')
                    ->label('Kilo'),
            ]);
    }
}
