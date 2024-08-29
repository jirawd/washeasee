<?php
namespace App\Filament\LaundryShop\Resources\MachinesResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\LaundryShop\Resources\MachinesResource;
use Illuminate\Routing\Router;


class MachinesApiService extends ApiService
{
    protected static string | null $resource = MachinesResource::class;

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
