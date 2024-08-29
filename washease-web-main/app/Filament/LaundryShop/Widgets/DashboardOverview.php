<?php

namespace App\Filament\LaundryShop\Widgets;

use App\Models\Machines;
use App\Models\ServiceCategory;
use App\Models\Services;
use App\Models\Transactions;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class DashboardOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Machines', Machines::where('laundry_shop_id', Auth::id())->count())
            ->label('Machines')
            ->description('Total Machines')
            ->icon('heroicon-o-cpu-chip'),

            Stat::make('Services', Services::where('laundry_shop_id', Auth::id())->count())
                ->label('Services')
                ->description('Total Services')
                ->icon('heroicon-o-cpu-chip'),

            Stat::make('Transactions', Transactions::where('laundry_shop_id', Auth::id())->count())
                ->label('Transactions')
                ->description('Total Transactions')
                ->icon('heroicon-o-cpu-chip'),

            Stat::make('Selling Items', Transactions::where('laundry_shop_id', Auth::id())->count())
                ->label('Selling Items')
                ->description('Total Items')
                ->icon('heroicon-o-cpu-chip'),

            Stat::make('Pending Transactions', Transactions::where('laundry_shop_id', Auth::id())->where('status', 'PENDING')->count())
                ->label('Pending Transactions')
                ->color('warning')
                ->description('Total Pending Transactions')
                ->icon('heroicon-o-cpu-chip'),

            Stat::make('Processing Transactions', Transactions::where('laundry_shop_id', Auth::id())->where('status', 'PROCESSING')->count())
                ->label('Processing Transactions')
                ->color('info')
                ->description('Total Processing Transactions')
                ->icon('heroicon-o-cpu-chip'),

            Stat::make('Ready for Pickup Transactions', Transactions::where('laundry_shop_id', Auth::id())->where('status', 'READY FOR PICKUP')->count())
                ->label('Ready for Pickup Transactions')
                ->color('primary')
                ->description('Total Ready for Pickup Transactions')
                ->icon('heroicon-o-cpu-chip'),

            Stat::make('Completed Transactions', Transactions::where('laundry_shop_id', Auth::id())->where('status', 'COMPLETED')->count())
                ->label('Completed Transactions')
                ->color('success')
                ->description('Total Completed Transactions')
                ->icon('heroicon-o-cpu-chip'),
        ];
    }

    protected function getColumns(): int
    {
        return 4;
    }
}
