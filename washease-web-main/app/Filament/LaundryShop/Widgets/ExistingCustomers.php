<?php

namespace App\Filament\LaundryShop\Widgets;

use App\Filament\Exports\TransactionsByLaundryServiceUsageExporter;
use App\Models\Transactions;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ExistingCustomers extends BaseWidget
{
    protected static ?string $heading = 'Top 10 Customers by Laundry Service Usage';

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = '';
    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                ExportAction::make()->exports([
                    ExcelExport::make('table')->fromTable(),
                ])
            ])
            ->query(

                Transactions::query()
                    ->select('customer_id', 'laundry_shop_id', DB::raw('COUNT(service_avail) as service_avail'))
                    ->where('laundry_shop_id', Auth::id())
                    ->groupBy(['customer_id', 'laundry_shop_id'])
                    ->orderByDesc(DB::raw('COUNT(service_avail)'))
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')
                    ->placeholder('No customer assigned'),
                Tables\Columns\TextColumn::make('service_avail')
                    ->label('Total Usage'), // Assuming you want to display the total usage


            ]);
    }

    public function getTableRecordKey(Model $record): string
    {
        return uniqid();
    }
}
