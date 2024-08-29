<?php

namespace App\Providers\Filament;

use App\Filament\LaundryShop\Pages\LaundryShopSettings;
use App\Filament\LaundryShop\Widgets\CustomersHighestLaundryKilo;
use App\Filament\LaundryShop\Widgets\CustomersWithRushServiceFee;
use App\Filament\LaundryShop\Widgets\DailyInventoryUsage;
use App\Filament\LaundryShop\Widgets\DashboardOverview;
use App\Filament\LaundryShop\Widgets\InventoryStocksLevels;
use App\Filament\LaundryShop\Widgets\InventoryStocksLevelsChart;
use App\Filament\LaundryShop\Widgets\MonthlySalesRevenue;
use App\Filament\LaundryShop\Widgets\MonthlySalesRevenueChart;
use App\Models\User;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;
use Outerweb\FilamentSettings\Filament\Plugins\FilamentSettingsPlugin;
use Rupadana\ApiService\ApiServicePlugin;
use Swis\Filament\Backgrounds\FilamentBackgroundsPlugin;
use Swis\Filament\Backgrounds\ImageProviders\MyImages;

class LaundryShopPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('laundry-shop')
            ->path('laundry-shop')
            ->login()
            ->brandName('WashEase Laundry System')
            ->maxContentWidth(MaxWidth::Full)
//            ->profile(isSimple: false)
            ->colors([
                'primary' => Color::Violet,
            ])
            ->brandLogo(asset('assets/img/light-mode-washease.png'))
            ->darkModeBrandLogo(asset('assets/img/dark-mode-washease.png'))
            ->brandLogoHeight('110px')
            ->discoverResources(in: app_path('Filament/LaundryShop/Resources'), for: 'App\\Filament\\LaundryShop\\Resources')
            ->discoverPages(in: app_path('Filament/LaundryShop/Pages'), for: 'App\\Filament\\LaundryShop\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/LaundryShop/Widgets'), for: 'App\\Filament\\LaundryShop\\Widgets')
            ->widgets([
                DashboardOverview::class,
                InventoryStocksLevelsChart::class,
                MonthlySalesRevenueChart::class,
                CustomersHighestLaundryKilo::class,
                CustomersWithRushServiceFee::class,

            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->userMenuItems([
                MenuItem::make()
                    ->label('Close the Shop')
                    ->postAction(fn(): string => route('shop.to.close'))
                    ->visible(fn(): bool => User::query()->where('id', Auth::id())->where('is_shop_closed', 1)->exists()),

                MenuItem::make()
                    ->label('Open the Shop')
                    ->postAction(fn(): string => route('shop.to.open'))
                    ->visible(fn(): bool => User::query()->where('id', Auth::id())->where('is_shop_closed', 0)->exists())

            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label(fn() => auth()->user()->name)
                    ->url(fn (): string => EditProfilePage::getUrl())
                    ->icon('heroicon-m-user-circle')
                ,
            ])
            ->plugins([
                ApiServicePlugin::make(),
                FilamentApexChartsPlugin::make(),
                FilamentSettingsPlugin::make()
                    ->pages([
                        LaundryShopSettings::class,
                    ]),
                FilamentBackgroundsPlugin::make()
                    ->imageProvider(
                        MyImages::make()
                            ->directory('images/backgrounds')
                    ),
                FilamentEditProfilePlugin::make()
                    ->slug('my-profile')
                    ->setTitle('My Profile')
                    ->setNavigationLabel('My Profile')
                    ->setIcon('heroicon-o-user')
                    ->shouldRegisterNavigation(false)
                    ->shouldShowDeleteAccountForm(false)
                    ->shouldShowSanctumTokens()
                    ->shouldShowBrowserSessionsForm()
                    ->shouldShowAvatarForm()
            ])
            ->databaseNotifications()
            ->databaseNotificationsPolling('5s')
            ->breadcrumbs(false);
    }
}
