<?php

namespace App\Filament\LaundryShop\Pages;

use Closure;
use Dotswan\MapPicker\Fields\Map;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Humaidem\FilamentMapPicker\Fields\OSMMap;
use Illuminate\Support\Facades\Auth;
use Outerweb\FilamentSettings\Filament\Pages\Settings as BaseSettings;
use Outerweb\Settings\Models\Setting;
use Traineratwot\FilamentOpenStreetMap\Forms\Components\MapInput;

class LaundryShopSettings extends BaseSettings
{
//    protected static ?string $navigationIcon = 'heroicon-o-document-text';

//    protected static string $view = 'filament.laundry-shop.pages.laundry-shop-settings';

protected static bool $shouldRegisterNavigation = false;


    public function schema(): array|Closure
    {

        return [
            Tabs::make('Settings')
                ->schema([

                    Tabs\Tab::make('Shop Information')
                        ->schema([
                            TextInput::make('general.shop_name')
                                ->required(),
                            Textarea::make('general.shop_address')
                                ->required(),
                        ]),
                    Tabs\Tab::make('Shop Location Map')
                        ->schema([

                            TextInput::make('latitude'),
                            TextInput::make('longitude'),
                            Map::make('location')
                                ->label('Location')
                                ->columnSpanFull()
                                ->afterStateUpdated(function (Get $get, Set $set, string|array|null $old, ?array $state): void {
                                    $set('latitude', $state['lat']);
                                    $set('longitude', $state['lng']);
                                })
                                ->afterStateHydrated(function ($state, $record, Set $set, Get $get): void {
//                                    $shop_map_location = Setting::query()->where('laundry_shop_id', Auth::id())->first();
                                    $set('location', ['latitude' => $state['lat'], 'longitude' => $state['lng']]);
                                })
                                ->extraStyles([
                                    'border-radius: 10px'
                                ])
                                ->liveLocation()
                                ->showMarker()
                                ->markerColor("#c55eff")
                                ->draggable()
                                ->tilesUrl("https://tile.openstreetmap.de/{z}/{x}/{y}.png")
                                ->zoom(500)
                                ->detectRetina()
                                ->showMyLocationButton()
                                ->extraTileControl([])
                                ->extraControl([
                                    'zoomDelta'           => 1,
                                    'zoomSnap'            => 2,
                                ])
                        ]),
                    Tabs\Tab::make('Seo')
                        ->schema([
                            TextInput::make('seo.title')
                                ->required(),
                            TextInput::make('seo.description')
                                ->required(),
                            TagsInput::make('seo.tags')
                                ->required(),
                        ]),

                ]),
        ];
    }



}
