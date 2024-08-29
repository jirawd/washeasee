<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class LaundryShopRatings extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'laundryShopRatings';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Laundry Shop Ratings';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
{
    // Query to get the total and average ratings for each laundry shop
    $ratingsByShop = DB::table('laundry_shop_ratings')
        ->join('users', 'laundry_shop_ratings.laundry_shop_id', '=', 'users.id')
        ->select('users.laundry_shop_name as shop_name', DB::raw('SUM(laundry_shop_ratings.rating_count) as total_rating'))
        ->groupBy('users.laundry_shop_name')
        ->pluck('total_rating', 'shop_name')
        ->toArray();

    // Calculate the total of all ratings
    $totalRatings = array_sum($ratingsByShop);

    // Calculate the percentage each shop's rating contributes to the total
    $percentageRatings = array_map(function($rating) use ($totalRatings) {
        return round(($rating / $totalRatings) * 100, 2);
    }, $ratingsByShop);

    // Extract shop names and their corresponding percentage ratings
    $shopNames = array_keys($percentageRatings);
    $percentageRatingsData = array_values($percentageRatings);

    return [
        'chart' => [
            'type' => 'pie',
            'height' => 300,
        ],
        'series' => $percentageRatingsData,
        'labels' => $shopNames,
        'legend' => [
            'labels' => [
                'fontFamily' => 'inherit',
            ],
        ],
    ];
}


}
