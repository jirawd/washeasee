<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserAPI extends Controller
{
    public function user_details($id)
    {

        $user_detail = User::select('name', 'first_name', 'last_name', 'email', 'phone_number', 'role', 'avatar', 'address', 'user_lat', 'user_long')->where('role', 'Customer')->where('id', $id)->first();

        return response()->json($user_detail);
    }

    public function user_transactions($id, $status = null) {
        $query = Transactions::query()->where('customer_id', $id);

        if ($status !== null) {
            $query->where('status', $status);
        }

        $user_laundry = $query->get();

        return $user_laundry;
    }
}
