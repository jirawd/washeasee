<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\LaundryShopLocations;
use App\Models\LaundryShopRatings;
use App\Models\Machines;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Outerweb\FilamentSettings\Filament\Pages\Settings;

class LaundryShopsAPI extends Controller
{
    public function get_all_laundry_shops(Request $request)
    {
        // Retrieve min and max price from request query parameters
        $min_price = $request->input('min_price');
        $max_price = $request->input('max_price');

        // Start building the query for laundry shops
        $query = User::select('id', 'name', 'laundry_shop_address', 'laundry_shop_name', 'address', 'phone_number', 'laundry_shop_open_hours', 'is_shop_closed', 'status')
            ->with(['shops_rating', 'settings', 'shop_services', 'laundry_shop_locations', 'laundry_shop_transaction'])
            ->where('role', 'LaundryShop');

        $ratings = LaundryShopRatings::select('laundry_shop_id', DB::raw('AVG(rating_count) as average_rating'))
            ->groupBy('laundry_shop_id')
            ->get();

        // Apply price range filter if min_price and/or max_price are provided
        if (!is_null($min_price) && !is_null($max_price)) {
            $query->whereHas('shop_services', function ($q) use ($min_price, $max_price) {
                $q->whereBetween('price', [(float)$min_price, (float)$max_price]);
            });
        } elseif (!is_null($min_price)) {
            $query->whereHas('shop_services', function ($q) use ($min_price) {
                $q->where('price', '>=', (float)$min_price);
            });
        } elseif (!is_null($max_price)) {
            $query->whereHas('shop_services', function ($q) use ($max_price) {
                $q->where('price', '<=', (float)$max_price);
            });
        }

        // Execute the query and get the results
        $laundry_shops = $query->get();

        // Retrieve all laundry shop locations
        $laundry_shops_location = LaundryShopLocations::with('laundry_location')->get();

        // Return the response as JSON
        return response()->json([
            'laundry_shops' => $laundry_shops,
            'laundry_shops_location' => $laundry_shops_location,
            'laundry_ratings' => $ratings
        ], 200);
    }



}
