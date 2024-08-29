<?php

namespace App\Filament\LaundryShop\Pages;

use Filament\Pages\Page;

class SubscriptionPlanPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $title = 'Subscription Plan';

    protected static ?int $navigationSort = 5;

    protected static string $view = 'filament.laundry-shop.pages.subscription-plan-page';
}
