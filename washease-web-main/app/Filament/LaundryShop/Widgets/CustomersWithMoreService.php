<?php

namespace App\Filament\LaundryShop\Widgets;

use App\Filament\Exports\TransactionsByLaundryServiceUsageExporter;
use App\Filament\Exports\TransactionsExporter;
use App\Models\Transactions;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class CustomersWithMoreService extends BaseWidget
{
    protected static ?int $sort = 4;

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
                    ->selectRaw('MAX(id) as id, customer_id, COUNT(service_type) as service_type_count')
                    ->whereIn('service_type',['self_service', 'pickup', 'pickup_and_delivery'])
                    ->where('laundry_shop_id', Auth::user()->id)
                    ->groupBy('customer_id')
                    ->orderBy('service_type_count', 'DESC')
                    ->limit(10)
            )
            ->columns([

                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Name')
                    ->sortable(),

                Tables\Columns\TextColumn::make('service_type_count')
                    ->label('Service Count')
                    ->sortable(),
            ])
            ->recordTitle('');
    }
}
