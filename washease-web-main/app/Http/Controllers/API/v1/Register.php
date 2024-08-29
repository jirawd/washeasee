<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\LaundryShopLocations;
use App\Models\User;
use ErlandMuchasaj\LaravelFileUploader\FileUploader;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use LaravelAdorable\Facades\LaravelAdorable;

class Register extends Controller
{
    public function register(RegisterRequest $request)
    {

        $user = new User;
        $size = 200;
        $hash = Str::uuid()->toString();
        $avatar = LaravelAdorable::get($size, $hash);

        $register_account = $request->validated();

        $user_role = '';
        if ($register_account['role'] === 'Customer') {
            $user_role = 'Customer';
        } else {
            $user_role = 'LaundryShop';
        }

        // Check if 'laundry_shop_permit' key exists in the $register_account array
        if (isset($register_account['laundry_shop_permit'])) {
            // Retrieve the uploaded file
            $laundry_shop_permit = $register_account['laundry_shop_permit'];

            // Check if the file is indeed an instance of UploadedFile
            if ($laundry_shop_permit instanceof UploadedFile) {
                // Store the uploaded file to the public directory
                $response = FileUploader::store($laundry_shop_permit, [
                    'disk' => 'public', // Ensure the public disk is used
                    'path' => 'uploads/laundry_shop_permits', // Specify the path within the public directory
                ]);

                // Assuming FileUploader::store() returns an array with a 'url' key
                $user->laundry_shop_permit = $response['url'] ?? null;
            }
        }

        $user->name = $register_account['first_name'] . ' ' . $register_account['last_name'];
        $user->first_name = $register_account['first_name'];
        $user->last_name = $register_account['last_name'];
        $user->address = $register_account['address'];
        $user->phone_number = $register_account['phone_number'];
        $user->email = $register_account['email'];
        $user->laundry_shop_name = $register_account['laundry_shop_name'] ?? null;
        $user->laundry_shop_address = $register_account['laundry_shop_address'] ?? null;
        $user->is_shop_closed = $register_account['is_shop_closed'] ?? 0;
        $user->user_lat = $register_account['user_lat'] ?? 0;
        $user->user_long = $register_account['user_long'] ?? 0;
        $user->password = password_hash($register_account['password'], PASSWORD_DEFAULT);
        $user->avatar = $avatar;
        $user->role = $user_role;


        if ($user->save() && $user_role === 'LaundryShop') {
            $register_laundry_shop_location = new LaundryShopLocations;
            $register_laundry_shop_location->laundry_shop_id = $user->id;
            $register_laundry_shop_location->latitude = $register_account['laundry_shop_latitude'] ?? null;
            $register_laundry_shop_location->longitude = $register_account['laundry_shop_longitude'] ?? null;
            $latitude = $register_account['laundry_shop_latitude'] ?? null;
            $longitude = $register_account['laundry_shop_longitude'] ?? null;
            $register_laundry_shop_location->long_lat_point = $latitude !== null && $longitude !== null ? $latitude . ',' . $longitude : null;

            $register_laundry_shop_location->save();
        }


        return response()->json([
            'message' => 'Account Created Successfully!',
        ], 201);


    }
}
