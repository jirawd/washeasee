<?php

namespace App\Filament\LaundryShop\Widgets;

use App\Models\Stocks;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class InventoryStocksLevelsChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'inventoryStocksLevelsChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'InventoryStocksLevelsChart';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $monthlyData = [];

        $stockInData = [];
        $stockOutData = [];

        for ($month = 1; $month <= 12; $month++) {
            // Calculate the start and end date of the current month
            $startDate = Carbon::now()->setMonth($month)->startOfMonth();
            $endDate = Carbon::now()->setMonth($month)->endOfMonth();

            // Query the database for stock transactions within the current month
            $stockTransactions = Stocks::whereBetween('created_at', [$startDate, $endDate])->where('laundry_shop_id', Auth::id())->get();

            // Initialize variables to track stock in and stock out quantities
            $stockIn = 0;
            $stockOut = 0;

            // Iterate through the transactions and calculate stock in and stock out
            foreach ($stockTransactions as $transaction) {
                if ($transaction->transaction_type === 'Stock In') {
                    $stockIn += $transaction->quantity; // $stockIn = $transaction->quantity + $transaction->quantity
                } elseif ($transaction->transaction_type === 'Stock Out') {
                    $stockOut += $transaction->quantity;
                }
            }

            // Store the calculated quantities for the current month
            $stockInData[] = $stockIn;
            $stockOutData[] = $stockOut;
        }

// Prepare the response data structure
        $response = [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Stock In',
                    'data' => $stockInData,
                ],
                [
                    'name' => 'Stock Out',
                    'data' => $stockOutData,
                ],
            ],
            'xaxis' => [
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
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
            'stroke' => [
                'curve' => 'smooth',
            ],
        ];

        return $response;

    }
}
