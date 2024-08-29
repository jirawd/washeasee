<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Machines;
use App\Models\ServiceCategory;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


class ServicesAPI extends Controller
{
    public function get_all_services()
    {

        $cacheKey = 'service_categories_with_services_page_' . request()->get('page', 1);
        $cacheDuration = 60; // Cache duration in minutes

        $services = Cache::remember($cacheKey, $cacheDuration, function () {
            return Services::with(['service_category', 'laundry_shop'])->get();
        });

        return response()->json($services);

    }

    public function get_all_services_category(Request $request)
    {
        $services_category = Services::with(['service_category', 'laundry_shop'])
            ->select('laundry_shop_id', 'service_category_id', 'service_categories.service_category_name', DB::raw('COUNT(*) as count'))
            ->leftJoin('service_categories', 'services.service_category_id', '=', 'service_categories.id')
            ->where('laundry_shop_id', $request->laundry_shop_id)
            ->groupBy('laundry_shop_id', 'service_category_id', 'service_categories.service_category_name')
            ->get();


        $categories_card = '';
        if (empty($services_category)) {
            $categories_card .= 'No Services Found';
        } else {
            foreach ($services_category as $category) {
                $categories_card .= '
        <div class="card border-secondary border">
            <div class="card-body text-center">
                <h4 class="card-title">' . $category->service_category->service_category_name . '</h4>
                <button class="btn btn-soft-purple">Select This Service</button>
            </div>
        </div>
        ';
            }
        }


        return response()->json([
            'message' => 'Fetch Successully',
            'data' => $services_category,
            'card' => $categories_card
        ]);
    }

    public function get_basic_services_by_laundry_shops(Request $request)
    {
        $basic_services = Services::with('service_category')
            ->where('laundry_shop_id', $request->laundry_shop_id)
            ->whereHas('service_category', function ($query) {
                $query->where('service_category_name', 'Basic Services');
            })
            ->get();

        $dry_cleaning = Services::with('service_category')
            ->where('laundry_shop_id', $request->laundry_shop_id)
            ->whereHas('service_category', function ($query) {
                $query->where('service_category_name', 'Dry Cleaning');
            })
            ->get();

        $ironing = Services::with('service_category')
            ->where('laundry_shop_id', $request->laundry_shop_id)
            ->whereHas('service_category', function ($query) {
                $query->where('service_category_name', 'Ironing');
            })
            ->get();

        $selling_items = Inventory::query()
            ->where('laundry_shop_id', $request->laundry_shop_id)->get();

        $washing_machine =  Machines::query()
            ->where('laundry_shop_id', $request->laundry_shop_id)->get();

        $count_all_available_washing_machine = Machines::query()
            ->where('laundry_shop_id', $request->laundry_shop_id)
            ->where('status', 'Available')
            ->count();

        return response()->json([
            'data' => $basic_services,
            'dry_cleaning' => $dry_cleaning,
            'ironing' => $ironing,
            'selling_items' => $selling_items,
            'washing_machine' => $washing_machine,
            'count_all_available_washing_machine' => $count_all_available_washing_machine
        ]);
    }

    public function get_basic_services_by_laundry_shops_by_id($id)
    {
        $services = Services::with('service_category')
            ->where('laundry_shop_id', $id)
            ->get();

        $selling_items = Inventory::query()
            ->where('laundry_shop_id', $id)->get();

        $washing_machine =  Machines::query()
            ->where('laundry_shop_id', $id)->get();

        return response()->json([
            'data' => $services,
            'selling_items' => $selling_items,
            'washing_machine' => $washing_machine,
        ]);
    }

}
