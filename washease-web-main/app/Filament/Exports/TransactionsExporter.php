<?php

namespace App\Filament\Exports;

use App\Models\Transactions;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TransactionsExporter extends Exporter
{
    protected static ?string $model = Transactions::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('customer.name')->formatStateUsing(function (Transactions $transactions) {
                    return $transactions->customer ? $transactions->customer->name : 'No customer assigned';
                }),
            ExportColumn::make('delivery_fee_count')
                ->label('Rush Service'),
            ExportColumn::make('kilo'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your transactions export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

    public static function modifyQuery(Builder $query): Builder
    {
        return $query
            ->fromSub(function ($subQuery) {
                $subQuery->from('transactions')
                    ->selectRaw('MAX(id) as id, customer_id, COUNT(delivery_fee) as delivery_fee_count, MAX(kilo) as kilo, MAX(service_type) as service_type, MAX(laundry_shop_id) as laundry_shop_id')
                    ->where('delivery_fee', 200)
                    ->where('laundry_shop_id', Auth::id())
                    ->groupBy('customer_id');
            }, 'sub')
            ->orderBy('delivery_fee_count', 'DESC')
            ->limit(10);
    }
}
