<?php
namespace App\Filament\LaundryShop\Resources\ServiceCategoryResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\LaundryShop\Resources\ServiceCategoryResource;
use Illuminate\Routing\Router;


class ServiceCategoryApiService extends ApiService
{
    protected static string | null $resource = ServiceCategoryResource::class;

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
