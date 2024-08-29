<?php

namespace App\Filament\LaundryShop\Widgets;

use App\Models\Transactions;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class MonthlySalesRevenueChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'monthlySalesRevenueChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Monthly Sales Revenue (Completed)';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        // Initialize an array to hold monthly sales revenue data
        $monthlyData = [];

// Loop through each month
        for ($month = 1; $month <= 12; $month++) {
            // Calculate the start and end date of the current month
            $startDate = Carbon::now()->setMonth($month)->startOfMonth();
            $endDate = Carbon::now()->setMonth($month)->endOfMonth();

            // Query the database for transactions with status COMPLETED within the current month
            $completedTransactions = Transactions::where('status', 'COMPLETED')
                ->where('laundry_shop_id', Auth::id())
                ->whereBetween('delivery_date', [$startDate, $endDate])
                ->get();

            // Initialize variable to track monthly sales revenue
            $monthlyRevenue = 0;

            // Calculate total revenue for the current month
            foreach ($completedTransactions as $transaction) {
                $monthlyRevenue += $transaction->total_bill;
            }

            // Store the calculated monthly revenue
            $monthlyData[] = $monthlyRevenue;
        }

// Prepare the response data structure
        $response = [
            'chart' => [
                'type' => 'line',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'MonthlySalesRevenueChart',
                    'data' => $monthlyData,
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
            'colors' => ['#f59e0b'],
            'stroke' => [
                'curve' => 'smooth',
            ],
        ];

        return $response;

    }
}
