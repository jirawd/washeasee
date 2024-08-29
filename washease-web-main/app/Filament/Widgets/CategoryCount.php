<?php

namespace App\Filament\Widgets;

use App\Models\BasicServices;
use App\Models\Category;
use App\Models\DryCleaning;
use App\Models\Ironing;
use App\Models\Machines;
use App\Models\SellingItems;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CategoryCount extends BaseWidget
{
    protected function getStats(): array
    {
        return [

        ];
    }
}
