<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Logout extends Controller
{
    public function logout(Request $request)
    {

        Auth::logout();

        return response()->json([
            'message' => 'Logged out successfully',
            'isAuthenticated' => false
        ]);
    }

    public function logoutWeb(Request $request)
    {

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('customer.login');
    }
}
