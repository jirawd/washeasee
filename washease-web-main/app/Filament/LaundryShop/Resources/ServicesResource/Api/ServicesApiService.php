<?php
namespace App\Filament\LaundryShop\Resources\ServicesResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\LaundryShop\Resources\ServicesResource;
use Illuminate\Routing\Router;


class ServicesApiService extends ApiService
{
    protected static string | null $resource = ServicesResource::class;

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
