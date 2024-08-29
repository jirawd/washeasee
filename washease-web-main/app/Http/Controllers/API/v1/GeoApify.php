<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class GeoApify extends Controller
{

    public function getAddress(Request $request) {
        // Ensure proper encoding of the address
        $encodedAddress = urlencode($request->address);

        // Construct the Geoapify API URL
        $geoapify_url = 'https://api.geoapify.com/v1/geocode/search?text=' . $encodedAddress .'&format=json&apiKey='. env('GEOAPIFY_API');

        // Make the request using Laravel's HTTP client
        $response = Http::get($geoapify_url);

        // Return the response body
        return $response->body();
    }


}
