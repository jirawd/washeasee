<?php

namespace App\Filament\Exports;

use App\Models\Transactions;
use App\Models\TransactionsByLaundryServiceUsage;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionsByLaundryServiceUsageExporter extends Exporter
{
    protected static ?string $model = Transactions::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')
                ->exists('customer')
                ->label('Name'),

            ExportColumn::make('service_avail')
                ->label('Service Count'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your transactions by laundry service usage export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

//    public static function modifyQuery(Builder $query): Builder
//    {
//
//        return $query
//            ->fromSub(function ($subQuery) {
//                $subQuery->from('transactions')
//                    ->select('customer_id', 'laundry_shop_id', DB::raw('COUNT(service_avail) as service_avail'))
//                    ->where('laundry_shop_id', Auth::id())
//                    ->whereNotNull('customer_id')  // Ensure customer_id is not null
//                    ->whereNotNull('laundry_shop_id')  // Ensure laundry_shop_id is not null
//                    ->groupBy('customer_id', 'laundry_shop_id');
//            }, 'sub')
//            ->orderByDesc(DB::raw('COUNT(service_avail)'))
//            ->limit(10);
//
//
//    }
}
