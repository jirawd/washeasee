<?php
namespace App\Filament\LaundryShop\Resources\LaundryShopRatingsResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\LaundryShop\Resources\LaundryShopRatingsResource;
use Illuminate\Routing\Router;


class LaundryShopRatingsApiService extends ApiService
{
    protected static string | null $resource = LaundryShopRatingsResource::class;

    public static function handlers() : array
    {
        return [
            Handlers\CreateHandler::class,
            Handlers\UpdateHandler::class,
            Handlers\DeleteHandler::class,
            Handlers\PaginationHandler::class,
            Handlers\DetailHandler::class
        ];

    }
}
