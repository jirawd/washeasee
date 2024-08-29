<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class LaundryShopsSalesPerMonth extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'laundryShopsSalesPerMonth';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Laundry Shops Sales PerMonth';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        // Get the current year
        $year = Carbon::now()->year;

        // Query to get the total sales for each laundry shop
        $salesByShop = DB::table('transactions')
            ->join('users', 'transactions.laundry_shop_id', '=', 'users.id')
            ->select('users.name as shop_name', DB::raw('SUM(transactions.total_bill) as total_sales'))
            ->groupBy('users.name')
            ->pluck('total_sales', 'shop_name')
            ->toArray();

        // Extract shop names and their corresponding sales
        $shopNames = array_keys($salesByShop);
        $salesData = array_values($salesByShop);

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Sales',
                    'data' => $salesData,
                ],
            ],
            'xaxis' => [
                'categories' => $shopNames,
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#f59e0b'],
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 3,
                    'horizontal' => true,
                ],
            ],
        ];
    }
}
