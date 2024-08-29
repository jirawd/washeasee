<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Outerweb\FilamentSettings\Filament\Pages\Settings;
use Outerweb\Settings\Models\Setting;

class RiderAPI extends Controller
{
    public function rider_details($rider_id) {

        $rider_details = User::query()
            ->select('name', 'email', 'role', 'laundry_shop_rider_id', 'first_name', 'last_name', 'phone_number')
            ->where('role', 'Rider')
            ->where('id', $rider_id)
            ->first();

        return response()->json([
            'data' => $rider_details
        ]);

    }

    public function getRiderTask($transaction_id) {

        // Fetch the transaction based on the transaction ID
        $transaction = Transactions::find($transaction_id);

        // Validate the transaction
        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        // Fetch customer data
        $customer = User::select('user_lat', 'user_long')
            ->where('id', $transaction->customer_id)
            ->first();

        // Fetch laundry shop data
        $laundryShop = Setting::select('latitude', 'longitude')
            ->where('laundry_shop_id', $transaction->laundry_shop_id)
            ->first();

        $rider = User::query()->where('id', $transaction->rider_id)->first();


        // Validate data
        if (!$customer || !$laundryShop) {
            return response()->json(['error' => 'Customer or Laundry Shop data not found'], 404);
        }

        // Prepare the response data
        $responseData = [
            'transaction_id' => $transaction->id,
            'customer' => [
                'lat' => $customer->user_lat,
                'long' => $customer->user_long,
            ],
            'laundry_shop' => [
                'lat' => $laundryShop->latitude,
                'long' => $laundryShop->longitude,
            ],
            'rider' => [
                'rider_name' => $rider?->name,
                'rider_id' => $rider?->id,
            ]
        ];

        return response()->json($responseData);

    }

    public function getAllRiderTasks($rider_id) {
        $rider = User::query()->where('id', $rider_id)->first();
        if (!$rider) {
            return response()->json(['error' => 'Rider not found'], 404);
        }

        $transactions = Transactions::where('rider_id', $rider_id)->where('customer_type', 'Customer')->get();

        return response()->json([
            'data' => $rider,
            'transactions' => $transactions
        ]);
    }
}
